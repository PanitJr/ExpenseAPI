<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CC\Tool\Object;
use App\CC\Tool\Block;
use App\CC\Tool\Field;
class cc_field extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cc:field
                            {--object= : The ID of object} 
                            {--block= : The ID of block} 
                            {--field= : field name in database} 
                            {--name= : name field} 
                            {--type= : type} 
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
            if($this->option('object')
            && $this->option('block')
            && $this->option('field')
            && $this->option('name')
            && $this->option('type')
            )
            {

                $blockId = $this->option('block');
                $fieldname = $this->option('field');                
                $fieldlable = $this->option('name');
                $fieldType = $this->option('type');
                
                $Block = Block::find($blockId);
                $field = new Field();

                $field->input([
                 "blockModel" => $Block,
                 "fieldname" => $fieldname,
                 "fieldlabel" => $fieldlable,
                 "fieldtype" => $fieldType,
                ]);
                $Block->addField($field); 
                echo "Create Field Success\n";                      
                echo "\n";  
            }
            else if($this->option('object'))
            {
                $optionid = $this->option('object');
                $option = Object::find($optionid);
                if($option)
                {
                    echo "====Block All Object====\n\n";
                    $blocks = $option->getBlock;
                    foreach ($blocks as $block) {
                        echo "[{$block->id}] : {$block->blocklabel}\n";
                    }
                    echo "\n";
                    $blockId = $this->ask("Please select block input [id]");                
                    $fieldname = $this->ask("Please input field name (format name field database)");                
                    $fieldlable = $this->ask("Please input field lable ");                
                    $fieldType = $this->ask("Please input field type \n see in \nhttps://laravel.com/docs/5.0/schema");     
                    
                    $Block = Block::find($blockId);
                    $field = new Field();

                    $field->input([
                     "blockModel" => $Block,
                     "fieldname" => $fieldname,
                     "fieldlabel" => $fieldlable,
                     "fieldtype" => $fieldType,
                    ]);
                    $Block->addField($field); 
                    echo "Create Field Success\n";                      
                    echo "\n";                      
                }
                else
                {
                    $this->error('Connot find Object by object id');
                }

            }
            else{
                $this->makeInfo();
                $objects = Object::all();
                echo "Object Id \n";
                foreach ($objects as$object) {
                      echo "[{$object->id}] : {$object->name}\n";
                }
                echo "\n";
            }
            
        }else{
            $this->makeInfo();
        }
    }

    private function makeInfo()
    {
        $this->info('Customer Connect V.1');
        echo "\n";
        $this->comment('Options');
        echo "  --make --object=[object_id] : Make new field and Input Option ID\n";
        echo "sample :  php artisan cc:field --make --object=[object_id] \n";
        echo "\n";
    }
}
