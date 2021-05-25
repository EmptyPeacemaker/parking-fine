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
        for ($i=0;$i<12;$i++){
            factory(\App\Cars::class)->make(['user_id'=>1])->save();
        }
        foreach (factory(\App\User::class,10)->make() as $user){
            $user->save();
            \App\Role::create(['user_id'=>$user->id,'role_id'=>0]);
            for ($i=0;$i<rand(1,3);$i++){
                factory(\App\Cars::class)->make(['user_id'=>$user->id])->save();
            }
        }

    }
}
