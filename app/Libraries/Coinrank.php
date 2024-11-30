<?php
namespace App\Libraries;
use GuzzleHttp\Client;

class Coinrank{

	protected $client   = NULL;
	protected $api_url  = NULL;
	protected $headers = NULL;
	protected $response = NULL;

	private function api_call($method = "GET", $request_url = "", $request_params = [])
	{

		$method = strtoupper($method);

		$this->api_url = 'https://api.coinranking.com/v2/'.$request_url;
        
        $coinranking_key = get_coinranking_key();
        // dd($coinranking_key);
		$this->headers = [
			'X-Requested-With' => 'application/json',
			'charset' => 'utf-8',
			'X-Requested-With' => 'XMLHttpRequest',
			'x-access-token' => $coinranking_key,
			//'x-access-token' => 'coinranking6dd68ecb66210c5f589e0b3d8e60c0837dbe8b4b8df41b26'
		];

		if($request_url == 'create'){
			$this->headers['x-forwarded-for'] = request()->ip();
			$this->headers['x-user-agent'] = $_SERVER['HTTP_USER_AGENT'];
		}

		/* Guzzle Client */
		try {

			$this->client  = new Client();

			if($method == 'POST'){

				$params = [
					'headers' => $this->headers,
					'body' => json_encode($request_params),
				];
			}else{
				$params = [
					'headers' => $this->headers,
					'query' => $request_params,
				];
			}

			$this->response = $this->client->request($method, $this->api_url, $params);
            //dd(json_decode($this->response->getBody()->getContents()));

           //Get Success Response
			return (object) ["status_code" => $this->response->getStatusCode(), "data" => json_decode($this->response->getBody()->getContents())];

		}catch (\GuzzleHttp\Exception\BadResponseException $e) {
            //Get Error Response

			return (object) ["status_code" => $e->getCode(), "data" => json_decode((string) $e->getResponse()->getBody())];

		}
	}

	public function coins($symbol){

		$result = $this->api_call("GET", "coins",[
        'symbols[]'=>$symbol
		]);

		return collect($result);
	}

		public function get_coins_info_uuid($uuid){

		$result = $this->api_call("GET", "coin/".$uuid);

		return collect($result);
	    }

		public function get_coin_uuid($offset,$limit){

		$result = $this->api_call("GET", "coins",[
        'offset' => $offset,
        'limit' => $limit,
		]);

		// $db_coins = Coin::whereNull('coinranking_uuid')->get();

		// $offset = 5000;
		// $limit = 100;       

		// $coins_info = $this->coinranking->get_coin_uuid($offset,$limit);
		// ///dd($coins_info);
		// $coin_array = collect($coins_info['data']->data->coins);

		// foreach ($db_coins as $key => $value) {

		// $coin_uuid_info = $coin_array->where('symbol',$value->symbol)->first();

		// if(!empty($coin_uuid_info)){
		// Coin::where('symbol',$value->symbol)->update(['coinranking_uuid'=>$coin_uuid_info->uuid]);
		// }
		// }

		return collect($result);
	}

}
?>