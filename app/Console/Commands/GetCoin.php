<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coin;
use App\Libraries\Godex;

class GetCoin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coins:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get coins';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
    	parent::__construct();
    	$this->godex = new Godex();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    	/* Truncate rate */
    	//Coin::truncate();

    	$data = $this->godex->get_coins();

    	if($data['status_code'] == 200){

    		$record = $data['data'];

    		foreach($record as $value){

    			$data = [
    				'symbol' => $value->code,
    				'disabled' => isset($value->disabled) ? $value->disabled : '',
    				'icon' =>  $value->icon,
    				'explorer' => isset($value->explorer) ? $value->explorer : '',
    				'not_available' => isset($value->not_available) ? $value->not_available : '',
    				'coin_name' => $value->name,
    				'networks' => isset($value->networks) ? json_encode($value->networks) : '',
    				'min_amount' => isset($value->min_amount) ? $value->min_amount : '',
    				'multi' => isset($value->multi) ? json_encode($value->multi) : '',
    			];

    			if(empty($value->extra_name)){

    				$data['extra_name'] = null;

    			}else{
    				$data['extra_name'] = $value->extra_name;
    			}

                if(empty($value->has_extra)){

                    $data['has_extra'] = null;

                }else{
                    $data['has_extra'] = $value->has_extra;
                }

    			Coin::create($data);

    		}
    	}else{
    		echo "Oop`s something went wrong.";
    	}
    }
}
