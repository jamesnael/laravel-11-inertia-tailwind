<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run(): void
  {
    $access = config('user-access.access');
    $userAccess = collect([]);
    foreach ($access as $module) {
      foreach ($module['sub_module'] as $submodule) {
        $userAccess = $userAccess->merge(collect($submodule['activities'])->pluck('value'));
      }
    }

    $role = Role::updateOrCreate(
      [
        'nama_jabatan' => 'Administrator',
        'tipe_user'    => 'Backend User',
      ],
      [
        'nama_jabatan' => 'Administrator',
        'tipe_user'    => 'Backend User',
        'keterangan'   => 'Demo Backend User',
        'hak_akses'    => $userAccess
      ]
    );

    User::updateOrCreate(
      [
        'email' => 'admin@example.com',
      ],
      [
        'nama_lengkap'       => 'Demo Administrator',
        'tanggal_lahir'      => '2000-01-01',
        'nomor_hp'           => '+6281234567890',
        'username'           => 'admin_test',
        'email'              => 'admin@example.com',
        'password'           => Hash::make('password'),
        'alamat_lengkap'     => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'profile_photo_path' => null,
        'id_jabatan'         => $role->id,
        'status'             => true
      ]
    );

    $this->call([
      ImportProvincesSeeder::class,
    ]);
  }
}
