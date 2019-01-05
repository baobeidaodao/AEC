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

class PartCTeacher extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'part_c_teacher';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    const CHECK_VALID = 1;
    const CHECK_INVALID = 0;

    public function partC()
    {
        return $this->hasOne(PartC::class, 'id', 'part_c_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'id', 'teacher_id');
    }

    public static function check($id)
    {
        $partCTeacher = self::find($id);
        if (!isset($partCTeacher) || empty($partCTeacher)) {
            return;
        }
        if (
            isset($partCTeacher->part_c_id) && !empty($partCTeacher->part_c_id)
            && isset($partCTeacher->teacher_id) && !empty($partCTeacher->teacher_id)
            // && isset($partCTeacher->membership_id) && !empty($partCTeacher->membership_id)
            && isset($partCTeacher->given_name) && !empty($partCTeacher->given_name)
            && isset($partCTeacher->family_name) && !empty($partCTeacher->family_name)
            && isset($partCTeacher->number) && !empty($partCTeacher->number)
        ) {
            $partCTeacher->check = self::CHECK_VALID;
        } else {
            $partCTeacher->check = self::CHECK_INVALID;
        }
        $partCTeacher->save();
    }

}