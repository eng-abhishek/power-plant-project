<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReferralCommission;

class CommissionSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commission:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync commission';

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
     * @return int
     */
    public function handle()
     {
     
     $exchange_response = ReferralCommission::take(2)->whereNull('exchange_amount_in_btc')->orwhereNull('commission_amount_in_btc')->get();
    
     foreach ($exchange_response as $key => $value) {
          # code...
       if($value->from_coin == 'btc'){

         $commission_amount = $value->commission_amount;
         $exchange_amount = $value->exchange_amount;
        
       }else{
       
          $commission_amount = ReferralCommission::convertCryptoToBTC(strtolower($value->from_coin),$value->commission_amount);

           $exchange_amount = ReferralCommission::convertCryptoToBTC(strtolower($value->from_coin),$value->exchange_amount);
      }

      $record = array(
       'commission_amount_in_btc'=> $commission_amount,
       'exchange_amount_in_btc'=> $exchange_amount,
        // 'commission_amount_in_btc'=> $value->commission_amount,
        // 'exchange_amount_in_btc'=> $value->exchange_amount,
     );
      ReferralCommission::where('id',$value->id)->update($record);
    }
  }
}
