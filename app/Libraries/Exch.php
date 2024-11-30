<?php
namespace App\Libraries;
use GuzzleHttp\Client;

class Exch{

	protected $client   = NULL;
	protected $api_url  = NULL;
	protected $headers = NULL;
	protected $response = NULL;

	private function api_call($method = "GET", $request_url = "", $request_params = [])
	{

		$method = strtoupper($method);

		$this->api_url = 'https://exch.cx/api/'.$request_url;

		$this->headers = [
			'X-Requested-With' => 'application/json',
			'charset' => 'utf-8',
			'X-Requested-With' => 'XMLHttpRequest',
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

           //Get Success Response
			return (object) ["status_code" => $this->response->getStatusCode(), "data" => json_decode($this->response->getBody()->getContents())];

		}catch (\GuzzleHttp\Exception\BadResponseException $e) {
            //Get Error Response

			return (object) ["status_code" => $e->getCode(), "data" => json_decode((string) $e->getResponse()->getBody())];

		}
	}

	public function create_order($currency_from,$currency_to,$to_address,$refund_address,$rate_mode,$referral_id){

		$result = $this->api_call("GET", "create",[
			'from_currency' => $currency_from,
			'to_currency' => $currency_to,
			'to_address' => $to_address,
			'refund_address' => $refund_address,
			// 'svc_fee_override' => $commission_precentage,
			'rate_mode' => $rate_mode,
			'fee_option' => 'f',
			'aggregation' => 'yes',
			'ref' => $referral_id,
		]);

		return collect($result);
	}


	public function get_order_details($orderid){

		$result = $this->api_call("GET", "order",[
			'orderid' => $orderid
		]);

		return collect($result);
	}

    /**
     * Create order.
     *
     * @return array
     */

    public function get_rates($rate_mode){

    	$result = $this->api_call("GET", "rates",[
    		'rate_mode' => $rate_mode
    	]);

    	return collect($result);
    }

    public function get_valume(){

    	$result = $this->api_call("GET", "volume");
    	return collect($result);
    }

    public function fetch_guarantee($orderid){

    	$result = $this->api_call("GET", "fetch_guarantee",[
    		'orderid' => $orderid
    	]);

    	return collect($result);
    }

    public function get_refund($orderid){
        
    	$result = $this->api_call("GET", "refund",[
    		'orderid'=>$orderid
    	]);
    	
    	return collect($result);
    }

}
?>