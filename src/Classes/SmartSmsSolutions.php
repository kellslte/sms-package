<?php



namespace Nologo\SMS\Classes;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;

class SmartSmsSolutions extends SMS
{
	private $baseUrl = 'https://smartsmssolutions.com/api/json.php?';

	private $balanceUrl = 'https://smartsmssolutions.com/api/?';



	public function __construct($message = null)
	{
		$this->token = config('nologo-sms.smart_sms.token');

		if ($message) {
			$this->text($message);
		}

		$headers = [
			'Content-Type' => 'Content-type: application/x-www-form-urlencoded',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36 OPR/47.0.2631.39',
		];

		$this->client = $this->getInstance();
		$this->request = new Request('POST', $this->baseUrl, $headers);
	}


	public function send($text = null)
	{
		if ($text) {
			$this->cleanText($text);
		}

		try{
			$response = $this->client->send($this->request, [
				'query' => [
					'token' => $this->token,
					'type' => 0,
					'to' => $this->receipients,
					'sender' => $this->sender ?? config('nologo-sms.sender'),
					'message' => $this->text,
					'routing' => 2,
				],
			]);

			 $this->response = json_decode($response->getBody()->getContents(), true);

            return array_key_exists('successful', $this->response) ? true : false;
        }
         catch (ClientException $e) {
           
            logger()->error('HTTP Exception in '.__CLASS__.': '.__METHOD__.'=>'.$e->getMessage());
           
            $this->httpError = $e;

            return false;
        }
         catch (\Exception $e) {
           
            logger()->error('SMS Exception in '.__CLASS__.': '.__METHOD__.'=>'.$e->getMessage());
           
            $this->httpError = $e;

            return false;
        }
	
	}

	public function balance()
	{
		$data = [
			'token' => config('nologo-sms.smart_sms.token'),
			'checkbalance' => 1
		];

		$this->response = $this->client->post($this->balanceUrl, $data);

		$balance = file_get_contents($this->response);

		return $balance;
	}


}