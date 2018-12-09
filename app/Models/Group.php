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

class Group extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'group';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    const CHECK_VALID = 1;
    const CHECK_INVALID = 0;

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function level()
    {
        return $this->hasOne(Level::class, 'id', 'level_id');
    }

    public function examType()
    {
        return $this->hasOne(ExamType::class, 'id', 'exam_type_id');
    }

    public function rest()
    {
        return $this->hasOne(Rest::class, 'id', 'rest_id');
    }

    public function itemList()
    {
        return $this->hasMany(Item::class, 'group_id', 'id');
    }

    public static function check($id)
    {
        $group = self::find($id);
        if (!isset($group) || empty($group)) {
            return;
        }
        if (
            isset($group->section_id) && !empty($group->section_id)
            && isset($group->level_id) && !empty($group->level_id)
            && isset($group->exam_type_id) && !empty($group->exam_type_id)
            && isset($group->exam_time) && !empty($group->exam_time)
        ) {
            $group->check = self::CHECK_VALID;
        } else {
            $group->check = self::CHECK_INVALID;
        }
        $group->save();
    }

    public static function calculate($groupId)
    {
        $group = Group::with(['level', 'examType', 'rest', 'itemList'])->find($groupId);
        $level = $group->level->code;
        $type = $group->examType->code;
        $count = count($group->itemList);
        $rest = $group->rest->minute;
        $minute = Group::minute($type, $level, $count) + $rest;
        $startTime = $group->exam_time;
        $finishTime = date('Y-m-d H:i:s', strtotime('+' . intval($minute) . ' minute', strtotime($startTime)));
        $group->finish_time = $finishTime;
        $group->save();
        return $group;
    }

    public static function minute($type, $level, $count)
    {
        $minute = 20;
        switch ($type) {
            case 'EX':
                switch ($level) {
                    case 'PID':
                        if ($count <= 1) {
                            $minute = 20;
                        } else if ($count <= 2) {
                            $minute = 25;
                        } else if ($count <= 3) {
                            $minute = 30;
                        } else if ($count <= 4) {
                            $minute = 35;
                        }
                        break;
                    default:
                        break;
                }
                break;
            default:
                break;
        }
        return $minute;
    }

}