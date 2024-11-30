<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class IndexNow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'indexnow:submit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Submit urls to indexnow';

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
        // ini_set('memory_limit', '1024');

        try{

            $urls = [
                route('home'),
                route('about'),
                route('contact-us'),
                route('history'),
                route('faq'),
                route('privacy-policy'),
                route('term-condition'),
                route('exchange'),
                route('how-it-works')
            ];

            foreach(\App\Models\Exchange::select('slug')->cursor() as $coin_pairs_result){
                $urls[] = route('exchange-detail', ['slug' => $coin_pairs_result->slug]);
            }
            
            if(count($urls) > 0){
                app('indexnow')->submit($urls);
            }

            \Log::info('Cron-IndexNow: Urls submitted successfully');

        } catch (\Exception $e) {
            \Log::error('Cron-IndexNow: '.$e->getMessage());
        }
    }
}
