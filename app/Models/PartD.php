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

class PartD extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'part_d';
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

    public function applicant()
    {
        return $this->hasOne(Applicant::class, 'id', 'applicant_id');
    }

    public function identity()
    {
        return $this->hasOne(Identity::class, 'id', 'identity_id');
    }

    public static function check($id)
    {
        $partD = self::find($id);
        if (!isset($partD) || empty($partD)) {
            return;
        }
        if (
            isset($partD->application_id) && !empty($partD->application_id)
            && isset($partD->applicant_id) && !empty($partD->applicant_id)
            && isset($partD->applicant_name) && !empty($partD->applicant_name)
            && isset($partD->membership_id) && !empty($partD->membership_id)
            && isset($partD->identity_id) && !empty($partD->identity_id)
            && isset($partD->address_1) && !empty($partD->address_1)
            && isset($partD->post_code) && !empty($partD->post_code)
            && isset($partD->tel) && !empty($partD->tel)
            && isset($partD->fax) && !empty($partD->fax)
            && isset($partD->email) && !empty($partD->email)
            && isset($partD->delivery_date) && !empty($partD->delivery_date)
        ) {
            $partD->check = self::CHECK_VALID;
        } else {
            $partD->check = self::CHECK_INVALID;
        }
        $partD->save();
    }

}