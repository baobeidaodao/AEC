<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-20
 * Time: 15:34
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aec extends Model
{
    protected $connection = 'mysql';
    protected $table = 'aec';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}