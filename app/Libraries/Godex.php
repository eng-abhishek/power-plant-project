<?php
namespace App\Libraries;
use GuzzleHttp\Client;

class Godex{
	
	protected $client   = NULL;
	protected $api_url  = NULL;
	protected $headers = NULL;
	protected $response = NULL;
    
    private function api_call($method = "GET", $request_url = "", $request_params = [])
	{
		$method = strtoupper($method);
		$this->api_url = 'https://api.godex.io/api/v1/'.$request_url;        
		$this->headers = [   
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'charset' => 'utf-8'
		      ];
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

		}catch(\GuzzleHttp\Exception\BadResponseException $e) {
            //Get Error Response

			return (object) ["status_code" => $e->getCode(), "data" => json_decode((string) $e->getResponse()->getBody())];
		}
	}

	    public function get_coins(){
    	$result = $this->api_call("GET", "coins");
    	return collect($result);
       }

       public function get_info($from_coin,$to_coin,$amount){
    	
    	$result = $this->api_call("POST", "info",[
        'from' => $from_coin,
        'to' => $to_coin,
        'amount' => $amount,
    	]);
        
    	return collect($result);
       }

        public function create_exchange($from_coin,$to_coin,$amount,$address,$affiliate_id,$refund_address,$send_network,$receive_network){    

	    $result = $this->api_call("POST", "transaction",[
	    	
        "coin_from" => $from_coin,
        "coin_to" => $to_coin,
        "deposit_amount"  => $amount,
        "withdrawal"  => $address,
        "withdrawal_extra_id"  => 'qbGDbH9gwrAkJTM6gxsfQpWYMfe8zRuZsSpoU77sx73peCPbzdZaUWW9tKWbBDs3hmeV',
        "affiliate_id"  => $affiliate_id,
        "return_extra_id" => $refund_address,
        "coin_to_network" => ($receive_network) ? $receive_network : null,
        "coin_from_network" => ($send_network) ? $send_network : null,
    	]);
         
    	return collect($result);
       }

       public function get_transaction($txn_id){
        $result = $this->api_call("GET", "transaction/".$txn_id);
    	return collect($result);
       }
}
