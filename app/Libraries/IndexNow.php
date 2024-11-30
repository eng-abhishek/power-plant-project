<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class IndexNow
{
    /**
     * Submit urls to indexnow.
     *
     * @param  array|string  $urls
     * @return array
     */
    public function submit($urls){
        if(app()->environment() == 'production'){
            $search_engines = config('indexnow.search_engines');

            if(is_array($urls)){

                $chunks_of_url = array_chunk($urls, 10000);

                foreach($chunks_of_url as $url_list){

                    $headers = [
                        'Content-Type' => 'application/json; charset=utf-8'
                    ];

                    $params = [
                        'host' => 'chainswap.io',
                        'key' => config('indexnow.key'),
                        'keyLocation' => config('indexnow.key_location'),
                        'urlList' => $url_list
                    ];

                    foreach($search_engines as $domain){

                        $request_url = 'https://'.$domain.'/indexnow';

                        $response = Http::withHeaders($headers)->post($request_url, $params);
                    }
                }

            }else{

                $headers = [
                    'Content-Type' => 'application/json; charset=utf-8'
                ];

                $params = [
                    'key' => config('indexnow.key'),
                    'keyLocation' => config('indexnow.key_location'),
                    'url' => $urls
                ];

                foreach($search_engines as $domain){

                    $request_url = 'https://'.$domain.'/indexnow';

                    $response = Http::withHeaders($headers)->get($request_url, $params);
                }
            }
        }
    }
}