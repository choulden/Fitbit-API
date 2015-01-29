<?php
namespace Fitbit\Commands;

use Fitbit\Client;
use Fitbit\Exception\FitBitException;

class Profile extends AbstractCommand
{
	public function getProfile()
	{
		return $this->retrieve('getProfile', $this->client->getUserID());
	}

	public function updateProfile($gender=null, $birthday=null, $height=null, $weight=null)
	{
		$param = array();

		if (isset($gender))
		{
			$param['gender'] = $gender;
		}

		if (isset($birthday))
		{
			$param['birthday'] = $birthday->format('Y-m-d');
		}

		if (isset($height))
		{
			$param['height'] = $height;
		}

		if (isset($weight))
		{
			$param['weight'] = $weight;
		}

		// Post to the API and return response
		return $this->post('updateProfile', null, $param);
	}
}
?>
