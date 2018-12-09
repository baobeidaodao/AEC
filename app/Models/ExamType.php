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

class ExamType extends Model
{
    protected $connection = 'mysql';
    protected $table = 'exam_type';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

}