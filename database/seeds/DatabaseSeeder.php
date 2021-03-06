<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(adminsTableSeeder::class);
         $this->call(PermissionsTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);
         $this->call(TypesTableSeeder::class);
         $this->call(AttributesTableSeeder::class);
    }
}
