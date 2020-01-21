<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(BanksSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CampSeeder::class);
        $this->call(CampPhotoSeeder::class);
        $this->call(CampPaymentSeeder::class);
    }
}
