<?php
$map = array(
        'Fitbit\Exception\FitbitException'      =>      __DIR__ . '/Fitbit/Exception/FitbitException.php',
	'Fitbit\Response'			=>	__DIR__ . '/Fitbit/Response.php',
	'Fitbit\RateLimit'			=>	__DIR__ . '/Fitbit/RateLimit.php',
        'Fitbit\Client'                         =>      __DIR__ . '/Fitbit/Client.php',
	'Fitbit\Commands\CommandHandler'	=>	__DIR__ . '/Fitbit/Commands/CommandHandler.php',
        'Fitbit\Commands\AbstractCommand'       =>      __DIR__ . '/Fitbit/Commands/AbstractCommand.php',
        'Fitbit\Commands\Activity'              =>      __DIR__ . '/Fitbit/Commands/Activity.php',
        'Fitbit\Commands\Body'                  =>      __DIR__ . '/Fitbit/Commands/Body.php',
        'Fitbit\Commands\Devices'               =>      __DIR__ . '/Fitbit/Commands/Devices.php',
        'Fitbit\Commands\Food'                  =>      __DIR__ . '/Fitbit/Commands/Food.php',
        'Fitbit\Commands\Friends'               =>      __DIR__ . '/Fitbit/Commands/Friends.php',
        'Fitbit\Commands\Profile'               =>      __DIR__ . '/Fitbit/Commands/Profile.php',
        'Fitbit\Commands\Sleep'                 =>      __DIR__ . '/Fitbit/Commands/Sleep.php',
        'Fitbit\Commands\Subscriptions'         =>      __DIR__ . '/Fitbit/Commands/Subscriptions.php',
        'Fitbit\Commands\Water'                 =>      __DIR__ . '/Fitbit/Commands/Water.php',
);

spl_autoload_register(function ($class) use ($map) {
	if (isset($map[$class]))
	{
		require $map[$class];
	}
}, true);
?>
