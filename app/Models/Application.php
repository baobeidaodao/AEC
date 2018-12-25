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

class Application extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'application';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    const WITH = ['aec', 'user', 'partA', 'partB', 'partC', 'partD', 'partE', 'partF', 'exam',];

    const CHECK_VALID = 1;
    const CHECK_INVALID = 0;

    public function aec()
    {
        return $this->hasOne(Aec::class, 'id', 'aec_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_user_id');
    }

    public function partA()
    {
        return $this->hasOne(PartA::class, 'application_id', 'id');
    }

    public function partB()
    {
        return $this->hasOne(PartB::class, 'application_id', 'id');
    }

    public function partC()
    {
        return $this->hasOne(PartC::class, 'application_id', 'id');
    }

    public function partD()
    {
        return $this->hasOne(PartD::class, 'application_id', 'id');
    }

    public function partE()
    {
        return $this->hasOne(PartE::class, 'application_id', 'id');
    }

    public function partF()
    {
        return $this->hasOne(PartF::class, 'application_id', 'id');
    }

    public function exam()
    {
        return $this->hasOne(Exam::class, 'application_id', 'id');
    }

    public static function check($id)
    {
        $application = Application::with(self::WITH)->find($id);
        if (!isset($application) || empty($application)) {
            return null;
        }
        if (
            isset($application->id) && !empty($application->id)
            && isset($application->aec_id) && !empty($application->aec_id)
            && isset($application->partA) && isset($application->partA->check) && $application->partA->check == 1
            && isset($application->partB) && isset($application->partB->check) && $application->partB->check == 1
            && isset($application->partC) && isset($application->partC->check) && $application->partC->check == 1
            && isset($application->partD) && isset($application->partD->check) && $application->partD->check == 1
            && isset($application->partE) && isset($application->partE->check) && $application->partE->check == 1
            && isset($application->partF) && isset($application->partF->check) && $application->partF->check == 1
            && isset($application->exam) && isset($application->exam->check) && $application->exam->check == 1
        ) {
            $application->check = self::CHECK_VALID;
        } else {
            $application->check = self::CHECK_INVALID;
        }
        $application->save();
        return $application;
    }
}