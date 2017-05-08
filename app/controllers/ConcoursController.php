<?php 

namespace Stefnoman\Twitterbot;

/**
* Play Concours
*/
class ConcoursController extends Controller
{

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



}


 ?>