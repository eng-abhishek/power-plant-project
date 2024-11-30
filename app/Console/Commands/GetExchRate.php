<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\Exch;
use App\Models\ExchRate;

class GetExchRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchrate:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Exch Rate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->exch = new Exch();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         /* Truncate rate */
       ExchRate::truncate();
        
        $rate_mode = array('flat','dynamic');
        
        foreach ($rate_mode as $rate_key => $rate_value) {
      
        $rates = $this->exch->get_rates($rate_value);

        if($rates['status_code'] == 200){
        foreach($rates['data'] as $key => $value){
           ExchRate::create([
           'pair'=> $key,
           'rate'=> $value->rate,
           'rate_mode'=> $rate_value,
           ]);
        }
       }
    }
    }
}
