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
        return $partD;
    }

    public static function export($id)
    {
        $data = [];
        $head = [
            0 => 'Name of Applicant',
            1 => 'Membership ID',
            2 => 'Please identify yourself as one of the following:',
            3 => 'Delivery/Correspondence Address',
            4 => 'Postcode',
            5 => 'Tel',
            6 => 'Fax',
            7 => 'Email',
            8 => 'Impossible Dates for Delivery',
            9 => 'I am happy for a neighbour to receive my delivery',
        ];
        $data['part_d'][0] = $head;
        $partD = PartD::with(['identity',])->find($id);
        if (!$partD) {
            return $data;
        } else {
            $partD = $partD->toArray();
        }
        $record = [];
        $record[0] = $partD['applicant_name'];
        $record[1] = $partD['membership_id'];
        $record[2] = $partD['identity']['name'];
        $record[3] = $partD['address_1'];
        $record[4] = $partD['post_code'];
        $record[5] = $partD['tel'];
        $record[6] = $partD['fax'];
        $record[7] = $partD['email'];
        $record[8] = $partD['delivery_date'];
        $record[9] = ($partD['neighbour'] == 1) ? '√' : '';
        $data['part_d'][1] = $record;
        $data['part_d'][2] = ['', '', '', $partD['address_2']];
        $data['part_d'][3] = ['', '', '', $partD['address_3']];
        return $data;
    }

}