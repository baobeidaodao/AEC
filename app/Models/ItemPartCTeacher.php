<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-20
 * Time: 15:34
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPartCTeacher extends Model
{
    protected $connection = 'mysql';
    protected $table = 'item_part_c_teacher';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function partCTeacher()
    {
        return $this->hasOne(PartCTeacher::class, 'id', 'part_c_teacher_id');
    }
}