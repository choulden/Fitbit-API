# Fitbit-API

Include the 'autoload.php' in your project. All inclusions of files and classes are taken care of in the loader.

Create a new instance of the Client
  $fitbit = new Fitbit\Client('key', 'secret');

Create a new session, with your callback URL
  $fitbit->startSession('http://xyz.com');

Create the desired command handler
  $sleep = new Fitbit\Commands\Sleep($fitbit);

Execute a command
  $d = new DateTime('NOW');
  $result = $sleep->getSleep($d);
