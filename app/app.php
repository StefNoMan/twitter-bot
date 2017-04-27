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
		require_once('twitter.class.php');
		require_once('twitter.tools.php');
	}


	/**
	 * Core function of the App
	 */
	public function run()
	{
		ob_start();

		$this->playConcours();
		// $this->randomTweet();
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
			Tools::displayTweet($status);
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
		$message_possibles = array(
			"Coucou les #twittos ! comment ça va aujourd'hui ??", 
			"Pff ... Trop marre des gens idiots", 
			"Qu'est ce qu'on mange ce midi ? :)", 
			"Salut les gens!", 
			"Petite #sondage: quelle est votre couleur préférée ? moi c'est le violet hihi :)", 
			"C'est fou ce truc !! --> ╲⎝⧹", 
			"l'#humour résume si bien la réalité.. Tout y est pour tout comprendre !!!! ",
			"J'aime bien quand les histoires finissent bien #bonheur",
		);
		$smileys_possibles = array(
			'😁', '😍', '😉', '😇', '😜', '😋', '😚', '😝', '🤓', '😀', '😻', '💩'
		);

		$msg_index = rand( 0, count( $message_possibles ) - 1 );
		$smiley_index = rand( 0, count( $smileys_possibles ) - 1 );

		$message = $message_possibles[$msg_index] . ' ' . $smileys_possibles[$smiley_index];
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

