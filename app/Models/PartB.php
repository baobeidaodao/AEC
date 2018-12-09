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

class PartB extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'part_b';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    const CHECK_VALID = 1;
    const CHECK_INVALID = 0;

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function application()
    {
        return $this->hasOne(Application::class, 'id', 'application_id');
    }

    public function studio()
    {
        return $this->hasOne(Studio::class, 'id', 'studio_id');
    }

    public static function check($id)
    {
        $partB = self::find($id);
        if (!isset($partB) || empty($partB)) {
            return;
        }
        if (
            isset($partB->application_id) && !empty($partB->application_id)
            && isset($partB->country_id) && !empty($partB->country_id)
            && isset($partB->studio_id) && !empty($partB->studio_id)
            && isset($partB->studio_name) && !empty($partB->studio_name)
            && isset($partB->address_1) && !empty($partB->address_1)
            && isset($partB->post_code) && !empty($partB->post_code)
            && isset($partB->tel) && !empty($partB->tel)
            && isset($partB->examination_day_contact_tel) && !empty($partB->examination_day_contact_tel)
        ) {
            $partB->check = self::CHECK_VALID;
        } else {
            $partB->check = self::CHECK_INVALID;
        }
        $partB->save();
    }

}