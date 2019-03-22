<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-20
 * Time: 15:34
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\Isset_;

class Exam extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'exam';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    const CHECK_VALID = 1;
    const CHECK_INVALID = 0;

    public function application()
    {
        return $this->hasOne(Application::class, 'id', 'application_id');
    }

    public function sectionList()
    {
        return $this->hasMany(Section::class, 'exam_id', 'id');
    }

    public static function check($id)
    {
        $exam = self::find($id);
        if (!isset($exam) || empty($exam)) {
            return;
        }
        if (
            isset($exam->application_id) && !empty($exam->application_id)
        ) {
            $exam->check = self::CHECK_VALID;
        } else {
            $exam->check = self::CHECK_INVALID;
        }
        $exam->save();
    }

    public static function studentIdArray($id, $itemId = null)
    {
        $idArray = Exam::join('section', 'exam.id', '=', 'section.exam_id')
            ->join('group', 'section.id', '=', 'group.section_id')
            ->join('item', 'group.id', '=', 'item.group_id')
            ->where('exam.id', '=', $id)
            ->where(function ($query) use ($itemId) {
                if (isset($itemId) && null != $itemId && !empty($itemId)) {
                    $query->where('item.id', '!=', $itemId);
                }
            })
            ->pluck('item.student_number');
        if (isset($idArray) && !empty($idArray)) {
            $idArray = $idArray->toArray();
        } else {
            $idArray = [];
        }
        return $idArray;
    }

    public static function export($id)
    {
        $data = [];
        $head = [
            0 => 'Office Use Only',
            1 => 'Level Code',
            2 => 'Exam Type',
            3 => 'Number',
            4 => 'Candidate ID No',
            5 => 'Given Name',
            6 => 'Family Name',
            7 => 'Member',
            8 => 'Date of Birth',
            9 => 'Syllabus M/F',
            10 => 'Reasonable Adjustment',
            11 => 'Teacher 1',
            12 => 'Teacher 2',
            13 => 'Teacher 3',
            14 => 'Teacher 4',
            15 => 'Teacher 5',
            16 => 'Teacher 6',
            17 => 'Office Use Only',
        ];
        $body = [
            0 => '',
            1 => '',
            2 => '',
            3 => '',
            4 => '',
            5 => '',
            6 => '',
            7 => 'No',
            8 => '',
            9 => '',
            10 => '',
            11 => '',
            12 => '',
            13 => '',
            14 => '',
            15 => '',
            16 => '',
            17 => '',
        ];
        $exam = Exam::with(['sectionList' => function ($query) {
            $query->with([
                'groupList' => function ($query) {
                    $query->with(['level', 'examType', 'rest', 'itemList' => function ($query) {
                        $query->with(array_merge(Item::WITH, ['itemPartCTeacherList' => function ($query) {
                            $query->with(['partCTeacher',]);
                        },]))->orderBy('number', 'asc');
                    },])->orderBy('number', 'asc');
                },
            ]);
        },])->find($id);
        if (!$exam) {
            return $data;
        } else {
            $exam = $exam->toArray();
        }
        if (isset($exam['section_list']) && is_array($exam['section_list']) && !empty($exam['section_list'])) {
            $sectionList = $exam['section_list'];
            foreach ($sectionList as $section) {
                $sheetName = 'section_' . $section['number'];
                $data[$sheetName] = [];
                $data[$sheetName][] = $head;
                if (isset($section['group_list']) && is_array($section['group_list']) && !empty($section['group_list'])) {
                    $groupList = $section['group_list'];
                    foreach ($groupList as $group) {
                        if (isset($group['item_list']) && is_array($group['item_list']) && !empty($group['item_list'])) {
                            $itemList = $group['item_list'];
                            foreach ($itemList as $index => $item) {
                                $record = $body;
                                if ($index == 0) {
                                    $record[0] = date('Hi', strtotime($group['exam_time']));
                                }
                                $record[1] = $group['level']['code'];
                                $record[2] = $group['exam_type']['code'];
                                $record[3] = $item['number'];
                                $record[4] = $item['student_number'];
                                $record[5] = $item['given_name'];
                                $record[6] = $item['family_name'];
                                if ($item['member'] == 1) {
                                    $record[7] = 'YES';
                                } else {
                                    $record[7] = 'NO';
                                }
                                $record[8] = date('d/m/Y', strtotime($item['birth_date']));
                                if ($item['sex'] == 1) {
                                    $record[9] = 'M';
                                } else {
                                    $record[9] = 'F';
                                }
                                $numberArray = [];
                                if (isset($item['item_part_c_teacher_list']) && !empty($item['item_part_c_teacher_list']) && is_array($item['item_part_c_teacher_list'])) {
                                    $itemPartCTeacherList = $item['item_part_c_teacher_list'];
                                    foreach ($itemPartCTeacherList as $itemPartCTeacher) {
                                        if (isset($itemPartCTeacher['part_c_teacher']) && !empty($itemPartCTeacher['part_c_teacher']) && is_array($itemPartCTeacher['part_c_teacher'])) {
                                            $partCTeacher = $itemPartCTeacher['part_c_teacher'];
                                            $numberArray[] = $partCTeacher['number'];
                                        }
                                    }
                                }
                                if (in_array(1, $numberArray)) {
                                    $record[11] = '√';
                                }
                                if (in_array(2, $numberArray)) {
                                    $record[12] = '√';
                                }
                                if (in_array(3, $numberArray)) {
                                    $record[13] = '√';
                                }
                                if (in_array(4, $numberArray)) {
                                    $record[14] = '√';
                                }
                                if (in_array(5, $numberArray)) {
                                    $record[15] = '√';
                                }
                                if (in_array(6, $numberArray)) {
                                    $record[16] = '√';
                                }
                                // dd($record);
                                $data[$sheetName][] = $record;
                            }
                        }
                        $data[$sheetName][] = $body;
                        if (isset($group['rest']['name']) && in_array($group['rest']['name'], ['Break', 'Lunch', 'Finish',])) {
                            $record = $body;
                            $record[0] = date('Hi', strtotime('-' . intval($group['rest']['minute']) . ' minute', strtotime($group['finish_time'])));
                            $record[4] = $group['rest']['name'];
                            $data[$sheetName][] = $record;
                        }
                        if (isset($group['rest']['name']) && in_array($group['rest']['name'], ['Break', 'Lunch',])) {
                            $data[$sheetName][] = $body;
                        }
                    }
                }
            }
        }
        return $data;
    }

    public static function totalHours($exam)
    {
        $second = 0;
        $minute = 0;
        $hour = 0;
        if (isset($exam['section_list'])) {
            foreach ($exam['section_list'] as $section) {
                if (isset($section['group_list'])) {
                    foreach ($section['group_list'] as $group) {
                        $second = $second + strtotime($group['finish_time']) - strtotime($group['exam_time']) - ($group['rest']['minute'] * 60);
                    }
                }
            }
            $minute = intval(intval($second / 60) % 60);
            $hour = intval($second / 60 / 60);
        }
        return $hour . 'HOUR' . $minute . 'MIN';
    }


    public static function countLimit($id)
    {
        $exam = Exam::with([
            'sectionList' => function ($query) {
                $query->with([
                    'groupList' => function ($query) {
                        $query->with([
                            'itemList' => function ($query) {
                                $query->whereNull('item.deleted_at');
                            }
                        ])->whereNull('group.deleted_at');
                    },
                ])->whereNull('section.deleted_at');
            },
        ])
            ->find($id);
        $sectionCount = 0;
        $groupCount = 0;
        $itemCount = 0;
        $limit = 15 * 21;
        $sectionCount += count($exam->sectionList);
        foreach ($exam->sectionList as $section) {
            $groupCount += count($section->groupList);
            foreach ($section->groupList as $group) {
                $itemCount += count($group->itemList);
            }
        }
        $line = $groupCount + $itemCount;
        $countLimit = [];
        $countLimit['examId'] = $id;
        $countLimit['sectionCount'] = $sectionCount;
        $countLimit['groupCount'] = $groupCount;
        $countLimit['itemCount'] = $itemCount;
        $countLimit['line'] = $line;
        $countLimit['limit'] = $limit;
        return $countLimit;
    }

    public static function full($examId)
    {
        $countLimit = Exam::countLimit($examId);
        if ($countLimit['line'] >= $countLimit['limit']) {
            return true;
        }
        return false;
    }

}