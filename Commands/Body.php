<?php
namespace Fitbit\Commands;

use Fitbit\Client;
use Fitbit\Exception\FitBitException;

class Body extends AbstractCommand
{
	/*
	 * Returns user body measurements
	 */
	public function getBody($date)
	{
                // Create a date string from the date
                $dateStr = $date->format('Y-m-d');
                $vars = array($this->client->getUserID(), $dateStr);

                return $this->retrieve('getBody', $vars);
	}

	/*
	 * Logs body measurement details
	 */
	public function logBody($date, $weight=null, $fat=null, $bicep=null, $calf=null, $chest=null, $forearm=null, $hips=null, $neck=null, $thigh=null, $waist=null)
	{
		$param = array(
			'date'		=>	$date->format('Y-m-d'),
			'weight'	=>	$weight,
			'fat'		=>	$fat,
			'bicep'		=>	$bicep,
			'calf'		=>	$calf,
			'chest'		=>	$chest,
			'forearm'	=>	$forearm,
			'hips'		=>	$hips,
			'neck'		=>	$neck,
			'thigh'		=>	$thigh,
			'waist'		=>	$waist
		);

		return $this->post('logBody', $param);
	}

	/*
	 * Records users weight at specific date
	 */
	public function logWeight($weight, $date=null)
	{
                if (!isset($weight))
                {
                        throw new FitbitException('', 'No weight specified');
                }
                else
                {
			$param = array(
				'weight'	=>	$weight,
				'date'		=>	isset($date) ? $date->format('Y-m-d') : null
			);

			return $this->post('logWeight', $param);
                }
	}

	/*
	 * Retrieves a users blood pressure recording
	 */
	public function getBloodPressure($date)
	{
                // Create a date string from the date
                $dateStr = $date->format('Y-m-d');
                $vars = array($this->client->getUserID(), $dateStr);

                return $this->retrieve('getBloodPressure', $vars);
	}

	/*
	 * Records a users blood pressure at a specified date
	 */
	public function logBloodPressure($date, $systolic, $diastolic, $time=null)
	{
		$param = array(
			'date'		=>	$date->format('Y-m-d'),
			'systolic'	=>	$systolic,
			'diastolic'	=>	$diastolic,
			'time'		=>	isset($time) ? $time->format('H:i') : null
		);

		return $this->post('logBloodPressure', $param);
	}

	/*
	 * Deletes a logged blood pressure entry
	 */
	public function deleteBloodPressure($bpID)
	{
                if (!isset($bpID))
                {
                        throw new FitbitException('', 'No blood pressure recording specified');
                }
                else
		{
			return $this->delete('deleteBloodPressure', $bpID);
		}
	}

	/*
	 * Retrieves a users glucose reading
	 */
	public function getGlucose($date)
	{
                // Create a date string from the date
                $dateStr = $date->format('Y-m-d');
                $vars = array($this->client->getUserID(), $dateStr);

                return $this->retrieve('getGlucose', $vars);
	}

	/*
	 * Records a users blood glucose and HbA1c readings
	 */
	public function logGlucose($date, $tracker, $glucose, $hba1c=null, $time=null)
	{
		$param = array(
			'date'		=>	$date->format('Y-m-d'),
			'tracker'	=>	$tracker,
			'glucose'	=>	$glucose,
			'hba1c'		=>	isset($hba1c) ? $hba1c : null,
			'time'		=>	isset($time) ? $time->format('H:i') : null
		);

		return $this->post('logGlucose', $param);
	}

	/*
	 * Retrieves a users heartrate reading
	 */
	public function getHeartRate($date)
	{
                // Create a date string from the date
                $dateStr = $date->format('Y-m-d');
                $vars = array($this->client->getUserID(), $dateStr);

                return $this->retrieve('getHeartRate', $vars);
	}

	/*
	 * Records a users heartrate reading
	 */
	public function logHeartRate($date, $tracker, $heartrate, $time=null)
	{
		$param = array(
			'date'		=>	$date->format('Y-m-d'),
			'tracker'	=>	$tracker,
			'heartrate'	=>	$heartrate,
			'time'		=>	isset($time) ? $time->format('H:i') : null
		);

		return $this->post('logHeartRate', $param);
	}

	/*
	 * Deletes a heartrate recording
	 */
	public function deleteHeartRate($hrID)
	{
                if (!isset($hrID))
                {
                        throw new FitbitException('', 'No heart rate recording specified');
                }
                else
                {
                        return $this->delete('deleteHeartRate', $hrID);
                }
	}
}
?>
