<?php

namespace App\Console\Schedule;

use Log;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Object\Promotion\PromotionProduct;
use App\Sync\Salesforce\RealProduct;

class promotion_discount_salesforce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sf:promotion_discount_salesforce';

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
        $productModel = $this->getProductModel();
        $current_date = Carbon::now()->format("Y-m-d");         

        Log::info("start discount ....\n");
        $this->discount($productModel,$current_date);

        Log::info("success discount\n");
        Log::info("start expire ....\n");
        $this->expire($productModel,$current_date);
        Log::info("success expire\n");
    }

    public function getProductModel()
    {
        return PromotionProduct::join('cc_promotions',function($join){   
                $join->on('cc_promotions_product.promotion_id', '=', 'cc_promotions.id');
            })
            ->join('cc_real_products',function($join){   
                $join->on('cc_promotions_product.productline_id', '=', 'cc_real_products.id');
            })
            ->select(['promotionname','product2_sfid','cc_promotions_product.discount','price','pricebookentry_sfid','status','cc_promotions_product.id']);
    }

    /**
     *  Update for discoute to salesforce
    **/
    public function discount($productModel,$current_date)
    {
        $listForDiscount = $productModel
                            ->where('status','ready')
                            ->where('start_date','<=',$current_date)
                            ->where('end_date','>',$current_date)
                            ->get();
        
        foreach ($listForDiscount as $model) {
            try {
                RealProduct::updatePrice($model->pricebookentry_sfid,$model->discount);
                RealProduct::updatePromotion($model->product2_sfid,'true',$model->promotionname,$model->discount);
                $model->status = 'start';
                $model->save();
                Log::info("success update salesforce ".$model->pricebookentry_sfid." : ".$model->discount." \n");
            } catch (Exception $e) {
                Log::info("Fail update salesforce \n");
            }
        }
    }

    /**
     * Update to standard price to salesforce
    **/
    public function expire($productModel,$current_date)
    {
        $listForDiscount = $productModel
                            ->where('status','start')
                            ->where('end_date','<',$current_date)
                            ->get();
        
        foreach ($listForDiscount as $model) {
            try {
                RealProduct::updatePrice($model->pricebookentry_sfid,$model->price);
                RealProduct::updatePromotion($model->product2_sfid,'false');
                $model->status = 'expire';
                $model->save();    
                Log::info("success update salesforce ".$model->pricebookentry_sfid." : ".$model->price." \n");
            } catch (Exception $e) {
                Log::info("Fail update salesforce \n");
            }
            
        }
    }
}
