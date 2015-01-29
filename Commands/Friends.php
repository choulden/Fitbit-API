<?php
namespace Fitbit\Commands;

use Fitbit\Client;
use Fitbit\Exception\FitBitException;

class Friends extends AbstractCommand
{
	public function getFriends()
	{
		return $this->retrieve('getFriends', $this->client->getUserID());
	}

	public function getFriendsLeaderboard($period = '7d')
	{
		return $this->retrieve('getFriendsLeaderboard', $period);
	}

	public function inviteFriend($uID=null, $email=null)
	{
		if (!isset($uID) && !isset($email))
		{
			throw new FitbitException('', 'User ID or e-mail required to invite friend');
		}
		else
		{
			$param = array(
				'invitedUserId'		=>	isset($uID) ? $uID : null,
				'invitedUserEmail'	=>	isset($email) ? $email : null
			);

			return $this->post('inviteFriend', $param);
		}
	}

	public function acceptFriend($uID)
	{
		if (!isset($uID))
		{
			throw new FitbitException('', 'No userID specified');
		}
		else
		{
			$param = array('accept' => 'true');

			return $this->post('acceptFriend', $param, $uID);
		}
	}

	public function rejectFriend($uID)
	{
                if (!isset($uID))
                {
                        throw new FitbitException('', 'No userID specified');
                }
                else
                {
                        $param = array('accept' => 'false');

                        return $this->post('rejectFriend', $param, $uID);
                }
	}
}
?>
