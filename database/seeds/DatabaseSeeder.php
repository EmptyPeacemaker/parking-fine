<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class,10)->create()->pluck('id')->each(function ($user_id){
            \App\Role::create(['user_id'=>$user_id,'role_id'=>0]);

            factory(\App\Cars::class,rand(0,4))->create(['user_id'=>$user_id])->pluck('id')->each(function($car_id){
                factory(\App\Fine::class,rand(0,4))->create(['car_id'=>$car_id]);
                if(rand(0,1)==0)factory(\App\Parking::class)->create(['car_id'=>$car_id]);
            });
        });
    }
}
