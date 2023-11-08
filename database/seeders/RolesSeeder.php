<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin     =   Role::create(['name' =>'admin']);
        $role_patient   =   Role::create(['name' =>'patient']);
        $role_doctor    =   Role::create(['name' =>'doctor']);

        $manage_medicine = Permission::create(['name' => 'manage-medicine']);
        $manage_patient = Permission::create(['name' => 'manage-patient']);
        $manage_service = Permission::create(['name' => 'manage-service']);
        $manage_doctors = Permission::create(['name' => 'manage-doctors']);
        $manage_category = Permission::create(['name' => 'manage-category']);
        $manage_type = Permission::create(['name' => 'manage-type']);
        $manage_appointment = Permission::create(['name' => 'manage-appointment']);
        $manage_user =  Permission::create(['name' => 'manage-user']);
        $add_appointment =  Permission::create(['name' => 'add-appointment']);
        $edit_appointment =  Permission::create(['name' => 'edit-appointment']);
        $show_appointment =  Permission::create(['name' => 'show-appointment']);
        $delete_appointment =  Permission::create(['name' => 'delete-appointment']);

        $permission_admin =  [ $manage_medicine, $manage_patient,$manage_service,$manage_doctors,
                                $manage_category, $manage_type, $add_appointment, $manage_user, $edit_appointment, $show_appointment, $delete_appointment ];

        $permission_doctor =  [$add_appointment, $manage_patient,$edit_appointment, $show_appointment, $delete_appointment ];

        $role_admin->syncPermissions($permission_admin);
        $role_doctor->syncPermissions($permission_doctor);
        $role_patient->givePermissionTo($add_appointment, $edit_appointment, $delete_appointment);

        User::find(1)->assignRole($role_admin);
        User::find(2)->assignRole($role_patient);
        User::find(3)->assignRole($role_doctor);
    }
}
