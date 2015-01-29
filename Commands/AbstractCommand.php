<?php
/*
 * AbstractType()
 */
namespace Fitbit\Commands;

use Fitbit\Client;
use Fitbit\Commands\CommandHandler;
use Fitbit\Exception\FitbitException;

abstract class AbstractCommand
{
	protected $client;
	protected $oauth;

	/*
	 * Default constructor
	 *
	 * Assigns the Fitbit Client and OAuth classes
	 */
	public function __construct(Client $client)
	{
		$this->client = $client;
		$this->oauth = $this->client->OAuth();
	}

        /*
         * Generic call routine, executes a retrieve request with the
         * requested class turned into the command namd.
	 *
	 * Function is overriden in specific classes where validation is required,
	 * or the command is not a generic retrieve.
         */
        public function __call($name, $args=null)
        {
                return $this->retrieve($name, $args);
        }

	/*
	 * Retrieves data from the API
	 */
	public function retrieve($method, $param=null)
	{
		// Retrieve the URL
		$url = CommandHandler::getCommandURL($method);

		// Retrieve the expected response code
		$code = CommandHandler::getCommandCode($method);

		// Check for URL and Code response
		if (!isset($url) || !isset($code))
		{
			throw new FitbitException('', 'Could not retrieve API details');
			return;
		}

		// Replace string variables with parameters if they exist
		if (isset($param))
		{
			// Determine if param is an array, use vsprintf if it is, otherwise sprintf
			if (is_array($param))
			{
				$url = vsprintf($url, $param);
			}
			else
			{
				$url = sprintf($url, $param);
			}
		}

		// Execute API query
		$this->client->oauthFetch($url, null, OAUTH_HTTP_METHOD_GET);

		// Retrieve response
		$response = $this->oauth->getLastResponse();
		$responseInfo = $this->oauth->getLastResponseInfo();

		// Match the response code against the expected response code
		if (!strcmp($responseInfo['http_code'], $code))
		{
			// Parse the response
			$response = $this->client->parseResponse($response);

			// If response is valid, return the response; otherwise throw an error
			if ($response)
			{
				return $response;
			}
			else
			{
				throw new FitbitException($responseInfo['http_code'], 'Fitbit request failed');
			}
		}
		else
		{
			throw new FitbitException($responseInfo['http_code'], 'Fitbit request failed');
		}
	}

	/*
	 * Posts data to the API
	 */
	public function post($method, $param, $post_param)
	{
		// Retrieve the URL
		$url = CommandHandler::getCommandURL($method);

		// Retrieve the expected response code
//		$code = Commands::getCommandCode($method);

		// Check for URL and Code response
//		if (!isset($url) || !isset($code))
		if (!isset($url))
		{
			throw new FitbitException('', 'Could not retrieve API details');
			return;
		}

		// Replace string variables with parameters if they exist
		if (isset($param))
		{
			$url = sprintf($url, $param);
		}

		// Execute API query
		$this->client->oauthFetch($url, $param, OAUTH_HTTP_METHOD_POST);

		// Retrieve response
		$response = $this->oauth->getLastResponse();
		$responseInfo = $this->oauth->getLastResponseInfo();

		// Match the response code against the expected response code
		switch($responseInfo['code'])
		{
			case 201:
				$response = $this->client->parseResponse($response);
				if ($response)
				{
					return $response;
				}
				else
				{
					throw new FitbitException($responseInfo['code'], 'Fitbit request failed');
				}
				break;
			case 204:
				return true;
			default:
				$response = $this->client->parseResponse($response);
				if (!$response)
				{
					throw new FitbitException($responseInfo['code'], 'Fitbit request failed');
				}
				else
				{
					throw new FitbitException($responseInfo['code'], $response->message, 'Fitbit request failed');
				}

				break;
		}
	}
}
?>
