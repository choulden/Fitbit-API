<?php
namespace Fitbit;

use OAuth;
use Fitbit\Exception\FitbitException;

class Client
{
	private $authHost = 'www.fitbit.com';
	private $apiHost = 'api.fitbit.com';

	private $baseApiUrl;
	private $authUrl;
	private $requestTokenUrl;
	private $accessTokenUrl;

	protected $oauth;
	protected $oauthToken;
	protected $oauthSecret;

	protected $responseFormat;

	private $userID = '-';

	private $userAgent = 'FitbitPHPAPI 0.10';

	/*
	 * Default constructor
	 */
	public function __construct($key, $secret, $userAgent=null, $response_format = 'json')
	{
		// Check for API Key and Secret, throw an exception if they were not passed
		if (!isset($key) || !isset($secret))
		{
			throw new Exception('No OAuth details specified');
		}

		// Setup the API Url variables
		$this->initUrls();

		// Copy the key & secret variables
		$this->key = $key;
		$this->secret = $secret;

		// Attempt to create a new OAuth session
		try
		{	
			$this->oauth = new OAuth($key, $secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION);
		}
		catch (OAuthException $e)
		{
			throw new Exception($e->getMessage());
		}

		// Enable OAuth Debugging - Temporary
		$this->oauth->enableDebug();

		// If userAgent was specified, copy the variable
		if (isset($userAgent))
		{
			$this->userAgent = $userAgent;
		}

		// Assign the response format, usually JSON
		$this->responseFormat = $response_format;
	}

	/*
	 * Retrieves the session status to the Fitbit API
	 */
	public function getSessionStatus()
	{
		// Retrieve the session ID
		$session = session_id();

		// If session ID is empty, start a new session
		if (empty($session))
		{
			session_start();
		}

		// If no 'fitbit_Session' variable exists within the Session, create it and set to 0
		if (empty($_SESSION['fitbit_Session']))
		{
			$_SESSION['fitbit_Session'] = 0;
		}

		// Return the fibit Session status
		return (int)$_SESSION['fitbit_Session'];
	}

	/*
	 * Creates a new Fitbit API session
	 */
	public function startSession($callbackUrl, $cookie=true)
	{
		// Retrieve the session ID
		$session = session_id();

		// If session ID is empty, start a new session
		if (empty($session))
		{
			session_start();
		}

		// If no 'fitbit_Session' variable exists within the Session, create it and set to 0
		if (empty($_SESSION['fitbit_Session']))
		{
			$_SESSION['fitbit_Session'] = 0;
		}

		// If no OAuth Token exists within the Session, but the Fitbit Session is established, reset it to 0
		if (!isset($_GET['oauth_token']) && $_SESSION['fitbit_Session'] == 1)
		{
			$_SESSION['fitbit_Session'] = 0;
		}

		/*
		 * Process the fitbit session
		 * State:
		 *	0 - Create a token request and redirect to Fitbit for authorization
		 *	1 - Request an access token
		 *	2 - Session established
		 */
		if ($_SESSION['fitbit_Session'] == 0)
		{
			// Request a token from the Fitbit API
			$requestToken_info = $this->oauth->getRequestToken($this->requestTokenUrl, $callbackUrl);

			// Assign the Token secret to the session, and set the session to 1
			$_SESSION['fitbit_Secret'] = $requestToken_info['oauth_token_secret'];
			$_SESSION['fitbit_Session'] = 1;

			// Redirect to the Fitbit page to authorize this application
			header('Location: ' . $this->authUrl . '?oauth_token=' . $requestToken_info['oauth_token']);
			exit;
		}
		else if ($_SESSION['fitbit_Session'] == 1)
		{
			// Set the OAuth request token details, and request an access token
			$this->oauth->setToken($_GET['oauth_token'], $_SESSION['fitbit_Secret']);
			$accessToken_info = $this->oauth->getAccessToken($this->accessTokenUrl);

			// Set the session state to 2, assign the token & secret to the OAuth session
			$_SESSION['fitbit_Session'] = 2;
			$_SESSION['fitbit_Token'] = $accessToken_info['oauth_token'];
			$_SESSION['fitbit_Secret'] = $accessToken_info['oauth_token_secret'];

			$this->setOAuthDetails($_SESSION['fitbit_Token'], $_SESSION['fitbit_Secret']);
			return 1;
		}
		else if ($_SESSION['fitbit_Session'] == 2)
		{
			// Assign the token & secret to the OAuth session
			$this->setOAuthDetails($_SESSION['fitbit_Token'], $_SESSION['fitbit_Secret']);
			return 2;
		}
	}

