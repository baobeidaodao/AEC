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
        $rest = isset($group->rest->minute) ? intval($group->rest->minute) : 0;
        $minute = Group::minute($type, $level, $count) + $rest;
        $startTime = $group->exam_time;
        $finishTime = date('Y-m-d H:i:s', strtotime('+' . intval($minute) . ' minute', strtotime($startTime)));
        $group->finish_time = $finishTime;
        $group->save();
        return $group;
    }

    public static function birthDate($id)
    {
        $group = Group::with(['level'])->find($id);
        $level = $group->level->code;
        $examDate = '2019-04-01';
        $examTime = strtotime($examDate);
        switch ($level) {
            case 'DC1':
                $birthTime = strtotime('-' . intval(2.5 * 365) . ' day', $examTime);
                break;
            case 'DC2':
                $birthTime = strtotime('-' . intval(3.5 * 365) . ' day', $examTime);
                break;
            case 'PPID':
                $birthTime = strtotime('-5 year', $examTime);
                break;
            case 'PID':
                $birthTime = strtotime('-6 year', $examTime);
                break;
            case 'G1':
                $birthTime = strtotime('-7 year', $examTime);
                break;
            case 'G2':
                $birthTime = strtotime('-7 year', $examTime);
                break;
            case 'G3':
                $birthTime = strtotime('-7 year', $examTime);
                break;
            case 'G4':
                $birthTime = strtotime('-7 year', $examTime);
                break;
            case 'G5':
                $birthTime = strtotime('-7 year', $examTime);
                break;
            case 'G6':
                $birthTime = strtotime('-11 year', $examTime);
                break;
            case 'G7':
                $birthTime = strtotime('-11 year', $examTime);
                break;
            case 'G8':
                $birthTime = strtotime('-11 year', $examTime);
                break;
            case 'INTF':
                $birthTime = strtotime('-11 year', $examTime);
                break;
            case 'INT':
                $birthTime = strtotime('-12 year', $examTime);
                break;
            case 'ADVF':
                $birthTime = strtotime('-13 year', $examTime);
                break;
            case 'ADV1':
                $birthTime = strtotime('-14 year', $examTime);
                break;
            case 'ADV2':
                $birthTime = strtotime('-15 year', $examTime);
                break;
            case 'SS':
                $birthTime = strtotime('-15 year', $examTime);
                break;
            default:
                $birthTime = $examTime;
                break;
        }
        $birthDate = date('Y-m-d H:i:s', $birthTime);
        return $birthDate;
    }

    public static function minute($type, $level, $count)
    {
        $minute = 0;
        switch ($type) {
            case 'EX':
                switch ($level) {
                    case 'DC1':
                        break;
                    case 'DC2':
                        break;
                    case 'PPID':
                        break;
                    case 'PID':
                        if ($count == 1) {
                            $minute = 20;
                        } else if ($count == 2) {
                            $minute = 25;
                        } else if ($count == 3) {
                            $minute = 30;
                        } else if ($count == 4) {
                            $minute = 35;
                        }
                        break;
                    case 'G1':
                        if ($count == 1) {
                            $minute = 20;
                        } else if ($count == 2) {
                            $minute = 25;
                        } else if ($count == 3) {
                            $minute = 35;
                        } else if ($count == 4) {
                            $minute = 40;
                        }
                        break;
                    case 'G2':
                        if ($count == 1) {
                            $minute = 20;
                        } else if ($count == 2) {
                            $minute = 25;
                        } else if ($count == 3) {
                            $minute = 35;
                        } else if ($count == 4) {
                            $minute = 40;
                        }
                        break;
                    case 'G3':
                        if ($count == 1) {
                            $minute = 25;
                        } else if ($count == 2) {
                            $minute = 30;
                        } else if ($count == 3) {
                            $minute = 40;
                        } else if ($count == 4) {
                            $minute = 45;
                        }
                        break;
                    case 'G4':
                        if ($count == 1) {
                            $minute = 30;
                        } else if ($count == 2) {
                            $minute = 35;
                        } else if ($count == 3) {
                            $minute = 45;
                        } else if ($count == 4) {
                            $minute = 50;
                        }
                        break;
                    case 'G5':
                        if ($count == 1) {
                            $minute = 30;
                        } else if ($count == 2) {
                            $minute = 35;
                        } else if ($count == 3) {
                            $minute = 45;
                        } else if ($count == 4) {
                            $minute = 50;
                        }
                        break;
                    case 'G6':
                        if ($count == 1) {
                            $minute = 35;
                        } else if ($count == 2) {
                            $minute = 40;
                        } else if ($count == 3) {
                            $minute = 50;
                        } else if ($count == 4) {
                            $minute = 55;
                        }
                        break;
                    case 'G7':
                        if ($count == 1) {
                            $minute = 35;
                        } else if ($count == 2) {
                            $minute = 40;
                        } else if ($count == 3) {
                            $minute = 50;
                        } else if ($count == 4) {
                            $minute = 55;
                        }
                        break;
                    case 'G8':
                        if ($count == 1) {
                            $minute = 35;
                        } else if ($count == 2) {
                            $minute = 40;
                        } else if ($count == 3) {
                            $minute = 50;
                        } else if ($count == 4) {
                            $minute = 60;
                        }
                        break;
                    case 'INTF':
                        if ($count == 1) {
                            $minute = 40;
                        } else if ($count == 2) {
                            $minute = 45;
                        } else if ($count == 3 || $count == 4) {
                            $minute = 65;
                        }
                        break;
                    case 'INT':
                        if ($count == 1) {
                            $minute = 45;
                        } else if ($count == 2) {
                            $minute = 50;
                        } else if ($count == 3 || $count == 4) {
                            $minute = 75;
                        }
                        break;
                    case 'ADVF':
                        if ($count == 1) {
                            $minute = 55;
                        } else if ($count == 2) {
                            $minute = 65;
                        } else if ($count == 3 || $count == 4) {
                            $minute = 85;
                        }
                        break;
                    case 'ADV1':
                        if ($count == 1) {
                            $minute = 55;
                        } else if ($count == 2) {
                            $minute = 65;
                        } else if ($count == 3 || $count == 4) {
                            $minute = 85;
                        }
                        break;
                    case 'ADV2':
                        if ($count == 1) {
                            $minute = 55;
                        } else if ($count == 2) {
                            $minute = 65;
                        } else if ($count == 3 || $count == 4) {
                            $minute = 85;
                        }
                        break;
                    case 'SS':
                        if ($count == 2) {
                            $minute = 40;
                        } else if ($count == 3) {
                            $minute = 40;
                        } else if ($count == 4) {
                            $minute = 50;
                        }
                        break;
                    case 'R2C':
                        if ($count == 1) {
                            $minute = 20;
                        } else if ($count == 2) {
                            $minute = 25;
                        } else if ($count == 3) {
                            $minute = 30;
                        } else if ($count == 4) {
                            $minute = 35;
                        }
                        break;
                    case 'R2V1':
                        if ($count == 1) {
                            $minute = 15;
                        } else if ($count == 2) {
                            $minute = 20;
                        } else if ($count == 3) {
                            $minute = 25;
                        } else if ($count == 4) {
                            $minute = 35;
                        }
                        break;
                    case 'R2V2':
                        if ($count == 1) {
                            $minute = 15;
                        } else if ($count == 2) {
                            $minute = 20;
                        } else if ($count == 3) {
                            $minute = 25;
                        } else if ($count == 4) {
                            $minute = 35;
                        }
                        break;
                    case 'R3C':
                        if ($count == 1) {
                            $minute = 20;
                        } else if ($count == 2) {
                            $minute = 25;
                        } else if ($count == 3) {
                            $minute = 30;
                        } else if ($count == 4) {
                            $minute = 35;
                        }
                        break;
                    case 'R3V1':
                        if ($count == 1) {
                            $minute = 15;
                        } else if ($count == 2) {
                            $minute = 20;
                        } else if ($count == 3) {
                            $minute = 25;
                        } else if ($count == 4) {
                            $minute = 35;
                        }
                        break;
                    case 'R3V2':
                        if ($count == 1) {
                            $minute = 15;
                        } else if ($count == 2) {
                            $minute = 20;
                        } else if ($count == 3) {
                            $minute = 25;
                        } else if ($count == 4) {
                            $minute = 35;
                        }
                        break;
                    case 'R4C':
                        if ($count == 1) {
                            $minute = 20;
                        } else if ($count == 2) {
                            $minute = 25;
                        } else if ($count == 3) {
                            $minute = 30;
                        } else if ($count == 4) {
                            $minute = 35;
                        }
                        break;
                    case 'R4V1':
                        if ($count == 1) {
                            $minute = 15;
                        } else if ($count == 2) {
                            $minute = 20;
                        } else if ($count == 3) {
                            $minute = 25;
                        } else if ($count == 4) {
                            $minute = 35;
                        }
                        break;
                    case 'R4V2':
                        if ($count == 1) {
                            $minute = 15;
                        } else if ($count == 2) {
                            $minute = 20;
                        } else if ($count == 3) {
                            $minute = 25;
                        } else if ($count == 4) {
                            $minute = 35;
                        }
                        break;
                    default:
                        break;
                }
                break;
            case 'DC':
                switch ($level) {
                    case 'DC1':
                        if (1 <= $count && $count <= 8) {
                            $minute = 30;
                        } else if (9 <= $count && $count <= 16) {
                            $minute = 45;
                        }
                        break;
                    case 'DC2':
                        if (1 <= $count && $count <= 8) {
                            $minute = 30;
                        } else if (9 <= $count && $count <= 16) {
                            $minute = 45;
                        }
                        break;
                    case 'PPID':
                        break;
                    case 'PID':
                        break;
                    case 'G1':
                        break;
                    case 'G2':
                        break;
                    case 'G3':
                        break;
                    case 'G4':
                        break;
                    case 'G5':
                        break;
                    case 'G6':
                        break;
                    case 'G7':
                        break;
                    case 'G8':
                        break;
                    case 'INTF':
                        break;
                    case 'INT':
                        break;
                    case 'ADVF':
                        break;
                    case 'ADV1':
                        break;
                    case 'ADV2':
                        break;
                    case 'SS':
                        break;
                    case 'R2C':
                        break;
                    case 'R2V1':
                        break;
                    case 'R2V2':
                        break;
                    case 'R3C':
                        break;
                    case 'R3V1':
                        break;
                    case 'R3V2':
                        break;
                    case 'R4C':
                        break;
                    case 'R4V1':
                        break;
                    case 'R4V2':
                        break;
                    default:
                        break;
                }
                break;
            case 'CA':
                switch ($level) {
                    case 'DC1':
                        break;
                    case 'DC2':
                        break;
                    case 'PPID':
                        if (1 <= $count && $count <= 2) {
                            $minute = 15;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 20;
                        } else if (5 <= $count && $count <= 8) {
                            $minute = 30;
                        }
                        break;
                    case 'PID':
                        if (1 <= $count && $count <= 2) {
                            $minute = 15;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 20;
                        } else if (5 <= $count && $count <= 8) {
                            $minute = 30;
                        }
                        break;
                    case 'G1':
                        if (1 <= $count && $count <= 2) {
                            $minute = 15;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 20;
                        } else if (5 <= $count && $count <= 8) {
                            $minute = 30;
                        }
                        break;
                    case 'G2':
                        if (1 <= $count && $count <= 2) {
                            $minute = 20;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 25;
                        } else if (5 <= $count && $count <= 8) {
                            $minute = 35;
                        }
                        break;
                    case 'G3':
                        if (1 <= $count && $count <= 2) {
                            $minute = 20;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 25;
                        } else if (5 <= $count && $count <= 8) {
                            $minute = 35;
                        }
                        break;
                    case 'G4':
                        if (1 <= $count && $count <= 2) {
                            $minute = 25;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 30;
                        } else if (5 <= $count && $count <= 8) {
                            $minute = 40;
                        }
                        break;
                    case 'G5':
                        if (1 <= $count && $count <= 2) {
                            $minute = 25;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 30;
                        } else if (5 <= $count && $count <= 8) {
                            $minute = 40;
                        }
                        break;
                    case 'G6':
                        break;
                    case 'G7':
                        break;
                    case 'G8':
                        break;
                    case 'INTF':
                        break;
                    case 'INT':
                        break;
                    case 'ADVF':
                        break;
                    case 'ADV1':
                        break;
                    case 'ADV2':
                        break;
                    case 'SS':
                        break;
                    case 'R2C':
                        if (1 <= $count && $count <= 2) {
                            $minute = 25;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 35;
                        } else if (5 <= $count && $count <= 6) {
                            $minute = 40;
                        } else if (7 <= $count && $count <= 8) {
                            $minute = 45;
                        }
                        break;
                    case 'R2V1':
                        if (1 <= $count && $count <= 2) {
                            $minute = 20;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 35;
                        } else if (5 <= $count && $count <= 6) {
                            $minute = 50;
                        } else if (7 <= $count && $count <= 8) {
                            $minute = 60;
                        }
                        break;
                    case 'R2V2':
                        if (1 <= $count && $count <= 2) {
                            $minute = 20;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 35;
                        } else if (5 <= $count && $count <= 6) {
                            $minute = 50;
                        } else if (7 <= $count && $count <= 8) {
                            $minute = 60;
                        }
                        break;
                    case 'R3C':
                        if (1 <= $count && $count <= 2) {
                            $minute = 25;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 35;
                        } else if (5 <= $count && $count <= 6) {
                            $minute = 40;
                        } else if (7 <= $count && $count <= 8) {
                            $minute = 45;
                        }
                        break;
                    case 'R3V1':
                        if (1 <= $count && $count <= 2) {
                            $minute = 20;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 35;
                        } else if (5 <= $count && $count <= 6) {
                            $minute = 50;
                        } else if (7 <= $count && $count <= 8) {
                            $minute = 60;
                        }
                        break;
                    case 'R3V2':
                        if (1 <= $count && $count <= 2) {
                            $minute = 20;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 35;
                        } else if (5 <= $count && $count <= 6) {
                            $minute = 50;
                        } else if (7 <= $count && $count <= 8) {
                            $minute = 60;
                        }
                        break;
                    case 'R4C':
                        if (1 <= $count && $count <= 2) {
                            $minute = 25;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 35;
                        } else if (5 <= $count && $count <= 6) {
                            $minute = 40;
                        } else if (7 <= $count && $count <= 8) {
                            $minute = 45;
                        }
                        break;
                    case 'R4V1':
                        if (1 <= $count && $count <= 2) {
                            $minute = 20;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 35;
                        } else if (5 <= $count && $count <= 6) {
                            $minute = 50;
                        } else if (7 <= $count && $count <= 8) {
                            $minute = 60;
                        }
                        break;
                    case 'R4V2':
                        if (1 <= $count && $count <= 2) {
                            $minute = 20;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 35;
                        } else if (5 <= $count && $count <= 6) {
                            $minute = 50;
                        } else if (7 <= $count && $count <= 8) {
                            $minute = 60;
                        }
                        break;
                    default:
                        break;
                }
                break;
            case 'PC':
                switch ($level) {
                    case 'DC1':
                        break;
                    case 'DC2':
                        break;
                    case 'PPID':
                        break;
                    case 'PID':
                        break;
                    case 'G1':
                        break;
                    case 'G2':
                        break;
                    case 'G3':
                        break;
                    case 'G4':
                        break;
                    case 'G5':
                        break;
                    case 'G6':
                        if (1 <= $count && $count <= 2) {
                            $minute = 35;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 40;
                        } else if (5 <= $count && $count <= 8) {
                            $minute = 50;
                        }
                        break;
                    case 'G7':
                        if (1 <= $count && $count <= 2) {
                            $minute = 35;
                        } else if (3 <= $count && $count <= 4) {
                            $minute = 40;
                        } else if (5 <= $count && $count <= 8) {
                            $minute = 50;
                        }
                        break;
                    case 'G8':
                        if ($count == 1) {
                            $minute = 35;
                        } else if ($count == 2) {
                            $minute = 40;
                        } else if ($count == 3) {
                            $minute = 50;
                        } else if ($count == 4) {
                            $minute = 60;
                        }
                        break;
                    case 'INTF':
                        break;
                    case 'INT':
                        break;
                    case 'ADVF':
                        break;
                    case 'ADV1':
                        break;
                    case 'ADV2':
                        break;
                    case 'SS':
                        break;
                    case 'R2C':
                    case 'R2V1':
                        break;
                    case 'R2V2':
                        break;
                    case 'R3C':
                        break;
                    case 'R3V1':
                        break;
                    case 'R3V2':
                        break;
                    case 'R4C':
                        break;
                    case 'R4V1':
                        break;
                    case 'R4V2':
                        break;
                    default:
                        break;
                }
                break;
            case 'SPA':
                switch ($level) {
                    case 'DC1':
                        break;
                    case 'DC2':
                        break;
                    case 'PPID':
                        break;
                    case 'PID':
                        break;
                    case 'G1':
                        if ($count == 1) {
                            $minute = 10;
                        } else if ($count == 2) {
                            $minute = 15;
                        } else if ($count == 3) {
                            $minute = 20;
                        } else if ($count == 4) {
                            $minute = 25;
                        }
                        break;
                    case 'G2':
                        if ($count == 1) {
                            $minute = 10;
                        } else if ($count == 2) {
                            $minute = 15;
                        } else if ($count == 3) {
                            $minute = 20;
                        } else if ($count == 4) {
                            $minute = 25;
                        }
                        break;
                    case 'G3':
                        if ($count == 1) {
                            $minute = 10;
                        } else if ($count == 2) {
                            $minute = 15;
                        } else if ($count == 3) {
                            $minute = 20;
                        } else if ($count == 4) {
                            $minute = 25;
                        }
                        break;
                    case 'G4':
                        if ($count == 1) {
                            $minute = 10;
                        } else if ($count == 2) {
                            $minute = 15;
                        } else if ($count == 3) {
                            $minute = 20;
                        } else if ($count == 4) {
                            $minute = 25;
                        }
                        break;
                    case 'G5':
                        if ($count == 1) {
                            $minute = 10;
                        } else if ($count == 2) {
                            $minute = 15;
                        } else if ($count == 3) {
                            $minute = 20;
                        } else if ($count == 4) {
                            $minute = 25;
                        }
                        break;
                    case 'G6':
                        break;
                    case 'G7':
                        break;
                    case 'G8':
                        break;
                    case 'INTF':
                        break;
                    case 'INT':
                        break;
                    case 'ADVF':
                        break;
                    case 'ADV1':
                        break;
                    case 'ADV2':
                        break;
                    case 'SS':
                        break;
                    case 'R2C':
                        break;
                    case 'R2V1':
                        break;
                    case 'R2V2':
                        break;
                    case 'R3C':
                        break;
                    case 'R3V1':
                        break;
                    case 'R3V2':
                        break;
                    case 'R4C':
                        break;
                    case 'R4V1':
                        break;
                    case 'R4V2':
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

    public static function findApplicationByGroupId($groupId)
    {
        $group = Group::find($groupId);
        $section = Section::find($group->section_id);
        $exam = Exam::find($section->exam_id);
        $application = Application::find($exam->application_id);
        return $application;
    }

}