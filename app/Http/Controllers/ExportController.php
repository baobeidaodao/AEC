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
use App\Models\PartA;
use App\Models\PartB;
use App\Models\PartC;
use App\Models\PartD;
use App\Models\PartE;
use App\Models\PartF;
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

        $partA = $application['part_a'];
        $partAData = PartA::export($partA['id']);
        $data = array_merge($data, $partAData);

        $partB = $application['part_b'];
        $partBData = PartB::export($partB['id']);
        $data = array_merge($data, $partBData);

        $partC = $application['part_c'];
        $partCData = PartC::export($partC['id']);
        $data = array_merge($data, $partCData);

        $partD = $application['part_d'];
        $partDData = PartD::export($partD['id']);
        $data = array_merge($data, $partDData);

        $partE = $application['part_e'];
        $partEData = PartE::export($partE['id']);
        $data = array_merge($data, $partEData);

        $partF = $application['part_f'];
        $partFData = PartF::export($partF['id']);
        $data = array_merge($data, $partFData);

        $exam = $application['exam'];
        $examData = Exam::export($exam['id']);
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