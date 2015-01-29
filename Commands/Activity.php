<?php
namespace Fitbit\Commands;

use Fitbit\Client;
use Fitbit\Exception\FitBitException;

class Activity extends AbstractCommand
{
	/*
	 * Get activities for specified date
	 */
	public function getActivities($date)
	{
		if (!isset($date))
		{
			throw new FitbitException('', 'No date specified');
		}
		else
		{
			// Create a date string from the date
			$dateStr = $date->format('Y-m-d');
			$vars = array($this->client->getUserID(), $dateStr);

			return $this->retrieve('getActivities', $vars);
		}
	}

	/*
	 * Log an activity
	 */
	public function logActivity($date, $activityID, $duration, $calories=null, $distance=null, $distanceUnit=null, $activityName=null)
	{
		$distanceUnits = array('Centimeter', 'Foot', 'Inch', 'Kilometer', 'Meter', 'Mile', 'Millimeter', 'Steps', 'Yards');

		$param = array(
			'date'		=>	$date->format('Y-m-d'),
			'startTime'	=>	$date->format('H:i'),
			'activityName'	=>	isset($activityName) ? $activityName : '',
			'manualCalories'=>	isset($activityName) ? $calories : isset($calories ? $calories : null),
			'activityID'	=>	!isset($activityName) ? $activityId : '',
			'durationMillis'=>	$duration,
			'distance'	=>	isset($distance) ? $distance : null,
			'distanceUnit'	=>	(isset($distanceUnit) && in_array($distanceUnit, $distanceUnits)) ? $distanceUnit : null,
		);

		return $this->post('logActivity', null, $param);
	}

	/*
	 * Delete an activity
	 */
	public function deleteActivity($activityID)
	{
		if (!isset($activityID))
		{
			throw new FitbitException('', 'No activity ID specified');
		}
		else
		{
			return $this->delete('deleteActivity', $activityID);
		}
	}

	/*
	 * Add a favorite activity
	 */
	public function addFavoriteActivity($activityID)
	{
                if (!isset($activityID))
                {
                        throw new FitbitException('', 'No activity ID specified');
                }
                else
                {
                        return $this->post('addFavoriteActivity', $activityID);
                }
	}

	/*
	 * Delete a favorite activity
	 */
	public function deleteFavoriteActivity($activityID)
	{
                if (!isset($activityID))
                {
                        throw new FitbitException('', 'No activity ID specified');
                }
                else
                {
                        return $this->delete('deleteFavoriteActivity', $activityID);
                }
	}

	/*
	 * Returns the full activity description
	 */
	public function getActivity($activityID)
	{
                if (!isset($activityID))
                {
                        throw new FitbitException('', 'No activity ID specified');
                }
                else
                {
                        return $this->retrieve('getActivity', $activityID);
                }
	}

	/*
	 * Gets activity statistics
	 */
	public function getActivityStats()
	{
		return $this->retrieve('getActivityStats', $this->client->getUserID());
	}
}
?>
