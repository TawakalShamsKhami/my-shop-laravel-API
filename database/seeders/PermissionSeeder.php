<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'name' => 'manage-ownership-types',
                'description' => 'Can manage ownership types (create, view, delete)',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'view-ownership-types',
                'description' => 'Can view ownership types',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'delete-ownership-types',
                'description' => 'Can delete ownership types',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
