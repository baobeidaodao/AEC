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

    const SECTION_ARRAY = [
        'section_1',
        'section_2',
        'section_3',
        'section_4',
        'section_5',
        'section_6',
        'section_7',
        'section_8',
        'section_9',
        'section_10',
        'section_11',
        'section_12',
        'section_13',
        'section_14',
        'section_15',
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

        $countData = self::totalCount($id);
        $data = array_merge($data, $countData);

        $fileName = 'AEC_' . $id . '_' . $partA['school_name'] . '.xlsx';

        $aec = resource_path('excel/aec.xlsx');
        $aec_ = resource_path('excel/aec_.xlsx');
        $aec_1 = resource_path('excel/aec_1.xlsx');
        $aec_2 = resource_path('excel/aec_2.xlsx');
        $aec_3 = resource_path('excel/aec_3.xlsx');
        $aec_4 = resource_path('excel/aec_4.xlsx');
        $aec_5 = resource_path('excel/aec_5.xlsx');
        $part = resource_path('excel/part.xlsx');
        $exam = resource_path('excel/exam.xlsx');

        $tempPath = storage_path($fileName);
        // $exportFile = Storage::disk('local')->copy($aec_, $tempPath);
        // copy($aec_, $tempPath);
        // copy($aec_1, $tempPath);
        // copy($aec_2, $tempPath);
        // copy($aec_3, $tempPath);
        // copy($aec_4, $tempPath);
        copy($aec_5, $tempPath);

        Excel::load($tempPath, function ($excel) use ($data) {
            foreach ($data as $sheetName => $sheetData) {
                if (in_array($sheetName, self::SECTION_ARRAY)) {
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
                if (in_array($sheetName, ['part_a', 'part_a', 'part_b', 'part_c', 'part_d', 'part_e', 'part_f', 'total_count',])) {
                    $excel->sheet($sheetName, function ($sheet) use ($sheetData) {
                        $sheet->rows($sheetData);
                    });
                }
            }
        })->export('xlsx');

        unlink($tempPath);

    }

    public static function totalCount($id)
    {
        $application = Application::with(Application::WITH)
            ->where('id', '=', $id)
            ->first()
            ->toArray();
        $data = [];
        $head = [
            0 => 'Total Fees',
            1 => 'Total Hours',
        ];
        $data['total_count'][] = $head;
        $partE = $application['part_e'];
        $totalFees = PartE::fees($partE['id']);

        $exam = $application['exam'];
        $examId = $exam['id'];
        $exam = Exam::with([
            'application' => function ($query) {
                $query->with([
                    'partC' => function ($query) {
                        $query->with(['partCTeacherList']);
                    },
                ]);
            },
            'sectionList' => function ($query) {
                $query->with([
                    'groupList' => function ($query) {
                        $query->with(['level', 'examType', 'rest', 'itemList' => function ($query) {
                            $query->with(array_merge(Item::WITH, ['itemPartCTeacherList' => function ($query) {
                                $query->with(['partCTeacher']);
                            }]))->orderBy('number', 'asc');
                        },])->orderBy('number', 'asc');
                    },
                ]);
            },
        ])
            ->find($examId);
        if ($exam) {
            $exam = $exam->toArray();
        } else {
            $exam = [];
        }
        // dd($exam);
        $totalHours = Exam::totalHours($exam);

        $data['total_count'][] = [
            0 => $totalFees,
            1 => $totalHours,
        ];
        return $data;
    }

}