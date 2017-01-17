<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CC\Tool\Object;
class cc_object extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cc:object 
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
        if($this->option('make'))
        {
            $objectName = $this->ask("What your object name ?");
            $label = $this->ask("What your field label name?");
            $object = new Object();
            $object->input([
                "objectname"=>$objectName,
                "fieldlabel"=>$label        
            ]);
            if($object->make())
            {
                echo "Make object success\n";
            }
            echo "\n";
        }else{
            $this->makeInfo();
        }
    }

    private function makeInfo()
    {
        $this->info('Customer Connect V.1');
        echo "\n";
        $this->comment('Options');
        echo "  --make : Make new object\n";
    }
}
