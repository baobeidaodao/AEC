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
use App\Models\PartA;
use App\Models\PartB;
use App\Models\PartC;
use App\Models\PartD;
use App\Models\PartE;
use App\Models\PartF;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    const SECTION_MAP = [
        'B' => 0,
        'D' => 1,
        'F' => 2,
        'H' => 3,
        'I' => 4,
        'J' => 5,
        'K' => 6,
        'M' => 7,
        'O' => 8,
        'P' => 9,
        'R' => 10,
        'T' => 11,
        'U' => 12,
        'V' => 13,
        'W' => 14,
        'X' => 15,
        'Y' => 16,
        'Z' => 17,
    ];

    public function export($id)
    {
        $data = [];
        $application = Application::with(Application::WITH)
            ->where('id', '=', $id)
            ->first()
            ->toArray();

        $exam = $application['exam'];
        $examData = Exam::export($exam['id']);
        $data = array_merge($data, $examData);

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

        $fileName = 'AEC_' . $id . '_' . $partA['school_name'] . '.xlsx';

        $aec = resource_path('excel/aec.xlsx');
        $aec_ = resource_path('excel/aec_.xlsx');
        $part = resource_path('excel/part.xlsx');
        $exam = resource_path('excel/exam.xlsx');

        $tempPath = storage_path($fileName);
        //$exportFile = Storage::disk('local')->copy($aec_, $tempPath);
        copy($aec_, $tempPath);

        Excel::load($tempPath, function ($excel) use ($data) {
            foreach ($data as $sheetName => $sheetData) {
                if (in_array($sheetName, ['section_1', 'section_2', 'section_3', 'section_4', 'section_5', 'section_6', 'section_7',])) {
                    $excel->sheet($sheetName, function ($sheet) use ($sheetData) {
                        foreach ($sheetData as $index => $rowData) {
                            if ($index >= 1) {
                                $row = intval($index + 1);
                                foreach (self::SECTION_MAP as $column => $item) {
                                    $cellName = $column . $row;
                                    $cellValue = $rowData[$item];
                                    $sheet->cell($cellName, function ($cell) use ($cellValue) {
                                        $cell->setValue($cellValue);
                                    });
                                }
                            }
                        }
                    });
                }
                if (in_array($sheetName, ['part_a', 'part_a', 'part_b', 'part_c', 'part_d', 'part_e', 'part_f',])) {
                    $excel->sheet($sheetName, function ($sheet) use ($sheetData) {
                        $sheet->rows($sheetData);
                    });
                }
            }
        })->export('xlsx');

        unlink($tempPath);

    }

}