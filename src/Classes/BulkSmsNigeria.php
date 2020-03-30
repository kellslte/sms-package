<?php


namespace Nologo\SMS\Classes;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;


  class BulkSmsNigeria extends SMS
{
	private $baseUrl = 'https://www.bulksmsnigeria.com/api/v1/sms/create';
	
	public function __construct($message = null)
	{
		$this->token = config('nologo-sms.bulk_sms_nigeria.token');

		if ($message) {
			$this->text($message);
		}

		$this->client = self::getInstance();
		$this->request = new Request('POST', $this->baseUrl);
	}


	public function send($text = null)
	{
		if ($text) {
			$this->cleanText($text);
		}

		try{
			$response = $this->client->send($this->request, [
				'params' => [
					'api_token' => config('nologo-sms.bulk_sms_nigeria.token'),
					'to' => $this->receipients,
					'from' => $this->sender ?? config('nologo-sms.sender'),
					'body' => $this->text,
					'dnd' => config('nologo-sms.bulk_sms_nigeria.dnd'),
				],
			]);



			$response = json_decode($response->getBody()->getContents(), true);



			$this->response =  array_key_exists('error', $response) ? $response['error']['message'] : $response['data']['message'];


			 return $response['data']['status'] == 'success' ? true : false;
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
}