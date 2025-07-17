<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
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
        $this->call([
            ProductSeeder::class,
            InventorySeeder::class,
            NotificationSeeder::class,
            TaskCategorySeeder::class,
        ]);
        // 
        // Call the real users and tasks seeder for production-like data
        $this->call(RealUsersAndTasksSeeder::class);
    }
}
