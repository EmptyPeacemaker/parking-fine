<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class StartProjectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('storage:link');


        if(Schema::hasTable('migrations'))Artisan::call('migrate:reset');
        Artisan::call('migrate');


        $id=User::create([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'password'=>Hash::make('admin')
        ])->id;
        Role::create(['user_id'=>$id,'role_id'=>1]);

    }
}
