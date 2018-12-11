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

class PartF extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'part_f';
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
        $partF = self::find($id);
        if (!isset($partF) || empty($partF)) {
            return;
        }
        if (
            isset($partF->application_id) && !empty($partF->application_id)
            && isset($partF->applicant_id) && !empty($partF->applicant_id)
            && isset($partF->applicant_name) && !empty($partF->applicant_name)
        ) {
            $partF->check = self::CHECK_VALID;
        } else {
            $partF->check = self::CHECK_INVALID;
        }
        $partF->save();
    }

    public static function export($id)
    {
        $data = [];
        $head = [
            0 => 'Applicant Name',
        ];
        $data['part_f'][] = $head;
        $partF = PartF::find($id);
        if (!$partF) {
            return $data;
        } else {
            $partF = $partF->toArray();
        }
        $data['part_f'][] = [
            0 => $partF['applicant_name'],
        ];
        return $data;
    }
}