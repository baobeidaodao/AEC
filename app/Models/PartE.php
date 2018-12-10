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
use Illuminate\Support\Facades\Schema;

class PartE extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'part_e';
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

    public static function check($id)
    {
        $partE = self::find($id);
        if (!isset($partE) || empty($partE)) {
            return;
        }
        if (
            isset($partE->application_id) && !empty($partE->application_id)
        ) {
            $partE->check = self::CHECK_VALID;
        } else {
            $partE->check = self::CHECK_INVALID;
        }
        $partE->save();
    }

    public static function calculate($applicationId)
    {
        $partE = PartE::where('application_id', '=', $applicationId)->first();
        $columnArray = Schema::getColumnListing('part_e');
        $groupList = Group::with(['level', 'examType', 'itemList'])
            ->join('section', 'section.id', '=', 'group.section_id')
            ->join('exam', 'exam.id', '=', 'section.exam_id')
            ->where('exam.application_id', '=', $applicationId)
            ->get();
        foreach ($groupList as $group) {
            $attribute = strtolower($group->examType->code) . '_' . strtolower($group->level->code);
            if (!in_array($attribute, $columnArray)) {
                continue;
            }
            $count = count($group->itemList);
            $attributeCount = $attribute . 'Count';
            if (!isset($$attributeCount)) {
                $$attributeCount = 0;
            }
            $$attributeCount = $$attributeCount + $count;
            $partE->$attribute = $$attributeCount;
        }
        $partE->save();
    }
}