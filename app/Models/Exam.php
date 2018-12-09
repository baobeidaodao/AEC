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

}