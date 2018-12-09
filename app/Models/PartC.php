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

}