<?php
namespace Fitbit\Commands;

use Fitbit\Client;
use Fitbit\Exception\FitBitException;

class Food extends AbstractCommand
{
	/*
	 * Returns food consumed by a user for a specific date
	 */
	public function getFoods($date)
	{
                // Create a date string from the date
		$dateStr = $date->format('Y-m-d');
		$vars = array($this->client->getUserID(), $dateStr);

		return $this->retrieve('getFood', $vars);
	}

	/*
	 * Logs consumption of food
	 */
	public function logFood($date, $foodID, $mealTypeID, $unitID, $amount, $foodName=null, $calories=null, $brandName=null, $nutrition=null)
	{
		$param = array(
			'date'		=>	$date->format('Y-m-d'),
			'foodName'	=>	isset($foodName) ? $foodName : '',
			'calories'	=>	isset($foodName) ? $calories : null,
			'brandName'	=>	isset($brandName) ? $brandName : '',
			'foodId'	=>	!isset($foodName) ? $foodID : null,
			'mealTypeId'	=>	$mealTypeID,
			'unitId'	=>	$unitID,
			'amount'	=>	$amount
		);

		// Add nutrition items to the parameter array
		if (isset($nutrition))
		{
			foreach ($nutrition as $key => $value)
			{
				$param[$key] = $nutrition[$value];
			}
		}

		return $this->post('logFood', $param);
	}

	/*
	 * Removes a consumed food
	 */
	public function deleteFood($foodID)
	{
		if (!isset($foodID))
		{
			throw new FitbitException('', 'No food specified');
		}
		else
		{
			return $this->delete('deleteFood', $foodID);
		}
	}

	/*
	 * Adds a food to the user's favorite list
	 */
	public function addFavoriteFood($foodID)
	{
                if (!isset($foodID))
                {
                        throw new FitbitException('', 'No food specified');
                }
                else
                {
                        return $this->post('addFavoriteFood', $foodID);
                }
	}

	/*
	 * Deletes a favorite food
	 */
	public function deleteFavoriteFood($foodID)
	{
                if (!isset($foodID))
                {
                        throw new FitbitException('', 'No food specified');
                }
                else
                {
                        return $this->delete('deleteFavoriteFood', $foodID);
                }
	}

	/*
	 * Search for foods in the food database
	 */
	public function searchFoods($query)
	{
                if (!isset($query))
                {
                        throw new FitbitException('', 'No food specified to search for');
                }
                else
                {
			return $this->retrieve('searchFoods', htmlentities($query));
                }
	}

	/*
	 * Get description of specific food
	 */
	public function getFood($foodID)
	{
                if (!isset($foodID))
                {
                        throw new FitbitException('', 'No food specified');
                }
                else
                {
                        return $this->delete('getFood', $foodID);
                }
	}

	/*
	 * Adds a food
	 */
	public function createFood($name, $defaultFoodMeasurementUnitId, $defaultServingSize, $calories, $description = null, $formType = null, $nutrition = null)
	{
		$param = array(
			'name'				=>	$name,
			'defaultFoodMeasurementUnitId'	=>	$defaultFoodMeasurementUnitId,
			'defaultServingSize'		=>	$defaultServingSize,
			'calories'			=>	$calories,
			'description'			=>	isset($description) ? $description : '',
			'formType'			=>	isset($formType) ? $formType : null
		);

                // Add nutrition items to the parameter array
                if (isset($nutrition))
                {
                        foreach ($nutrition as $key => $value)
                        {
                                $param[$key] = $nutrition[$value];
                        }
                }

		return $this->post('createFood', $param);
	}
}
?>
