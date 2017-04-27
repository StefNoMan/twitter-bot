<?php 

namespace Stefnoman\Twitterbot;

/**
* TOOLS
*/
class Tools
{

	public static function isUserTrustable( $user )
	{
		$trustable = true;

		if ( $user->verified ) {
			return true;
		}
		if ( $user->friends_count > 0 && ( (int)$user->followers_count / (int)$user->friends_count ) < 4 ) {
			$trustable = false;
		}
		if ( $user->followers_count < 3000 ) {
			$trustable = false;
		}
		return $trustable;
	}

}