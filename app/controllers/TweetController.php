<?php 

// namespace Stefnoman\Twitterbot;

/**
* Random Tweet
*/
class TweetController extends Controller
{
	/**
	 * Tweets a random quote random picked from a txt file
	 */
	public function randomTweet()
	{
		$file_content = file( __DIR__ . "/../quotes.txt" ); 
		$random_message = $file_content[rand(0, count($file_content) - 1)];

		$smileys_possibles = array(
			'😁', '😍', '😉', '😇', '😜', '😋', '😚', '😝', '🤓', '😀', '😻', '💩'
		);

		$smiley_index = rand( 0, count( $smileys_possibles ) - 1 );

		$message = $random_message . ' #CitationDuJour';

		$this->app->twitter->tweet( $message );

		// render view
		$this->render( 'tweet', array(
			'message' => $message,
			'controller' => $this->name,
		));
	}

}

 ?>