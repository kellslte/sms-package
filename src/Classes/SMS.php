<?php

namespace Nologo\SMS\Classes;

use GuzzleHttp\Client;


/**
 * 
 */
 abstract class SMS
{
	protected $text,
			  $token,
			  $username,
			  $password,
			  $sender,
			  $response,
			  $client,
			  $receipients,
			  $request;

	private static $httpClient;

	public $httpError;

	/*
	* make sure only one instance of the Httpclient
	* is isntantiated throughout the life of the application
	* this will return an instance of the client
	*/
	public function getInstance()
	{
		if (! self::$httpClient) {
            self::$httpClient = new Client();
        }

        return self::$httpClient;
	}


	/*
	* Define receipients 
	*/


	public function to($numbers)
	{
		$this->receipients = $this->cleanNumber($numbers);
		
		return $this;
	}

	public function cleanNumber($numbers)
	{
		$numbers = trim($numbers);
		$numbers = preg_replace("/\s|\+|-/", '', $numbers);

		return $numbers;
	}


	public function text($text = null)
	{
		if ($text) {
			$this->cleanText($text);
		}

		return $this;
	}


	public function cleanText($text)
	{
		$this->text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($text));

		return $this;
	}
	
     public function getText()
    {
        return $this->text;
    }

    public function from($from)
    {
        $this->sender = $from;

        return $this;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getException()
    {
        return $this->httpError;
    }

}