	/*
	 * Reset the session
	 */
	public function resetSession()
	{
		$_SESSION['fitbit_Session'] = 0;
	}

	/*
	 * Return the current user ID
	 */
	public function getUserID()
	{
		return $this->userID;
	}

	/*
	 * Set the current user ID
	 */
	public function setUserID($userID)
	{
		$this->userID = $userID;
	}

	/*
	 * Return the OAuth object
	 *
	 * Used by Types classes to communicate with API
	 */
	public function OAuth()
	{
		return $this->oauth;
	}

	/*
	 * Set the OAuth details
	 */
	private function setOAuthDetails($token, $secret)
	{
		// Assign token & secret variables
		$this->oauthToken = $token;
		$this->oauthSecret = $secret;

		// Set token details on OAuth object
		$this->oauth->setToken($this->oauthToken, $this->oauthSecret);
	}

	/*
	 * Returns the OAuth token
	 */
	public function getOAuthToken()
	{
		return $this->oauthToken;
	}

	/*
	 * Returns the OAuth secret
	 */
	public function getOAuthSecret()
	{
		return $this->oauthSecret;
	}

	/*
	 * Initialize API URL's
	 */
	private function initUrls($use_https = true)
	{
		// Generate URL prefix, either HTTPS or HTTP
		$url_prefix = ($use_https ? 'https://' : 'http://');

		// Create the base API URL
		$this->baseApiUrl = $url_prefix . $this->apiHost . '/1/';

		// Create the Auth API URL
		$this->authUrl = $url_prefix . $this->authHost . '/oauth/authenticate'; //'/oauth/authorize';

		// Create the Request Token URL
		$this->requestTokenUrl = $url_prefix . $this->apiHost . '/oauth/request_token';

		// Create the Access Token URL
		$this->accessTokenUrl = $url_prefix . $this->apiHost . '/oauth/access_token';
	}

	/*
	 * Process an API response
	 *
	 * Response format is either XML or JSON
	 * If errors exist, return these; otherwise return the actual response
	 */
	public function parseResponse($response)
	{
		// Check for response format type
	        if ($this->responseFormat == 'xml')
		{
	            $response = (isset($response->errors)) ? $response->errors->apiError : simplexml_load_string($response);
		}
	        else if ($this->responseFormat == 'json')
		{
	            $response = (isset($response->errors)) ? $response->errors : json_decode($response);
		}

	        return $response;
	}

	/*
	 * Executes an API query using OAuth
	 */
	public function oauthFetch($path, $param, $method)
	{
		// Locate get form variables
		$v = strpos($path, '?');

		// If form variables exist, split the path
		if ($v)
		{
			$form_vars = substr($path, $v);
			$path = substr($path, 0, $v);
		}

		// Append the responseFormat to the path
		$path = $path . '.' . $this->responseFormat;

		// Re-append the form variables if they exist
		if (isset($form_vars))
		{
			$path = $path . $form_vars;
		}

		// Execute the request
		return $this->oauth->fetch($this->baseApiUrl . $path, $param, $method, $this->getHeaders());
	}

	/*
	 * Retrieve the HTML headers
	 */
	private function getHeaders()
	{
	        $headers = array();
	        $headers['User-Agent'] = $this->userAgent;
	        $headers['Accept-Language'] = 'en_US';

	        return $headers;
	}
}
?>
