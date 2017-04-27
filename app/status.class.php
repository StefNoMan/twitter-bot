<?php 

namespace Stefnoman\Twitterbot;

/**
* STATUS (also called Tweet)
*/
class Status
{
	public 
		$created_at,
		$id,
		$id_str,
		$text,
		$truncated,
		$entities,
		$source,
		$in_reply_to_status_id,
		$in_reply_to_status_id_str,
		$in_reply_to_user_id,
		$in_reply_to_user_id_str,
		$in_reply_to_screen_name,
		$user,
		$geo,
		$coordinates,
		$place,
		$contributors,
		$retweeted_status,
		$is_quote_status,
		$retweet_count,
		$favorite_count,
		$favorited,
		$retweeted,
		$lang;
	

	function __construct()
	{
		$this->created_at = 'Thu Apr 27 21:22:51 +0000 2017';
		$this->id = 857706634616942593;
		$this->id_str ;
		$this->text = "RT @Mediaveille: #Concours @TEDxRennes C'est tout bientôt ! Remportez votre place avec @Mediaveille partenaire de l'événement le 6/05 https…";
		$this->truncated = false;
		$this->entities = array(
			$hashtags = array(),
			$symbols = array(),
			$user_mentions = array(),
			$urls = array(),
		);
		$this->source = '<a href="http://www.site-will-come.com" rel="nofollow">My personnal Tweet Organizer</a>';
		$this->in_reply_to_status_id = null;
		$this->in_reply_to_status_id_str = null;
		$this->in_reply_to_user_id = null;
		$this->in_reply_to_user_id_str = null;
		$this->in_reply_to_screen_name = null;
		$this->user = new User();
		$this->geo = null;
		$this->coordinates = null;
		$this->place = null;
		$this->contributors = null;
		$this->retweeted_status = new Status();
		$this->is_quote_status = false;
		$this->retweet_count = 4;
		$this->favorite_count = 0;
		$this->favorited = false;
		$this->retweeted = true;
		$this->lang = 'fr';
	}


	public function display()
	{
?>
		<div class="well">
			<h4><?= $this->user->name ?> (@<?= $this->user->screen_name ?>) <?php if ($this->user->verified): ?>verifié<?php endif ?> <?= $this->user->followers_count ?> followers / <?= $this->user->friends_count ?> following </h4>
			<p><?= $this->text ?></p>
			<p>RT: <?= $this->retweet_count ?> - Fav: <?= $this->favorite_count ?><?php if ($this->retweeted): ?>RT !<?php endif ?></p>
		</div>
<?php			
	}
}