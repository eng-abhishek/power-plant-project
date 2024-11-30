<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       if(User::where('is_admin','Y')->count() > 0){

        }else{

         $user = User::updateOrCreate([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'is_admin' => 'Y',
            'role' => 'admin'
        ]);
        }
    }
}
