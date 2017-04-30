<?php 

	$actions = array(
		'randomTweet',
		'playConcours',
		'favoriteMyTweets',
		'followToGetFollowBack',
	);

	$index = rand( 0, count( $actions ) );

	echo "<h1>". $actions[$index] ." !</h1>";
	file_get_contents( 'http://twitterbot.dev/index.php?action=' . $actions[$index] );

 ?>