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

class Section extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'section';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    const CHECK_VALID = 1;
    const CHECK_INVALID = 0;

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }

    public function groupList()
    {
        return $this->hasMany(Group::class, 'section_id', 'id');
    }

    public static function check($id)
    {
        $section = self::find($id);
        if (!isset($section) || empty($section)) {
            return;
        }
        if (
            isset($section->exam_id) && !empty($section->exam_id)
            && isset($section->exam_time) && !empty($section->exam_time)
        ) {
            $section->check = self::CHECK_VALID;
        } else {
            $section->check = self::CHECK_INVALID;
        }
        $section->save();
    }

    public static function calculate($sectionId)
    {
        $section = Section::find($sectionId);
        $startTime = $section->exam_time;
        $finishTime = $section->finish_time;
        $groupList = Group::where('section_id', '=', $sectionId)
            ->orderBy('number', 'asc')
            ->get();
        foreach ($groupList as $group) {
            $group->exam_time = $startTime;
            $group->save();
            $group = Group::calculate($group->id);
            $finishTime = $group->finish_time;
            $startTime = $group->finish_time;
        }
        $section->finish_time = $finishTime;
        $section->save();
    }

}