<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coin;
use App\Models\Exchange;

class GetCoinPair extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:coinpairs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get coin pairs';
  


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

        $from_coin = Coin::take(150)->inRandomOrder()->pluck('symbol');
        $to_coin = Coin::take(150)->inRandomOrder()->pluck('symbol')->toArray();
     
        Exchange::truncate();
        foreach ($from_coin as $key => $value) {
       
        if(in_array($value, $to_coin)){
      
        }else{
            Exchange::create([
             'slug' => strtolower($value)."-to-".strtolower($to_coin[$key]),
             'from_coin_symbol' =>$value,
             'to_coin_symbol' =>$to_coin[$key],
            ]);
        }          
        }
    }
}
