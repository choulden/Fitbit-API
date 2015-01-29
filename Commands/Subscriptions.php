<?php
namespace Fitbit\Commands;

use Fitbit\Client;
use Fitbit\Exception\FitBitException;

class Subscriptions extends AbstractCommand
{
	public function addSubscription($id, $path=null, $subscriberID=null)
	{
		if (isset($subscriberID))
		{
			$this->client->addHeader(array('X-Fitbit-Subscriber-Id' => $subscriberID));
		}

		if (isset($path))
		{
			$path = '/'.$path;
		}
		else
		{
			$path = '';
		}

		$vars = array($path, $id);

		return $this->post('addSubscription', $vars);
	}

	public function deleteSubscription($id, $path=null)
	{
                if (isset($path))
                {
                        $path = '/'.$path;
                }
                else
                {
                        $path = '';
                }

		$vars = array($path, $id);

		return $this->post('deleteSubscription', $vars);
	}
}
?>
