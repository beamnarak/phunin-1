<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'b.soravit@gmail.com',     //'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('admin'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $this->call([
            UnitsTableSeeder::class,
            CategoriesTableSeeder::class,
            DepartmentsTableSeeder::class,
            MachinesTableSeeder::class,
            ShopsTableSeeder::class,
        ]);
    }
}
