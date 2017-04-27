<?php 

namespace Stefnoman\Twitterbot;

/**
* Twitter Tools
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


	public static function displayTweet( $status )
	{
?>
	<div class="well">
		<h4><?= $status->user->name ?> (@<?= $status->user->screen_name ?>) <?php if ($status->user->verified): ?>verifié<?php endif ?> <?= $status->user->followers_count ?> followers / <?= $status->user->friends_count ?> following </h4>
		<p><?= $status->text ?></p>
		<p>RT: <?= $status->retweet_count ?> - Fav: <?= $status->favorite_count ?><?php if ($status->retweeted): ?>RT !<?php endif ?></p>
		
	</div>
<?php
	}
}