<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $permission = [
            [
                'name' => 'kategori-create',
                'display_name' => 'Create Kategori',
                'description' => 'Create New Kategori'
            ],
            [
                'name' => 'kategori-list',
                'display_name' => 'Display Kategori Listing',
                'description' => 'List All Kategori'
            ],
            [
                'name' => 'kategori-update',
                'display_name' => 'Update Kategori',
                'description' => 'Update Kategori Information'
            ],
            [
                'name' => 'kategori-delete',
                'display_name' => 'Delete Kategori',
                'description' => 'Delete Kategori'
            ],
            [
                'name' => 'permission-create',
                'display_name' => 'Create Permission',
                'description' => 'Create New Permission'
            ],
            [
                'name' => 'permission-list',
                'display_name' => 'Display Permission Listing',
                'description' => 'List All Permissions'
            ],
            [
                'name' => 'permission-update',
                'display_name' => 'Update Permission',
                'description' => 'Update Permission Information'
            ],
            [
                'name' => 'permission-delete',
                'display_name' => 'Delete Permission',
                'description' => 'Delete Permission'
            ],
            [
                'name' => 'role-create',
                'display_name' => 'Create Role',
                'description' => 'Create New Role'
            ],
            [
                'name' => 'role-list',
                'display_name' => 'Display Role Listing',
                'description' => 'List All Roles'
            ],
            [
                'name' => 'role-update',
                'display_name' => 'Update Role',
                'description' => 'Update Role Information'
            ],
            [
                'name' => 'role-delete',
                'display_name' => 'Delete Role',
                'description' => 'Delete Role'
            ],
            [
                'name' => 'user-create',
                'display_name' => 'Create User',
                'description' => 'Create New User'
            ],
            [
                'name' => 'user-list',
                'display_name' => 'Display User Listing',
                'description' => 'List All Users'
            ],
            [
                'name' => 'user-update',
                'display_name' => 'Update User',
                'description' => 'Update User Information'
            ],
            [
                'name' => 'user-delete',
                'display_name' => 'Delete User',
                'description' => 'Delete User'
            ],
            [
                'name' => 'satuan-create',
                'display_name' => 'Create Satuan',
                'description' => 'Create New Satuan'
            ],
            [
                'name' => 'satuan-list',
                'display_name' => 'Display Satuan Listing',
                'description' => 'List All Satuan'
            ],
            [
                'name' => 'satuan-update',
                'display_name' => 'Update Satuan',
                'description' => 'Update Satuan Information'
            ],
            [
                'name' => 'satuan-delete',
                'display_name' => 'Delete Satuan',
                'description' => 'Delete Satuan Information'
            ],
            [
                'name' => 'bahan-create',
                'display_name' => 'Create Bahan',
                'description' => 'Create New Bahan'
            ],
            [
                'name' => 'bahan-list',
                'display_name' => 'Display Bahan Listing',
                'description' => 'List All Bahan'
            ],
            [
                'name' => 'bahan-update',
                'display_name' => 'Update Bahan',
                'description' => 'Update Bahan Information'
            ],
            [
                'name' => 'bahan-delete',
                'display_name' => 'Delete Bahan',
                'description' => 'Delete Bahan Information'
            ],
            [
                'name' => 'resep-create',
                'display_name' => 'Create Resep',
                'description' => 'Create New Resep'
            ],
            [
                'name' => 'resep-list',
                'display_name' => 'Display Resep Listing',
                'description' => 'List All Resep'
            ],
            [
                'name' => 'resep-update',
                'display_name' => 'Update Resep',
                'description' => 'Update Resep Information'
            ],
            [
                'name' => 'resep-delete',
                'display_name' => 'Delete Resep',
                'description' => 'Delete Resep Information'
            ]
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
