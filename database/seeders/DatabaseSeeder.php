<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(EmailTemplateSeeder::class);
        $this->call(EmailFormatSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(LoginHistorySeeder::class);

        $this->call(FuelConfigSeeder::class);

        $this->call(ProductSeeder::class);

        $this->call(DispenserSeeder::class);

        $this->call(DispenserNozzleSeeder::class);

        $this->call(PartyDetailSeeder::class);

        $this->call(VehicleSeeder::class);

        $this->call(OrganizationSeeder::class);

        $this->call(ShiftSeeder::class);

        $this->call(ShiftNozzleReadingSeeder::class);

        $this->call(FuelTestSeeder::class);

        $this->call(SanctionSeeder::class);

        $this->call(DemandSeeder::class);

        $this->call(DemandProductSeeder::class);

        $this->call(TransactionSeeder::class);

        $this->call(TransactionDetailSeeder::class);

        $this->call(NotificationSeeder::class);

        $this->call(JsmApiLogSeeder::class);

        $this->call(SaleSeeder::class);

        $this->call(PushNotificationTemplateSeeder::class);

        $this->call(SmsTemplateSeeder::class);
    }
}
