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

}