<?php
namespace Fitbit\Exception;

class FitbitException extends \Exception
{
	public $fbMessage = '';
	public $httpCode;

	/*
	 * Default constructor
	 */
	public function __construct($code, $fbMessage=null, $message=null)
	{
		// Assign Fitbit error message, and HTTP Code
		$this->fbMessage = $fbMessage;
		$this->httpCode = $code;

		// If Fitbit message is set, but no standard exception message is;
		// then assign the Fitbit message as the message
		if (isset($fbMessage) && !isset($message))
		{
			$message = $fbMessage;
		}

		// Attempt to convert the HTTP Code to an Integer
		try
		{
			$code = (int)$code;
		}
		catch (Exception $e)
		{
			$code = 0;
		}

		// Execute standard Exception using the message and code
		parent::__construct($message, $code);
	}
}
?>
