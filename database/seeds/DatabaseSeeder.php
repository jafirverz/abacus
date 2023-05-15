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
        $this->call(NewCarStockSeeder::class);
        // factory(App\User::class, 25)->create();
        // factory(App\Role::class, 1)->create();
        // factory(App\Admin::class, 25)->create();
        // factory(App\EmailTemplate::class, 25)->create();
        // factory(App\Status::class, 25)->create();
        // factory(App\Location::class, 50)->create();
        // factory(App\VehicleAdditionalRemark::class, 20)->create();
        // $this->call(VehicleRegistrationSeeder::class);
    }
}
