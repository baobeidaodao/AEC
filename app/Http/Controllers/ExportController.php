<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-28
 * Time: 19:00
 */

namespace App\Http\Controllers;


use App\Models\Application;
use App\Models\Item;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export($id)
    {
        $application = Application::with([
            'aec', 'user', 'partA', 'partB', 'partC', 'partD', 'partE', 'partF',
            'exam' => function ($query) {
                $query->with(['sectionList' => function ($query) {
                    $query->with([
                        'groupList' => function ($query) {
                            $query->with(['itemList' => function ($query) {
                                $query->with(Item::WITH);
                            },]);
                        },
                    ]);
                },
                ]);
            },])
            ->where('id', '=', $id)
            ->first()
            ->toArray();

        // dd($application);

        $fileName = $id;

        $data = [];
        $data['part_a'][] = $application['part_a'];
        $data['part_b'][] = $application['part_b'];
        $data['part_c'][] = $application['part_c'];
        $data['part_d'][] = $application['part_d'];
        $data['part_e'][] = $application['part_e'];
        $data['part_f'][] = $application['part_f'];

        // dd($data);

        foreach ($application['exam']['section_list'] as $section) {
            $key = 'section_' . $section['id'];
            $value = [];
            foreach ($section['group_list'] as $group) {
                foreach ($group['item_list'] as $item) {
                    $x = [];
                    foreach ($item as $k => $v) {
                        if (is_array($v)) {
                            foreach ($v as $i => $o) {
                                $x[$k . '_' . $i] = $o;
                            }
                        } else {
                            $x[$k] = $v;
                        }
                    }
                    $value[] = $x;
                }
            }
            $data[$key] = $value;
        }

        // dd($data);

        Excel::create($fileName, function ($excel) use ($data) {
            foreach ($data as $key => $value) {
                $sheetName = $key;
                // dd($value);
                $cellData = [];
                foreach ($value as $k => $v) {
                    if ($k == 0) {
                        $cellData[] = array_keys($v);
                    }
                    $cellData[] = array_values($v);
                }

                $excel->sheet($sheetName, function ($sheet) use ($cellData) {
                    // dd($cellData);
                    $sheet->rows($cellData);
                });
            }
            // ob_end_clean();
        })->export('xlsx');

    }
}