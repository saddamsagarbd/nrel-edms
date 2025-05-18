<?php

namespace App\Http\Controllers;

use App\Exports\EntryFileExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportManageController extends Controller
{
    public function entryFileExcel(Request $request)
    {
        $criteria = $request->criteria;
        $fileName = "entry_file_".time().".xlsx";
        
        // Correct way to call with headers
        return Excel::download(
            new EntryFileExport($criteria), 
            $fileName,
            \Maatwebsite\Excel\Excel::XLSX, // This should be a string, not array
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
        );
    }

    public function entryFilePdf(Request $request)
    {
        $criteria = $request->criteria;
        $fileName = "entry_file_".time().".pdf";
        
        return Excel::download(
            new EntryFileExport($criteria), 
            $fileName,
            \Maatwebsite\Excel\Excel::DOMPDF, // Writer type for PDF
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }
}
