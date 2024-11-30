<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coin;
use App\Models\Exchange;
use App\Libraries\Coinrank;

class GetCoinRankingUuid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:coinrankinguuid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get coinranking uuid';
  


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->coinranking = new Coinrank();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $null_db_coins = Coin::whereNull('coinranking_uuid');
        $db_coins = $null_db_coins->get();
        $null_db_coins->count();

        $offset = 0;
        $limit = 100;
        $i=0;

        while($null_db_coins->count() > 0){

        $coins_info = $this->coinranking->get_coin_uuid($offset,$limit);
        //dd($coins_info);
        if($coins_info['status_code'] == 200){

        $coin_array = collect($coins_info['data']->data->coins);

        foreach ($db_coins as $key => $value) {

        $coin_uuid_info = $coin_array->where('symbol',$value->symbol)->first();

        if(!empty($coin_uuid_info)){
        Coin::where('symbol',$value->symbol)->update(['coinranking_uuid'=>$coin_uuid_info->uuid]);
        }
        }
        
        // $i=$i+1;
        // $offset = $i * 100;
        // $limit = $limit;
        // echo $i."<br>";
        // echo $offset."<br>";
        // echo $limit."<br>";
        }
        }
    }
}
