<?php
namespace Fitbit\Commands;

use Fitbit\Client;
use Fitbit\Exception\FitBitException;

class Water extends AbstractCommand
{
	/*
	 * Retrieves water log entries for a user on a specific date
	 */
	public function getWater($date)
	{
                // Create a date string from the date
                $dateStr = $date->format('Y-m-d');
                $vars = array($this->client->getUserID(), $dateStr);

                return $this->retrieve('getWater', $vars);
	}

	/*
	 * Logs water consumption
	 */
	public function logWater($date, $amount, $waterUnit = null)
	{
		$waterUnits = array('ml', 'fl oz', 'cup');

		$param = array(
			'date'		=>	$date->format('Y-m-d'),
			'amount'	=>	$amount,
			'unit'		=>	(isset($waterUnit) && in_array($waterUnit, $waterUnits)) ? $waterUnit : null
		);

		return $this->post('logWater', $param);
	}

	/*
	 * Deletes a water consumption record
	 */
	public function deleteWater($waterID)
	{
		return $this->delete('deleteWater', $waterID);
	}
}
?>
