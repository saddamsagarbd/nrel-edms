<?php

namespace App\Exports;

use App\Models\EstEntryFile;
use App\Models\KhatianDagInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EntryFileExport implements FromCollection, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithStrictNullComparison, WithEvents, WithDrawings
{

    protected $criteria;
    protected $collection;
    protected $companyName;
    protected $protectionPassword;

    public function __construct($criteria) {
        $this->criteria = $criteria;
        $this->companyName = "NAVANA REAL ESTATE";
        $this->protectionPassword = config('excel.sheet_protection_password', 'helpdesk@123321');
    }

    protected function applyCriteria($criteria, $query)
    {        
        if (isset($criteria['from_date'], $criteria['to_date'])) {
            $fromDate = $criteria['from_date'] . ' 00:00:00';
            $toDate = $criteria['to_date'] . ' 23:59:59';
            $query->whereBetween('est_entry_files.created_at', [$fromDate, $toDate]);
        }

        if (!empty($criteria['mouza']) && $criteria['mouza'] !== 'all') {
            $query->where('est_entry_files.mouza_id', $criteria['mouza']);
        }
        
        if (!empty($criteria['khatian_type']) && $criteria['khatian_type'] !== 'all') {
            $query->where('est_entry_files.khatype_id', $criteria['khatian_type']);
        }
        
        if (!empty($criteria['dag']) && $criteria['dag'] !== 'all') {
            $query->where('est_entry_files.dag_id', $criteria['dag']); // Changed to dag_id
        }
        
        if (!empty($criteria['project']) && $criteria['project'] !== 'all') {
            $query->where('est_entry_files.project_id', $criteria['project']);
        }
    }

    public function getDagData($id){
        $dag_data = KhatianDagInfo::where('id', $id)->first();
        if($dag_data){
            return $dag_data;
        }
        return null;
    }

    public function collection()
    {
        $user = Auth::user();
        $getTeamMems = teamMembers();

        // Base query - optimized version

        $query = EstEntryFile::query()
            ->with([
                'entryDagData',
                'mouza',
                'entryDeed' => function ($q) {
                    $q->leftJoin('estate_look_ups as elo', 'est_entry_file_deeds.deed_type', '=', 'elo.data_keys')
                    ->where('elo.data_type', 'deed.type')
                    ->select('est_entry_file_deeds.*', 'elo.data_values as deed_name');
                }
            ])
            ->leftJoin('users', 'users.id', '=', 'est_entry_files.user_id')
            ->select('est_entry_files.*', 'users.name as username');

        if ($user->type !== 'admin') {
            $query->leftJoin('khatian_dag_infos', 'est_entry_files.mouza_id', '=', 'khatian_dag_infos.id');
        }


        // Apply user-specific filters
        if ($user->type !== 'admin') {
            if (!empty($getTeamMems) && count($getTeamMems) > 1) {
                $query->whereIn('est_entry_files.user_id', $getTeamMems);
            } else {
                $userProjects = userProjects($user->id);
                $query->whereIn('est_entry_files.project_id', $userProjects);
            }
        }

        $this->applyCriteria($this->criteria, $query);

        $entryFiles = $query->latest()->get();

        $data = $entryFiles->map(function ($item) {

            $landowners = $item->landownersData->pluck('name')->implode(', ');

            $entryDagData = $item->entryDagData->map(function ($dag) use ($item) {
                $sa = $this->getDagData($dag->sadag_id);
                $rsDagData = $item->khatype_id == 3 ? $this->getDagData($dag->dag_id) : $this->getDagData($dag->rsdag_id);
                $bsDagData = $item->khatype_id == 4 ? $this->getDagData($dag->dag_id) : null;

                return [
                    'sa_khatian' => $sa->khatian_no ?? 'N/A',
                    'sa_dag' => $sa->dag_no ?? 'N/A',
                    'rs_khatian' => $rsDagData->khatian_no ?? 'N/A',
                    'rs_dag' => $rsDagData->dag_no ?? 'N/A',
                    'bs_khatian' => $bsDagData->khatian_no ?? 'N/A',
                    'bs_dag' => $bsDagData ? $dag->dag_no : 'N/A',
                    'dag_land' => $this->getDagData($dag->dag_id)->dag_land ?? 'N/A',
                    'pur_land' => $dag->purchase_land ?? 0,
                ];
            });

            $entryDeed = $item->entryDeed ? $item->entryDeed->map(function ($deed) {
                return ['deed_no' => $deed->deed_no ?? 'N/A'];
            }) : collect();

            return [
                'sl' => $item->id,
                'file_no' => $item->file_no ?? 'N/A',
                'deed_no' => $entryDeed->isNotEmpty() ? $entryDeed->pluck('deed_no')->implode(', ') : 'N/A',
                'mouza' => optional($item->mouza)->name ?? 'N/A',
                'vendee' => $landowners != "" ? $landowners : 'N/A',
                'vendor' => optional($item->buyerName)->data_values ?? 'N/A',
                'sa_khatian' => optional($entryDagData)->pluck('sa_khatian')->filter()->implode(', ') ?: 'N/A',
                'rs_khatian' => optional($entryDagData)->pluck('rs_khatian')->filter()->implode(', ') ?: 'N/A',
                'bs_khatian' => optional($entryDagData)->pluck('bs_khatian')->filter()->implode(', ') ?: 'N/A',
                'sa_dag' => optional($entryDagData)->pluck('sa_dag')->filter()->implode(', ') ?: 'N/A',
                'rs_dag' => optional($entryDagData)->pluck('rs_dag')->filter()->implode(', ') ?: 'N/A',
                'bs_dag' => optional($entryDagData)->pluck('bs_dag')->filter()->implode(', ') ?: 'N/A',
                'dag_land' => optional($entryDagData)->pluck('dag_land')->filter()->implode(', ') ?: 'N/A',
                'purchase_land' => optional($entryDagData)->pluck('pur_land')->filter()->implode(', ') ?: 'N/A',
                't_pur_rs' => $item->t_pur_rs ?? 'N/A',
                'm_jote' => $item->m_jote ?? 'N/A',
                'created_by' => $item->username ?? 'N/A',
            ];
        })->filter(function ($row) {
            return !empty($row['file_no']);
        });

        return $this->collection = $data;
    }


    public function styles(Worksheet $sheet)
    {
        // Move static styles here from AfterSheet, e.g. header row color
        return [
            'A4:Q4' => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '166f39'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function headings(): array
    {
        return [
            '#ID',
            'File.No',
            'Deed.NO',
            'Mouza',
            'Vendee',
            'Vendor',
            'SA.Khatian',
            'RS.Khatian',
            'BS.Khatian',
            'SA.DAG',
            'RS.DAG',
            'BS.DAG',
            'DAG.LAND',
            'PUR.LAND',
            'T.PUR.RS',
            'M.JOTE',
            'Created.By'
        ];
    }

    public function map($row): array
    {
        $mapped = [
            $row["sl"]?? 'N/A',
            $row["file_no"] ?? 'N/A',
            $row["deed_no"] ?? 'N/A',
            $row["mouza"] ?? 'N/A',
            $row["vendee"] ?? 'N/A',
            $row["vendor"] ?? 'N/A',
            $row["sa_khatian"] ?? 'N/A',
            $row["rs_khatian"] ?? 'N/A',
            $row["bs_khatian"] ?? 'N/A',
            $row["sa_dag"] ?? 'N/A',
            $row["rs_dag"] ?? 'N/A',
            $row["bs_dag"] ?? 'N/A',
            $row["dag_land"] ?? 'N/A',
            $row["purchase_land"] ?? 'N/A',
            $row["t_pur_rs"] ?? 'N/A',
            $row["m_jote"] ?? 'N/A',
            $row["created_by"] ?? 'N/A',
        ];

        Log::debug('Mapped row:', $mapped);

        return $mapped;
    }

    public function title(): string
    {
        return 'Entry File Report';
    }

    public function drawings()
    {
        $company_id = 100;
        $file = public_path("backend/assets/images/logos/{$company_id}.png");

        if (!file_exists($file)) {
            return [];  // safer than null for Maatwebsite Excel
        }

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Company Logo');
        $drawing->setPath($file);
        $drawing->setWidth(80);
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(20);
        $drawing->setOffsetY(20);

        return [$drawing]; // return as an array for multiple drawings support
    }

    public function startCell(): string
    {
        return 'A4'; // Heading will now appear in row 4
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $reportTitle = 'Entry File Report' .
                    (isset($this->criteria["from_date"], $this->criteria["to_date"]) 
                    ? ' from ' . date('d-m-Y', strtotime($this->criteria["from_date"])) . 
                    ' to ' . date('d-m-Y', strtotime($this->criteria["to_date"])) 
                    : '');

                $pageHeader = $this->companyName . "\n" . $reportTitle;
                $footerText = 'Designed & Developed by IC&T Department | © 2024 NAVANA All Rights Reserved';

                // Header Row
                $sheet->setCellValue('A1', $pageHeader);
                $sheet->mergeCells('A1:Q1');
                $sheet->getRowDimension(1)->setRowHeight(75);
                $sheet->getStyle('A1:Q1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 20],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                // Footer Row
                $sheet->setCellValue('A2', $footerText);
                $sheet->mergeCells('A2:Q2');
                $sheet->getStyle('A2:Q2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 8,
                        'color' => ['rgb' => '000000'],
                        'name' => 'Arial'
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ]
                ]);

                $sheet->setCellValue('A3', "Developer");
                $sheet->mergeCells('A3:Q3');
                $sheet->getStyle('A3:Q3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 8,
                        'color' => ['rgb' => 'ffffff'],
                        'name' => 'Arial'
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ]
                ]);

                // Autofilter, borders and alignment are kept as is

                // Apply horizontal and vertical centering for all cells in data range
                $lastColumn = $sheet->getHighestColumn(); // e.g., 'H'
                $lastRow = 4 + $this->collection()->count(); // assuming heading at row 4

                $headingRange = 'A4:' . $lastColumn . '4';

                $sheet->getStyle($headingRange)->getFont()->setBold(true);
                $sheet->getStyle($headingRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($headingRange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $cellRange = 'A5:' . $lastColumn . $lastRow;

                $sheet->getStyle($cellRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                foreach (range('A', $lastColumn) as $columnID) {

                    if(in_array($columnID, ["B", "D"])){
                        $sheet->getColumnDimension($columnID)->setAutoSize(false)->setWidth(25);
                    }else{
                        $sheet->getColumnDimension($columnID)->setAutoSize(false)->setWidth(15);
                    }

                }

                // Set print options for landscape orientation and fit to page
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 4);

                //===============
                // Watermark
                //===============
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // Create the HeaderFooterDrawing instance
                $watermark = new HeaderFooterDrawing();
                $watermark->setPath(public_path('backend/assets/images/watermark/confidential-logo.png'));

                // Optional: adjust size or other properties if needed
                $watermark->setHeight(100);  // for example, set height to 100 pixels

                $headerFooter = $sheet->getHeaderFooter();
                // $headerFooter->setOddHeader('&C&H&KCCCCCC&16CONFIDENTIAL');
                $headerFooter->setOddHeader('&C&G');
                $headerFooter->addImage($watermark, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_CENTER);

                //===============
                // Page Setup
                //===============

                // Adjust margins for printing
                $sheet->getPageMargins()->setTop(0.2);
                $sheet->getPageMargins()->setRight(0.2);
                $sheet->getPageMargins()->setLeft(0.2);
                $sheet->getPageMargins()->setBottom(0.75);

                $sheet->getPageSetup()->setScale(80)->setFitToPage(true)->setHorizontalCentered(true);

                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0);

                // Set footer with user and timestamp
                $sheet->getHeaderFooter()->setOddFooter(
                    '&L Printed By ' . ucfirst(Auth::user()->name) . ', ' . Carbon::now() . ' &RPage &P of &N'
                );

                // Sheet protection with configurable password
                $sheet->getProtection()->setSheet(true);
                $sheet->getProtection()->setSort(true);
                $sheet->getProtection()->setInsertRows(true);
                $sheet->getProtection()->setInsertColumns(true);
                $sheet->getProtection()->setDeleteRows(true);
                $sheet->getProtection()->setDeleteColumns(true);
                $sheet->getProtection()->setPassword($this->protectionPassword);
            },
        ];
    }

}