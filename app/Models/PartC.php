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

class PartC extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'part_c';
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

    public function partCTeacherList()
    {
        return $this->hasMany(PartCTeacher::class, 'part_c_id', 'id');
    }

    public static function check($id)
    {
        $partC = self::find($id);
        if (!isset($partC) || empty($partC)) {
            return;
        }
        $checkPartCTeacher = self::checkPartCTeacher($id);
        if (isset($partC->application_id) && !empty($partC->application_id) && $checkPartCTeacher) {
            $partC->check = self::CHECK_VALID;
        } else {
            $partC->check = self::CHECK_INVALID;
        }
        $partC->save();
    }

    public static function checkPartCTeacher($id)
    {
        $check = true;
        $partCTeacherList = PartCTeacher::where('part_c_id', '=', $id)
            ->get()
            ->toArray();
        if (isset($partCTeacherList) && !empty($partCTeacherList)) {
            foreach ($partCTeacherList as $partCTeacher) {
                if (!is_array($partCTeacher) || !isset($partCTeacher['check']) || $partCTeacher['check'] != 1) {
                    $check = false;
                    break;
                }
            }
        } else {
            $check = false;
        }
        return $check;
    }

    public static function export($id)
    {
        $data = [];
        $head = [
            0 => '',
            1 => 'Membership ID',
            2 => 'Given Name',
            3 => 'Family Name',
        ];
        $data['part_c'][0] = $head;
        $data['part_c'][1] = ['1',];
        $data['part_c'][2] = ['2',];
        $data['part_c'][3] = ['3',];
        $data['part_c'][4] = ['4',];
        $data['part_c'][5] = ['5',];
        $data['part_c'][6] = ['6',];
        $partC = PartC::with(['partCTeacherList',])->find($id);
        if (!$partC) {
            return $data;
        } else {
            $partC = $partC->toArray();
        }
        if (isset($partC['part_c_teacher_list']) && !empty($partC['part_c_teacher_list']) && is_array($partC['part_c_teacher_list'])) {
            $partCTeacherList = $partC['part_c_teacher_list'];
            foreach ($partCTeacherList as $partCTeacher) {
                $data['part_c'][$partCTeacher['number']][1] = $partCTeacher['membership_id'];
                $data['part_c'][$partCTeacher['number']][2] = $partCTeacher['given_name'];
                $data['part_c'][$partCTeacher['number']][3] = $partCTeacher['family_name'];
            }
        }
        return $data;
    }
}