<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Taxe;
use App\Models\Company;
use App\Models\OwnershipType;
use App\Models\CompanyOwnershipType;
use App\Models\CompanyTaxe;
use App\Models\CompanyUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
        ]);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $ownershipType = OwnershipType::create([
            'name' => 'Public',
            'status' => 'Active',
            'created_by' => $user->id,
        ]);

        $taxe = Taxe::create([
            'name' => 'VAT 15%',
            'tax_rate' => 15,
            'created_by' => $user->id,
            'status' => 'Active',
        ]);

        $company = Company::create([
            'name' => 'ABC Company',
            'address' => 'Zanzibar',
            'licence_number' => 'LIC12345',
            'tin_number' => 'TIN12345',
            'phone' => '0774071322',
            'email' => 'tawakalshamss@gmail.com',
            // 'created_by' => $user->id,
        ]);

        CompanyOwnershipType::create([
            'company_id' => $company->id,
            'owner_ship_type_id' => $ownershipType->id,
        ]);

        CompanyTaxe::create([
            'company_id' => $company->id,
            'tax_id' => $taxe->id,
        ]);

        CompanyUser::create([
            'company_id' => $company->id,
            'user_id' => $user->id,
        ]);

        // ❌ Hii ilikuwa wrong (CompanyTaxe haipaswi kuwa na user_id)
        // Kama unataka link user to company, create pivot table tofauti
    }
}