<?php
namespace Fitbit\Commands;

class CommandHandler
{
	/*
	 * Class - { URL, ResponseCode, DataExpected }
	 */
	protected static $commands = array(
		/* Profile */
		'getProfile' => array(
			'url'	=>	'user/%s/profile',
			'code'	=>	'200',
			'return'=>	true
		),
		'updateProfile' => array(
			'url'	=>	'user/-/profile',
			'code'	=>	'201',
                        'return'=>      true
		),

		/* Activity */
		'getActivities' => array(
			'url'	=>	'user/%s/activities/date/%s',
			'code'	=>	'200',
                        'return'=>      true
		),
		'getRecentActivities' => array(
			'url'	=>	'user/-/activities/recent',
			'code'	=>	'200',
                        'return'=>      true
		),
		'getFrequentActivities' => array(
			'url'	=>	'user/-/activities/frequent',
			'code'	=>	'200',
                        'return'=>      true
		),
		'getFavoriteActivities' => array(
			'url'	=>	'user/-/activities/favorite',
			'code'	=>	'200',
                        'return'=>      true
		),
		'logActivity' => array(
			'url'	=>	'user/-/activities',
			'code'	=>	'201',
                        'return'=>      true
		),
		'deleteActivity' => array(
			'url'	=>	'user/-/activities/%s',
			'code'	=>	'204',
                        'return'=>      false
		),
		'addFavoriteActivity' => array(
			'url'	=>	'user/-/activities/log/favorite/%s',
			'code'	=>	'201',
                        'return'=>      false
		),
		'deleteFavoriteActivity' => array(
			'url'	=>	'user/-/activities/log/favorite/%s',
			'code'	=>	'204',
                        'return'=>      false
		),
		'getActivity' => array(
			'url'	=>	'activities/%s',
			'code'	=>	'200',
                        'return'=>      true
		),
		'browseActivities' => array(
			'url'	=>	'activities',
			'code'	=>	'200',
                        'return'=>      true
		),
		'getActivityStats' => array(
			'url'	=>	'user/%s/activities',
			'code'	=>	'200',
			'return'=>	true
		),

		/* Food */
		'getFoods' => array(
			'url'	=>	'user/%s/foods/log/date/%s',
			'code'	=>	'200',
                        'return'=>      true
		),
		'getRecentFoods' => array(
			'url'	=>	'user/-/foods/log/recent',
			'code'	=>	'200',
                        'return'=>      true
		),
		'getFrequentFoods' => array(
			'url'	=>	'user/-/foods/log/frequent',
			'code'	=>	'200',
                        'return'=>      true
		),
		'getFavoriteFoods' => array(
			'url'	=>	'user/-/foods/log/favorite',
			'code'	=>	'200',
                        'return'=>      true
		),
		'logFood' => array(
			'url'	=>	'user/-/foods/log',
			'code'	=>	'201',
                        'return'=>      true
		),
		'deleteFood' => array(
			'url'	=>	'user/-/foods/log/%s',
			'code'	=>	'204',
                        'return'=>      false
		),
		'addFavoriteFood' => array(
			'url'	=>	'user/-/foods/log/favorite/%s',
			'code'	=>	'201',
                        'return'=>      false
		),
		'deleteFavoriteFood' => array(
			'url'	=>	'user/-/foods/log/favorite/%s',
			'code'	=>	'204',
			'return'=>	false,
		),
		'getMeals' => array(
			'url'	=>	'user/-/meals',
			'code'	=>	'200',
			'return'=>	true
		),
		'getFoodUnits' => array(
			'url'	=>	'foods/units',
			'code'	=>	'200',
			'return'=>	true
		),
		'searchFoods' => array(
			'url'	=>	'foods/search?query=%s',
			'code'	=>	'200',
			'return'=>	true
		),
		'getFood' => array(
			'url'	=>	'foods/%s',
			'code'	=>	'200',
			'return'=>	true
		),
		'createFood' => array(
			'url'	=>	'foods',
			'code'	=>	'201',
			'return'=>	true
		),

		/* Water */
		'getWater' => array(
			'url'	=>	'user/-/foods/log/water/date/%s',
			'code'	=>	'200',
			'return'=>	true
		),
		'logWater' => array(
			'url'	=>	'user/-/foods/log/water',
			'code'	=>	'201',
			'return'=>	true
		),
		'deleteWater' => array(
			'url'	=>	'user/-/foods/log/water/%s',
			'code'	=>	'204',
			'return'=>	false
		),

		/* Sleep */
		'getSleep' => array(
			'url'	=>	'user/%s/sleep/date/%s',
			'code'	=>	'200',
			'return'=>	true
		),
		'logSleep' => array(
			'url'	=>	'user/-/sleep',
			'code'	=>	'201',
			'return'=>	true
		),
		'deleteSleep' => array(
			'url'	=>	'user/-/sleep/%s',
			'code'	=>	'204',
			'return'=>	false
		),

		/* Body */
		'getBody' => array(
			'url'	=>	'user/%s/body/date/%s',
			'code'	=>	'200',
			'return'=>	true
		),
		'logBody' => array(
			'url'	=>	'user/-/body',
			'code'	=>	'201',
			'return'=>	true
		),
		'logWeight' => array(
			'url'	=>	'user/-/body/weight',
			'code'	=>	'201',
			'return'=>	false
		),
		'getBloodPressure' => array(
			'url'	=>	'user/-/bp/date/%s',
			'code'	=>	'200',
			'return'=>	true
		),
		'logBloodPressure' => array(
			'url'	=>	'user/-/bp',
			'code'	=>	'201',
			'return'=>	true
		),
		'deleteBloodPressure' => array(
			'url'	=>	'user/-/bp/%s',
			'code'	=>	'204',
			'return'=>	false
		),
		'getGlucose' => array(
			'url'	=>	'user/-/glucose/date/%s',
			'code'	=>	'200',
			'return'=>	true
		),
		'logGlucose' => array(
			'url'	=>	'user/-/glucose',
			'code'	=>	'201',
			'return'=>	true
		),
		'getHeartRate' => array(
			'url'	=>	'user/-/heart/date/%s',
			'code'	=>	'200',
			'return'=>	true
		),
		'logHeartRate' => array(
			'url'	=>	'user/-/heart',
			'code'	=>	'201',
			'return'=>	true
		),
		'deleteHeartRate' => array(
			'url'	=>	'user/-/heart/%s',
			'code'	=>	'204',
			'return'=>	false
		),

		/* Devices */
		'getDevices' => array(
			'url'	=>	'user/-/devices',
			'code'	=>	'200',
			'return'=>	true
		),

		/* Friends */
		'getFriends' => array(
			'url'	=>	'user/%s/friends',
			'code'	=>	'200',
			'return'=>	true
		),
		'getFriendsLeaderboard' => array(
			'url'	=>	'user/-/friends/leaders/%s',
			'code'	=>	'200',
			'return'=>	true
		),
		'inviteFriends' => array(
			'url'	=>	'user/-/friends/invitations',
			'code'	=>	'201',
			'return'=>	false
		),
		'acceptFriend' => array(
			'url'	=>	'user/-/friends/invitations/%s',
			'code'	=>	'204',
			'return'=>	false
		),
		'rejectFriend' => array(
			'url'	=>	'user/-/friends/invitations/%s',
			'code'	=>	'204',
			'return'=>	false
		),

		/* Subscriptions */
		'addSubscription' => array(
			'url'	=>	'user/-%s/apiSubscriptions/%s',
			'code'	=>	'200|201',
			'return'=>	true
		),
		'deleteSubscription' => array(
			'url'	=>	'user/-%s/apiSubscriptions/%s',
			'code'	=>	'204',
			'return'=>	false
		),
		'getSubscriptions' => array(
			'url'	=>	'user/-/apiSubscriptions',
			'code'	=>	'200',
			'return'=>	true
		)
	);

	/*
	 * Retrieve details of a given command
	 */
	private function getCommand($command, $field=null)
	{
		// Loop through the Commands array
		foreach (self::$commands as $Command => $Field)
		{
			// Check if the requested command has a match in the array
			if ($Command == $command)
			{
				// If a specific field is required, find it, otherwise return the array
				if (isset($field))
				{
					// Determine if the field exists, by using 'isset' against it
					if (isset($Field[$field]))
					{
						// Return the field
						return $Field[$field];
					}
				}
				else
				{
					return $Field;
				}
			}
		}

		// Error, default return
		return null;
	}

	/*
	 * Retrieve detailed array for the command
	 */
	public static function getCommandDetail($command)
	{
		return self::getCommand($command, null);
	}

	/*
	 * Retrieve only the URL for the command
	 */
	public static function getCommandURL($command)
	{
		return self::getCommand($command, "url");
	}

	/*
	 * Retrieve only the expected HTTP response code for the command
	 */
	public static function getCommandCode($command)
	{
		return self::getCommand($command, "code");
	}
}
?>
