<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Permission.php
 * Author  : Li Tao
 * DateTime: 2018-02-05 09:01:00
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\EntrustPermission;

/**
 * entrust 插件库的 权限对象
 * Class Permission
 * @package App\Models
 */
class Permission extends EntrustPermission
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

}