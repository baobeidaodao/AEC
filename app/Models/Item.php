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

class Item extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    const CHECK_VALID = 1;
    const CHECK_INVALID = 0;

    const WITH = ['group', 'student',];

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function itemPartCTeacherList()
    {
        return $this->hasMany(ItemPartCTeacher::class, 'item_id', 'id')->where('status', '=', 1);
    }

    public static function reorder($groupId)
    {
        $itemList = (new Item)->where('group_id', $groupId)
            ->orderBy('number', 'asc')
            ->orderBy('updated_at', 'desc')
            ->get();
        $i = 1;
        foreach ($itemList as $item) {
            $item->number = $i;
            $item->save();
            $i++;
        }
    }

    public static function check($id)
    {
        $item = self::find($id);
        if (!isset($item) || empty($item)) {
            return;
        }
        if (
            isset($item->group_id) && !empty($item->group_id)
            && isset($item->number) && !empty($item->number)
            && isset($item->student_id) && !empty($item->student_id)
            && isset($item->student_number) && !empty($item->student_number)
            && isset($item->given_name) && !empty($item->given_name)
            && isset($item->family_name) && !empty($item->family_name)
            && isset($item->birth_date) && !empty($item->birth_date)
            && isset($item->sex)
        ) {
            $item->check = self::CHECK_VALID;
        } else {
            $item->check = self::CHECK_INVALID;
        }
        $item->save();
    }

}