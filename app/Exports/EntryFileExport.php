<?php

namespace App\Exports;

use App\Models\EstateVendor;
use App\Models\EstEntryFile;
use App\Models\KhatianDagInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\{
    FromCollection, WithTitle, WithHeadings, WithMapping,
    ShouldAutoSize, WithStyles, WithStrictNullComparison,
    WithEvents, WithDrawings
};
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\{
    Worksheet\Worksheet,
    Style\Alignment,
    Style\Fill,
    Worksheet\Drawing,
    Worksheet\HeaderFooterDrawing
};
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EntryFileExport implements FromCollection, WithTitle, WithHeadings, WithMapping, 
    ShouldAutoSize, WithStyles, WithStrictNullComparison, WithEvents
{
    protected $criteria;
    protected $collection;
    protected $companyName = "NAVANA REAL ESTATE LTD.";
    protected $protectionPassword;

    public function __construct($criteria) 
    {
        $this->criteria = $criteria;
        $this->protectionPassword = config('excel.sheet_protection_password', 'helpdesk@123321');
    }

    protected function applyCriteria($criteria, $query)
    {        
        
        if (isset($criteria['from_date'], $criteria['to_date'])) {
            $fromDate = $criteria['from_date'] . ' 00:00:00';
            $toDate = $criteria['to_date'] . ' 23:59:59';
            $query->whereBetween('est_entry_file_deeds.deed_date', [$fromDate, $toDate]);
        }

        if (!empty($criteria['mouza']) && $criteria['mouza'] !== 'all') {
            $query->where('est_entry_files.mouza_id', $criteria['mouza']);
        }
        
        if (!empty($criteria['khatian_type']) && $criteria['khatian_type'] !== 'all') {
            $query->where('est_entry_files.khatype_id', $criteria['khatian_type']);
        }
        
        if (!empty($criteria['dag']) && $criteria['dag'] !== 'all') {
            $query->whereHas('entryDagData', function($q) use ($criteria) {
                $q->where('est_entry_file_dags.dag_id', $criteria['dag']);
            });
        }
        
        if (!empty($criteria['project']) && $criteria['project'] !== 'all') {
            $query->where('est_entry_files.project_id', $criteria['project']);
        }

    }

    public function getDagData($id)
    {
        return KhatianDagInfo::where('id', $id)->first() ?? null;
    }

    public function collection()
    {
        $user = Auth::user();
        $getTeamMems = teamMembers();
        $criteria = $this->criteria ?? [];
        $dagId = $criteria['dag_info'] ?? null;

        $query = EstEntryFile::with([
            'entryDagData', 'agent', 'mouza', 'buyerName', 'entryDeed', 'entryMutation'
        ])
            ->leftJoin('users', 'users.id', '=', 'est_entry_files.user_id')
            ->leftJoin('estate_projects', 'estate_projects.id', '=', 'est_entry_files.project_id')
            ->leftJoin('est_entry_file_deeds', 'est_entry_file_deeds.entfile_id', '=', 'est_entry_files.id')
            ->select(
                'est_entry_files.*',
                'est_entry_file_deeds.deed_date',
                'estate_projects.name as project_name',
                'users.name as username'
            )
            ->distinct();

        if ($user->type !== 'admin') {
            if (!empty($getTeamMems) && count($getTeamMems) > 1) {
                $query->whereIn('est_entry_files.user_id', $getTeamMems);
            } else {
                $userProjects = userProjects($user->id);
                if (is_array($userProjects) && !empty($userProjects)) {
                    $query->whereIn('est_entry_files.project_id', $userProjects);
                }
            }
        }

        $this->applyCriteria($criteria, $query);

        return $this->collection = $query->orderBy('est_entry_file_deeds.deed_date', 'DESC')->latest()->get()->filter(function ($item) use ($dagId) {
            return !$dagId || $item->entryDagData->contains(function ($dag) use ($item, $dagId) {
                return $item->khatype_id == 3
                    ? $dag->dag_id == $dagId
                    : $dag->rsdag_id == $dagId;
            });
        })->map(function ($item) use ($dagId) {
            $owner = '';
            if ($item->landowners) {
                $owner = EstateVendor::whereIn('id', $item->landowners)->pluck('name')->implode(', ');
            }

            $entryDagData = $item->entryDagData
                ->filter(function ($dag) use ($item, $dagId) {
                    return !$dagId || (
                        $item->khatype_id == 3
                            ? $dag->dag_id == $dagId
                            : $dag->rsdag_id == $dagId
                    );
                })
                ->map(function ($dag) use ($item) {
                    $dagInfo = $this->getDagData($dag->dag_id);
                    $saDag = $dagInfo ? $this->getDagData($dagInfo->sadag_id) : null;
                    $rsDag = $dagInfo ? $this->getDagData($dagInfo->rsdag_id) : null;

                    $rsKhatian = $rsDag ? $rsDag->khatian_no : '';
                    $rsDagNo = $rsDag ? $rsDag->dag_no : '';

                    if ($item->khatype_id == 3) {
                        $mainDag = $this->getDagData($dag->dag_id);
                        $rsKhatian = $mainDag ? $mainDag->khatian_no : '';
                        $rsDagNo = $mainDag ? $mainDag->dag_no : '';
                    }

                    $bsKhatian = ($item->khatype_id == 4)
                        ? optional($this->getDagData($dag->dag_id))->khatian_no ?? ''
                        : '...';

                    $bsDagNo = ($item->khatype_id == 4)
                        ? optional($this->getDagData($dag->dag_id))->dag_no ?? ''
                        : '...';

                    return [
                        'sa_khatian' => $saDag ? $saDag->khatian_no : '',
                        'sa_dag' => $saDag ? $saDag->dag_no : '',
                        'rs_khatian' => $rsKhatian,
                        'rs_dag' => $rsDagNo,
                        'bs_khatian' => $bsKhatian,
                        'bs_dag' => $bsDagNo,
                        'dag_land' => $dagInfo ? $dagInfo->dag_land : '',
                        'pur_land' => $dag->purchase_land ?? 0,
                    ];
                });

            return [
                'file_no' => $item->id ?? '',
                'deed_date' => $item->deed_date ?? '',
                'media_name' => $item->agent->name ?? '',
                'mouza_name' => $item->mouza->name ?? '',
                'buyer_name' => $item->buyerName->data_values ?? '',
                'landowner' => $owner,
                'project' => $item->project_name ?? '',
                'deed_no' => $item->entryDeed->pluck('deed_no')->implode(', ') ?? '',
                'sa_khatian' => $entryDagData->pluck('sa_khatian')->filter()->implode(', '),
                'sa_dag' => $entryDagData->pluck('sa_dag')->filter()->implode(', '),
                'rs_khatian' => $entryDagData->pluck('rs_khatian')->filter()->implode(', '),
                'rs_dag' => $entryDagData->pluck('rs_dag')->filter()->implode(', '),
                'bs_khatian' => $entryDagData->pluck('bs_khatian')->filter()->implode(', '),
                'bs_dag' => $entryDagData->pluck('bs_dag')->filter()->implode(', '),
                'dag_land' => $entryDagData->pluck('dag_land')->filter()->implode(', '),
                'pur_land' => $entryDagData->pluck('pur_land')->filter()->implode(', '),
                'total_pur_land' => $entryDagData->pluck('pur_land')->sum(),
                'mland_size' => $item->entryMutation->pluck('mland_size')->implode(', '),
                'created_by' => $item->username ?? '',
                'entryDagData' => $entryDagData,
            ];
        });
    }

    public function collection_old()
    {
        $user = Auth::user();
        $getTeamMems = teamMembers();

        $query = EstEntryFile::with(['entryDagData'])
                ->leftJoin('users', 'users.id', '=', 'est_entry_files.user_id')
                ->leftJoin('estate_projects', 'estate_projects.id', '=', 'est_entry_files.project_id')
                ->leftJoin('est_entry_file_deeds', 'est_entry_file_deeds.entfile_id', '=', 'est_entry_files.id')
                ->select(
                    'est_entry_files.*', 
                    'est_entry_file_deeds.deed_date', 
                    'estate_projects.name as project_name', 
                    'estate_projects.project_type as project_type', 
                    'estate_projects.land_type as land_type', 
                    'estate_projects.address as project_address', 
                    'users.name as username'
                )
                ->distinct();

        if ($user->type !== 'admin') {
            if (!empty($getTeamMems) && count($getTeamMems) > 1) {
                $query->whereIn('est_entry_files.user_id', $getTeamMems);
            } else {
                $userProjects = userProjects($user->id);
                if(is_array($userProjects) && !empty($userProjects)) $query->whereIn('est_entry_files.project_id', $userProjects);
            }
        }

        $this->applyCriteria($this->criteria, $query);

        return $this->collection = $query->orderBy('est_entry_file_deeds.deed_date', 'DESC')->latest()->get()->map(function ($item) {

            $owner='';
            if($item->landowners):
                foreach(EstateVendor::whereIn('id', $item->landowners)->get() as $lw):
                    $owner .= $lw->name;
                endforeach;
            endif;
            
            $entryDagData = $item->entryDagData->map(function ($dag) use ($item) {
                // Since we removed the join in the eager load, we need to get related data manually
                $dagInfo = $this->getDagData($dag->dag_id);
                $sa_dag = $dagInfo ? $this->getDagData($dagInfo->sadag_id) : null;
                $rs_dag = $dagInfo ? $this->getDagData($dagInfo->rsdag_id) : null;
                
                // Get RS data based on khatype
                $rs_khatian = $rs_dag ? $rs_dag->khatian_no : '';
                $rs_dag_no = $rs_dag ? $rs_dag->dag_no : '';
                
                if ($item->khatype_id == 3) {
                    $main_dag = $this->getDagData($dag->dag_id);
                    $rs_khatian = $main_dag ? $main_dag->khatian_no : '';
                    $rs_dag_no = $main_dag ? $main_dag->dag_no : '';
                }
                
                // Get BS data only for type 4
                $bs_khatian = ($item->khatype_id == 4) ? optional($this->getDagData($dag->dag_id))->khatian_no ?? '' : '...';
                $bs_dag_no = ($item->khatype_id == 4) ? optional($this->getDagData($dag->dag_id))->dag_no ?? '' : '...';
                
                return [
                    'sa_khatian' => $sa_dag ? $sa_dag->khatian_no : '',
                    'sa_dag' => $sa_dag ? $sa_dag->dag_no : '',
                    'rs_khatian' => $rs_khatian,
                    'rs_dag' => $rs_dag_no,
                    'bs_khatian' => $bs_khatian,
                    'bs_dag' => ($item->khatype_id == 4) ? optional($this->getDagData($dag->dag_id))->dag_no ?? '' : '...',
                    'dag_land' => $dagInfo ? $dagInfo->dag_land : '',
                    'pur_land' => $dag->purchase_land ?? 0,
                ];
            });

            $entryDeed = $item->entryDeed->pluck('deed_no')->implode(', ') ?: '';
            $entryMutation = $item->entryMutation->pluck('mland_size')->implode(', ') ?: '';

            return [
                'sl' => $item->id,
                'file_no' => $item->file_no ?? '',
                'project_name' => $item->project_name,
                'deed_no' => $entryDeed,
                'mouza' => $item->mouza->name ?? '',
                'vendee' => !empty($item->buyerName->data_values)? $item->buyerName->data_values : '',
                'vendor' => $owner,
                'sa_khatian' => $entryDagData->pluck('sa_khatian')->filter()->implode(', ') ?: '',
                'rs_khatian' => $entryDagData->pluck('rs_khatian')->filter()->implode(', ') ?: '',
                'bs_khatian' => $entryDagData->pluck('bs_khatian')->filter()->implode(', ') ?: '',
                'sa_dag' => $entryDagData->pluck('sa_dag')->filter()->implode(', ') ?: '',
                'rs_dag' => $entryDagData->pluck('rs_dag')->filter()->implode(', ') ?: '',
                'bs_dag' => $entryDagData->pluck('bs_dag')->filter()->implode(', ') ?: '',
                'dag_land' => $entryDagData->pluck('dag_land')->filter()->implode(', ') ?: '',
                'purchase_land' => $entryDagData->pluck('pur_land')->filter()->implode(', ') ?: '',
                'total_purchase_land' => $entryDagData->sum('pur_land'),
                'total_purchase_rs' => $item->t_pur_rs ?? '',
                'mland_size' => $entryMutation ?? '',
                'mjoth_no' => $entryMutation,
                'created_at' => date('d-m-Y', strtotime($item->created_at)),
                'created_by' => $item->username ?? '',
            ];
        })->filter(fn($row) => !empty($row['file_no']));
    }

    public function headings(): array
    {
        return [
        ];
    }

    public function map($row): array
    {
        return [
        ];
    }

    public function styles(Worksheet $sheet)
    {
        
    }

    public function title(): string
    {
        return "Entry Files Report";

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                
                $sheet = $event->sheet->getDelegate();

                $headings = [
                    'A' => '#ID',
                    'B' => 'Deed Date',
                    'C' => 'File.No',
                    'D' => 'Prj. Name',
                    'E' => 'Deed.NO',
                    'F' => 'Mouza',
                    'G' => 'Vendor',
                    'H' => 'Vandee',
                    'I' => 'SA.kh',
                    'J' => 'RS.kh',
                    'K' => 'BS.kh',
                    'L' => 'SA.dg',
                    'M' => 'RS.dg',
                    'N' => 'BS.dg',
                    'O' => 'DAG.LAND',
                    'P' => 'PUR.LAND',
                    'Q' => 'T.PUR.LAND',
                    'R' => 'M.LAND',
                    'S' => 'Created.By',
                ];

                $sheet->setCellValue('A1', '{{COMPANY_LOGO}}');

                $drawing = new Drawing();
                $company_id = 100;
                $drawing->setName($this->companyName);
                
                $file = public_path('backend/assets/images/logos/'. $company_id .'.png');
                if (file_exists($file)) {
                    $drawing->setPath($file);
                } else {
                    throw new \Exception("Logo file not found at path: " . $file);
                }
                $drawing->setHeight(60);
                $drawing->setWidth(150);
                $drawing->setCoordinates('A1');
                $drawing->setOffsetX(10);

                $imageHeight = $drawing->getHeight() ?? 60;
                $logoRowHeight = $imageHeight * 0.75;
                $sheet->getRowDimension(1)->setRowHeight($logoRowHeight);

                $sheet->getStyle('A1:S1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'name' => 'Arial'
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                        'wrapText' => true,
                        'indent' => 2,
                    ],
                ]);

                $sheet->setCellValue('A1', $this->companyName);
                $sheet->mergeCells('A1:S1');

                $sheet->getStyle('A1:S1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $title = 'EDMS File Registration Report' . 
                    (
                        (isset($this->criteria["from_date"], $this->criteria["to_date"]) 
                        ? ' from ' . date('d-m-Y', strtotime($this->criteria["from_date"])) . 
                        ' to ' . date('d-m-Y', strtotime($this->criteria["to_date"])) 
                        : '')
                    );
                $sheet->setCellValue('A2', $title);
                $sheet->getStyle('A2:S2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'name' => 'Arial'
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                        'indent' => 2,
                    ],
                ]);

                $sheet->mergeCells('A2:S2');

                $sheet->setCellValue('A3', 'Designed & Developed by IC&T Department | © 2024 NAVANA All Rights Reserved');

                $sheet->mergeCells('A3:S3');

                $sheet->getStyle('A3:S3')->applyFromArray([
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
                        'indent' => 2,
                    ]
                ]);

                $sheet->getRowDimension(3)->setRowHeight(15);
                
                foreach ($headings as $col => $heading) {
                    $sheet->setCellValue($col . '4', $heading);
                }

                $sheet->getStyle('A4:S4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['rgb' => 'FFFFFF'],
                        'name' => 'Arial'
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4F81BD']
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                        'indent' => 2,
                    ]
                ]);

                foreach (range('A', 'S') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(12);
                    $sheet->getStyle($col . '1:' . $col . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                }

                $rowCount = $sheet->getHighestRow();

                for ($i = 5; $i <= $rowCount; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(20); // Adjust height as needed
                }
                
                $startingRow = 4;

                $datas = $this->collection;

                $endingRow = $startingRow + count($datas);

                $sl = $idx = 1;

                foreach($datas as $key => $data){

                    $row = $startingRow + $idx;

                    $sheet->setCellValue('A'. $row, $sl ?? '');
                    $sheet->setCellValue('B'. $row, $data['deed_date'] ?? '');
                    $sheet->setCellValue('C'. $row, $data['file_no'] ?? '');
                    $sheet->setCellValue('D'. $row, $data['project'] ?? '');
                    $sheet->setCellValue('E'. $row, $data['deed_no'] ?? '');
                    $sheet->setCellValue('F'. $row, $data['mouza_name'] ?? '');
                    $sheet->setCellValue('G'. $row, $data['buyer_name'] ?? '');
                    $sheet->setCellValue('H'. $row, $data['landowner'] ?? '');
                    $sheet->setCellValue('I'. $row, $data['sa_khatian'] ?? '');
                    $sheet->setCellValue('J'. $row, $data['rs_khatian'] ?? '');
                    $sheet->setCellValue('K'. $row, $data['bs_khatian'] ?? '');
                    $sheet->setCellValue('L'. $row, $data['sa_dag'] ?? '');
                    $sheet->setCellValue('M'. $row, $data['rs_dag'] ?? '');
                    $sheet->setCellValue('N'. $row, $data['bs_dag'] ?? '');
                    $sheet->setCellValue('O'. $row, $data['dag_land'] ?? '');
                    $sheet->setCellValue('P'. $row, $data['pur_land'] ?? '');
                    $sheet->setCellValue('Q'. $row, $data['total_pur_land'] ?? '');
                    $sheet->setCellValue('R'. $row, $data['mland_size'] ?? '');
                    $sheet->setCellValue('S'. $row, $data['created_by'] ?? '');

                    $sl++;
                    $idx++;
                }

                $style = [
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                        'indent' => 2,
                    ],
                    'font' => [
                        'size' => 10,
                        'name' => 'Arial'
                    ]
                ];

                $sheet->getStyle('A4:T' . $sheet->getHighestRow())->applyFromArray($style);

                // Add total sum formula to the next row after the last data row
                $totalRow = $endingRow + 1; // Row where the total will be displayed
                $sheet->setCellValue('A' . $totalRow, 'Total'); // Optional label in column A
                $sheet->mergeCells('A'. $totalRow .':N'.$totalRow);
                $sheet->getStyle('A'. $totalRow .':N'.$totalRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'name' => 'Arial'
                    ],
                    'alignment' => [
                        'horizontal' => 'right',
                        'vertical' => 'center',
                        'wrapText' => true,
                        'indent' => 2,
                    ],
                ]);

                $totalDagLand = $datas->map(fn($row) => [
                                    'dag_no' => $row['sa_dag'] ?? $row['rs_dag'] ?? $row['bs_dag'] ?? null,
                                    'land' => floatval($row['dag_land'] ?? 0),
                                ])
                                ->unique('dag_no')
                                ->sum('land');

                $sheet->setCellValue('O' . $totalRow, floatval($totalDagLand));
                
                $sheet->setCellValue('P' . $totalRow, '=SUM(P' . $startingRow . ':P' . $endingRow . ')');
                $sheet->setCellValue('Q' . $totalRow, '=SUM(Q' . $startingRow . ':Q' . $endingRow . ')');
                $sheet->setCellValue('R' . $totalRow, '=SUM(R' . $startingRow . ':R' . $endingRow . ')');

                $sheet->getStyle('O'. $totalRow .':R'.$totalRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'name' => 'Arial'
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                        'wrapText' => true,
                        'indent' => 2,
                    ],
                ]);

                $sheet->freezePane('A'.($startingRow + 1));

                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 4);
                
                $sheet->getPageMargins()->setTop(0.2);
                $sheet->getPageMargins()->setRight(0.1);
                $sheet->getPageMargins()->setLeft(0.1);
                $sheet->getPageMargins()->setBottom(0.5);

                $sheet->getPageSetup()->setScale(80)->setFitToPage(true)->setHorizontalCentered(true);

                for ($i = 16; $i <= $rowCount; $i += 13) {
                    $sheet->setBreak('A' . $i, Worksheet::BREAK_ROW);
                }

                $sheet->getPageSetup()->setPrintArea('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow());


                $sheet->getPageSetup()->setFitToWidth(1)->setFitToHeight(0);

                $sheet->getHeaderFooter()->setOddFooter(
                    '&L Printed By '. ucfirst(Auth::user()->name) .', '. Carbon::now() .' &RPage &P of &N'
                );
        
                $sheet->getProtection()->setSheet(true);
                $sheet->getProtection()->setSort(true);
                $sheet->getProtection()->setInsertRows(true);
                $sheet->getProtection()->setInsertColumns(true);
                $sheet->getProtection()->setDeleteRows(true);
                $sheet->getProtection()->setDeleteColumns(true);
                $sheet->getProtection()->setPassword("helpdesk@123321");

                $drawing->setWorksheet($sheet);
            },
        ];
    }

    
}