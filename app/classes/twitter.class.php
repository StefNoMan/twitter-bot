<?php 

namespace Stefnoman\Twitterbot;

use \Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Twitter Class
 */
 class Twitter extends TwitterOAuth
 {
 	
	function __construct($c_key, $c_secret, $acc_token, $acc_token_secret)
 	{
 		parent::__construct( $c_key, $c_secret, $acc_token, $acc_token_secret );

 		// 	$this->setProxy([
		//     'CURLOPT_PROXY' => '127.0.0.0',
		//     'CURLOPT_PROXYUSERPWD' => '',
		//     'CURLOPT_PROXYPORT' => 8080,
		// ]);
 	}

	public function search($args = array())
	{
		// Defaults search values
		$theSearch = array_merge([

			// search query
			'q' => '#ff',
			
			// language
			'lang' => 'fr',

			// number of tweets to retreive
			'count' => 1,

		], $args);

		return $this->get( 'search/tweets', $theSearch );
	}


	public function tweet( $message )
	{
		return $this->post('statuses/update', [
			'status' => $message,
			// 'in_reply_to_status_id' => 'xxx',
			// 'possibly_sensitive' => false,
			// 'lat' => 'xxx',
			// 'long' => 'xxx',
			// 'place_id' => 'xxx',
			// 'display_coordinates' => 'xxx',
			// 'trim_user' => true,
			// 'media_ids' => 'xxx,xxx,xxx',
		]);
	}


	public function retweet( $twweet_id )
	{
		return $this->post('statuses/retweet', [
			'id' => $twweet_id,
		]);
	}


	public function unretweet( $twweet_id )
	{
		return $this->post('statuses/unretweet', [
			'id' => $twweet_id,
		]);
	}

	public function favorite( $twweet_id )
	{
		return $this->post('favorites/create', [
			'id' => $twweet_id,
		]);
	}


	public function reply( $twweet_id, $message )
	{
		// to do..
	}


	public function follow( $user_id )
	{
		$params['follow'] = false;

		if ( is_numeric( $user_id ) )
			$params['user_id'] = $user_id;
		elseif ( is_string( $user_id ) )
			$params['screen_name'] = $user_id;

		var_dump($params);
		return $this->post('friendships/create', $params);
	}


	public function unfollow( $user_id )
	{
		return $this->post('friendships/destroy', [
			'user_id' => $user_id,
			// 'screen_name' => $user_id,
			// 'follow' => false,
		]);
	}


	public function getUserInfo( $user_id )
	{
		return $this->get('users/show', [
			'user_id' => $user_id,
			// 'screen_name' => $screen_name,
			// 'follow' => false,
		]);
	}



	public function getTrends()
	{
		return $this->get('trends/available');
	}
 
 }