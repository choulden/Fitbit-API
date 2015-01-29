<?php
namespace Fitbit;

class Response
{
	private	$response;
	private	$code;

	public function __construct($response, $code)
	{
		$this->response = $response;
		$this->code = $code;
	}

	public function getResponse()
	{
		return $this->response;
	}

	public function getCode()
	{
		return $this->code;
	}
}
?>
