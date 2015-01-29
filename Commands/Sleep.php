<?php
namespace Fitbit\Commands;

use Fitbit\Client;
use Fitbit\Exception\FitBitException;

class Sleep extends AbstractCommand
{
	/*
	 * Retrieves sleep log entries
	 */
	public function getSleep($date)
	{
                // Create a date string from the date
                $dateStr = $date->format('Y-m-d');
                $vars = array($this->client->getUserID(), $dateStr);

                return $this->retrieve('getSleep', $vars);
	}

	/*
	 * Logs a sleep entry
	 */
	public function logSleep($date, $duration)
	{
		$param = array(
			'date'		=>	$date->format('Y-m-d'),
			'startTime'	=>	$date->format('H:i'),
			'duration'	=>	$duration
		);

		return $this->post('logSleep', $param);
	}

	/*
	 * Removes a sleep entry
	 */
	public function deleteSleep($sleepID)
	{
                if (!isset($foodID))
                {
                        throw new FitbitException('', 'No sleep session specified');
                }
                else
                {
                        return $this->delete('deleteSleep', $sleepID);
                }
	}
}
?>
