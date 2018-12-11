<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-28
 * Time: 19:00
 */

namespace App\Http\Controllers;


use App\Models\Application;
use App\Models\Exam;
use App\Models\Item;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export($id)
    {
        $data = [];
        $application = Application::with(Application::WITH)
            ->where('id', '=', $id)
            ->first()
            ->toArray();
        $exam = $application['exam'];
        $examData = Exam::exportData($exam['id']);
        $data = array_merge($data, $examData);
        $fileName = $id;
        Excel::create($fileName, function ($excel) use ($data) {
            foreach ($data as $sheetName => $cellData) {
                $excel->sheet($sheetName, function ($sheet) use ($cellData) {
                    $sheet->rows($cellData);
                });
            }
            // ob_end_clean();
        })->export('xlsx');

    }
}