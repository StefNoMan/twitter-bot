<?php 

namespace Stefnoman\Twitterbot;

class App 
{
	const
		rootdir = __DIR__;

	private 
		$config = array(),
		$twitter;


	function __construct() 
	{
		$this->config = require_once('config.php');
		
		$this->loadDependencies();

		$this->twitter = new Twitter(
			$this->config['CONSUMER_KEY'],
			$this->config['CONSUMER_SECRET'],
			$this->config['ACCESS_TOKEN'],
			$this->config['ACCESS_TOKEN_SECRET']
		);
	}


	/**
	 * Loads App dependencies
	 */
	public function loadDependencies()
	{
		require_once('user.class.php');
		require_once('status.class.php');
		require_once('twitter.class.php');
		require_once('tools.class.php');
	}


	/**
	 * Core function of the App
	 */
	public function run()
	{
		ob_start();

		// $this->playConcours();
		$this->randomTweet();
		// $this->favoriteMyTweets();
		// $this->followToGetFollowBack();

		$content = ob_get_flush();
		$this->render($content);
	}


	/**
	 * Render HTML to the browser
	 */
	public function render( $content )
	{
		include( dirname(__DIR__) . '/views/header.html');
		echo $content;
		include( dirname(__DIR__) . '/views/footer.html');
	}



	/**
	 * Runs a bot task that RT + Follow concours tweets
	 */
	public function playConcours()
	{
		$response = $this->twitter->search(array(
			'q' => '#Concours',
			'count' => 30,
		));


		foreach( $response->statuses as $status )
		{
			// Tools::displayTweet($status);
			if ( ! $status->retweeted ) 
			{
				if ( Tools::isUserTrustable( $status->user ) )
				{
					if ( preg_match( '/follow/i', $status->text ) && preg_match( '/rt/i', $status->text ) )
					{
						Tools::displayTweet( $status );
						if ( !empty( $status->entities->user_mentions ) )
						{
							foreach ( $status->entities->user_mentions as $key => $value )
							{
								var_dump('follow: ', $value);
								$result = $this->twitter->follow( $value->id_str );
								if ( isset( $result['errors'] ) )
								{
									var_dump( $result['errors'] );
								}
							}
						}
					}
					var_dump('RT: ', $this->twitter->retweet($status->id_str) );
				}
			}
		}
	}


	public function randomTweet()
	{
		$f_contents = file( __DIR__ . "/quotes.txt"); 
		$random_message = $f_contents[rand(0, count($f_contents) - 1)];

		$smileys_possibles = array(
			'😁', '😍', '😉', '😇', '😜', '😋', '😚', '😝', '🤓', '😀', '😻', '💩'
		);

		$smiley_index = rand( 0, count( $smileys_possibles ) - 1 );

		$message = $random_message . ' ' . $smileys_possibles[$smiley_index];
		$this->twitter->tweet($message);
	}


	public function favoriteMyTweets()
	{
		# code...
	}


	/** Starts a Follow campaign **/
	public function followCampaign()
	{
		# code...
	}
}

