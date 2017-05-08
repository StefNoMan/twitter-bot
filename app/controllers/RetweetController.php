<?php 

// namespace Stefnoman\Twitterbot;

/**
* Retweet User
*/
class RetweetController extends Controller
{

	/**
	 * Retweet All tweet from a user
	 */
	public function retweetUser()
	{
		$vars = array();

		if ( isset( $_REQUEST['screen_name'] ) ) {
				
			$response = $this->app->twitter->getUserTimeline(array(
				'screen_name' => $_REQUEST['screen_name'],
			));

			$vars['user'] = $_REQUEST['screen_name'];
			$vars['tweet_count'] = count( $response );

			foreach ($response as $index => $status) {
				if ( !$status->retweeted ) {
					$this->app->twitter->retweet( $status->id_str );
				}
			}
		}
		
		// render view
		$this->render( 'retweet', $vars );
	}

}

?>