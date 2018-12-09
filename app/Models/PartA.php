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

class PartA extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'part_a';
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
        $partA = self::find($id);
        if (!isset($partA) || empty($partA)) {
            return;
        }
        if (
            isset($partA->application_id) && !empty($partA->application_id)
            && isset($partA->school_id) && !empty($partA->school_id)
            && isset($partA->school_name) && !empty($partA->school_name)
            && isset($partA->school_code) && !empty($partA->school_code)
            && isset($partA->email) && !empty($partA->email)
            && isset($partA->tel) && !empty($partA->tel)
        ) {
            $partA->check = self::CHECK_VALID;
        } else {
            $partA->check = self::CHECK_INVALID;
        }
        $partA->save();
    }
}