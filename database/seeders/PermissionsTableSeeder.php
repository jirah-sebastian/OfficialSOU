<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'activity_create',
            ],
            [
                'id'    => 20,
                'title' => 'activity_edit',
            ],
            [
                'id'    => 21,
                'title' => 'activity_show',
            ],
            [
                'id'    => 22,
                'title' => 'activity_delete',
            ],
            [
                'id'    => 23,
                'title' => 'activity_access',
            ],
            [
                'id'    => 24,
                'title' => 'announcement_create',
            ],
            [
                'id'    => 25,
                'title' => 'announcement_edit',
            ],
            [
                'id'    => 26,
                'title' => 'announcement_show',
            ],
            [
                'id'    => 27,
                'title' => 'announcement_delete',
            ],
            [
                'id'    => 28,
                'title' => 'announcement_access',
            ],
            [
                'id'    => 29,
                'title' => 'resource_create',
            ],
            [
                'id'    => 30,
                'title' => 'resource_edit',
            ],
            [
                'id'    => 31,
                'title' => 'resource_show',
            ],
            [
                'id'    => 32,
                'title' => 'resource_delete',
            ],
            [
                'id'    => 33,
                'title' => 'resource_access',
            ],
            [
                'id'    => 34,
                'title' => 'so_category_create',
            ],
            [
                'id'    => 35,
                'title' => 'so_category_edit',
            ],
            [
                'id'    => 36,
                'title' => 'so_category_show',
            ],
            [
                'id'    => 37,
                'title' => 'so_category_delete',
            ],
            [
                'id'    => 38,
                'title' => 'so_category_access',
            ],
            [
                'id'    => 39,
                'title' => 'so_list_create',
            ],
            [
                'id'    => 40,
                'title' => 'so_list_edit',
            ],
            [
                'id'    => 41,
                'title' => 'so_list_show',
            ],
            [
                'id'    => 42,
                'title' => 'so_list_delete',
            ],
            [
                'id'    => 43,
                'title' => 'so_list_access',
            ],
            [
                'id'    => 44,
                'title' => 'so_registration_create',
            ],
            [
                'id'    => 45,
                'title' => 'so_registration_edit',
            ],
            [
                'id'    => 46,
                'title' => 'so_registration_show',
            ],
            [
                'id'    => 47,
                'title' => 'so_registration_delete',
            ],
            [
                'id'    => 48,
                'title' => 'so_registration_access',
            ],
            [
                'id'    => 49,
                'title' => 'about_create',
            ],
            [
                'id'    => 50,
                'title' => 'about_edit',
            ],
            [
                'id'    => 51,
                'title' => 'about_show',
            ],
            [
                'id'    => 52,
                'title' => 'about_delete',
            ],
            [
                'id'    => 53,
                'title' => 'about_access',
            ],
            [
                'id'    => 54,
                'title' => 'title_create',
            ],
            [
                'id'    => 55,
                'title' => 'title_edit',
            ],
            [
                'id'    => 56,
                'title' => 'title_show',
            ],
            [
                'id'    => 57,
                'title' => 'title_delete',
            ],
            [
                'id'    => 58,
                'title' => 'title_access',
            ],
            [
                'id'    => 59,
                'title' => 'organization_application_form_create',
            ],
            [
                'id'    => 60,
                'title' => 'organization_application_form_edit',
            ],
            [
                'id'    => 61,
                'title' => 'organization_application_form_show',
            ],
            [
                'id'    => 62,
                'title' => 'organization_application_form_delete',
            ],
            [
                'id'    => 63,
                'title' => 'organization_application_form_access',
            ],
            [
                'id'    => 64,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
