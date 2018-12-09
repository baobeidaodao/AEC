<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-20
 * Time: 15:34
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    protected $connection = 'mysql';
    protected $table = 'identity';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}