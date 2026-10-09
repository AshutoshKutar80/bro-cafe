<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['mobile' => '9999999999'],
            [
                'name' => 'Admin',
                'email' => 'admin@brocafe.test',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active',
                'mobile_verified_at' => now(),
            ]
        );

        // Demo partner
        $partnerUser = User::updateOrCreate(
            ['mobile' => '8888888888'],
            [
                'name' => 'Demo Rider',
                'password' => Hash::make('rider123'),
                'role' => 'partner',
                'mobile_verified_at' => now(),
            ]
        );
        \App\Models\DeliveryPartner::updateOrCreate(
            ['user_id' => $partnerUser->id],
            ['vehicle_type' => 'bike', 'vehicle_number' => 'DL01AB1234', 'is_active' => true]
        );
    }
}