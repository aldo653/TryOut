<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SpatieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard',
            'user_management',
            'role_management',
            'permission_management',
            'assignment',
            'assessment',
            'master_jadwal',
            'master_kegiatan', 
            'master_pelanggaran',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'Superadmin']);
        $adminRole->givePermissionTo($permissions);

        $userRole = Role::firstOrCreate(['name' => 'Pengajar']);
        $userRole->givePermissionTo(['dashboard', 'assessment']);

        $studentRole = Role::firstOrCreate(['name' => 'Mahasiswa']);
        $studentRole->givePermissionTo(['dashboard', 'assignment']);

        $adminUser = User::firstOrCreate(
            ['name' => 'admin'],
            [
                'nip_nim' => '123456789',
                'gender' => 'Laki-Laki',
                'password' => bcrypt('admin123')
            ]
        );
        $adminUser->assignRole($adminRole);

        $pengajarUser = User::firstOrCreate(
            ['name' => 'pengajar'],
            [
                'nip_nim' => '987654321',
                'gender' => 'Laki-Laki',
                'password' => bcrypt('pengajar123')
            ]
        );
        $pengajarUser->assignRole($userRole);

        $mahasiswaUser = User::firstOrCreate(
            ['name' => 'mahasiswa'],
            [
                'nip_nim' => '1122334455',
                'gender' => 'Perempuan',
                'password' => bcrypt('mahasiswa123')
            ]
        );
        $mahasiswaUser->assignRole($studentRole);
    }
}
