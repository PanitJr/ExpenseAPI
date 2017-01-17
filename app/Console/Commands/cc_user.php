<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Object\Users\Users as User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class cc_user extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cc:user
                            {--make : Make new object}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create New Object';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Auth::loginUsingId(1);
        if($this->option('make'))
        {   
            $username = $this->ask("Please add username");                
            $password = $this->ask("Please add password");      
            $User = new User;
            $User->user_name = $username;
            $User->email = $username;
            $User->password = Hash::make($password);
            $User->save();
            echo "Create User Success\n";                      
            echo "\n";                      
        }else{
            $this->makeInfo();
        }
        Auth::logout();
    }

    private function makeInfo()
    {
        $this->info('Customer Connect V.1');
        echo "\n";
        $this->comment('Options');
        echo "  --make";
        echo "sample :  php artisan cc:user --make\n";
        echo "\n";
    }
}
