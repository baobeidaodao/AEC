<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * 此类用于创建初始的角色权限表和初始用户
 * Class PermissionTableSeeder
 */
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 临时关闭 mysql 外键约束
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // 清空表
        (new Permission)->truncate();
        (new Role)->truncate();
        (new User)->truncate();
        DB::table('role_user')->delete();
        DB::table('permission_role')->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        // 创建初始用户
        $user = (new User)->create([
            'name' => 'admin',
            'email' => 'admin@aec.com',
            'password' => bcrypt('admin'),
        ]);

        // 创建初始角色
        $role = (new Role)->create([
            'name' => 'admin',
            'display_name' => '超级管理员',
            'description' => '超级管理员',
        ]);

        // 创建相应的初始权限
        $permissionArray = [];
        $permissionArray[] = ['name' => 'admin', 'display_name' => '超级管理员', 'description' => '超级管理员',];
        $permissionArray[] = ['name' => 'view_role', 'display_name' => '查看角色', 'description' => '查看角色',];
        $permissionArray[] = ['name' => 'create_role', 'display_name' => '创建角色', 'description' => '创建角色',];
        $permissionArray[] = ['name' => 'edit_role', 'display_name' => '编辑角色', 'description' => '编辑角色',];
        $permissionArray[] = ['name' => 'delete_role', 'display_name' => '删除角色', 'description' => '删除角色',];
        $permissionArray[] = ['name' => 'view_permission', 'display_name' => '查看权限', 'description' => '查看权限',];
        $permissionArray[] = ['name' => 'create_permission', 'display_name' => '创建权限', 'description' => '创建权限',];
        $permissionArray[] = ['name' => 'edit_permission', 'display_name' => '编辑权限', 'description' => '编辑权限',];
        $permissionArray[] = ['name' => 'delete_permission', 'display_name' => '删除权限', 'description' => '删除权限',];
        $permissionArray[] = ['name' => 'view_user', 'display_name' => '查看用户', 'description' => '查看用户',];
        $permissionArray[] = ['name' => 'create_user', 'display_name' => '创建用户', 'description' => '创建用户',];
        $permissionArray[] = ['name' => 'edit_user', 'display_name' => '编辑用户', 'description' => '编辑用户',];
        $permissionArray[] = ['name' => 'delete_user', 'display_name' => '删除用户', 'description' => '删除用户',];

        $permissionArray[] = ['name' => 'navigation', 'display_name' => '导航', 'description' => '导航',];
        $permissionArray[] = ['name' => 'export', 'display_name' => '导出', 'description' => '导出',];

        $permissions = [];
        foreach ($permissionArray as $permissionData) {
            $permission = (new Permission)->create($permissionData);
            $permissions[] = $permission;
        }

        // 给角色赋予权限
        $role->attachPermissions($permissions);

        // 给用户指定角色
        $user->attachRole($role);


        // 以下为 二级管理员角色和权限
        $role = (new Role)->create([
            'name' => 'secondary_admin',
            'display_name' => '二级管理员',
            'description' => '二级管理员',
        ]);

        $permissions = [];
        $permissionArray = [];
        $permissionArray[] = ['name' => 'secondary_admin', 'display_name' => '二级管理员', 'description' => '二级管理员',];
        foreach ($permissionArray as $permissionData) {
            $permission = (new Permission)->create($permissionData);
            $permissions[] = $permission;
        }

        $role->attachPermissions($permissions);


        // 以下为 申请者角色和权限
        $role = (new Role)->create([
            'name' => 'application_admin',
            'display_name' => '申请者',
            'description' => '申请者',
        ]);

        $permissions = [];
        $permissionArray = [];
        $permissionArray[] = ['name' => 'view_application', 'display_name' => '查看申请', 'description' => '查看申请',];
        $permissionArray[] = ['name' => 'create_application', 'display_name' => '创建申请', 'description' => '创建申请',];
        $permissionArray[] = ['name' => 'update_application', 'display_name' => '更新申请', 'description' => '更新申请',];
        $permissionArray[] = ['name' => 'delete_application', 'display_name' => '删除申请', 'description' => '删除申请',];
        foreach ($permissionArray as $permissionData) {
            $permission = (new Permission)->create($permissionData);
            $permissions[] = $permission;
        }

        $role->attachPermissions($permissions);

    }

}
