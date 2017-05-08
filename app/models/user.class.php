<?php 

namespace Stefnoman\Twitterbot;

/**
* USER
*/
class User
{
	private
		$contributors_enabled,
		$created_at,
		$default_profile,
		$default_profile_image,
		$description,
		$entities,
		$favourites_count,
		$follow_request_sent,
		$following,
		$followers_count,
		$friends_count,
		$geo_enabled,
		$id,
		$id_str,
		$is_translator,
		$lang,
		$listed_count,
		$location,
		$name,
		$notifications,
		$profile_background_color,
		$profile_background_image_url,
		$profile_background_image_url_https,
		$profile_background_tile,
		$profile_banner_url,
		$profile_image_url,
		$profile_image_url_https,
		$profile_link_color,
		$profile_sidebar_border_color,
		$profile_sidebar_fill_color,
		$profile_text_color,
		$profile_use_background_image,
		$protected,
		$screen_name,
		$status,
		$statuses_count,
		$time_zone,
		$url,
		$utc_offset,
		$verified,
		$withheld_in_countries,
		$withheld_scope;

	
	function __construct( $data )
	{
		$array = json_decode( $data );
		foreach ( $array as $key => $value ) {
			$this->$key = $value;
		}
	}


	public function __toString()
	{
		$html = '
			<div>
				<h3>{$this->name} ';
		if ( $this->verified ) {
			$html .= ' <span class="verified">V</span>';
		}
		$html .= '<span>@{$this->screen_name}</span>
				</h3>
				<div>{$this->description}</div>
				<div>
					FOLLOWERS <span class="followers">{$this->followers}</span>
					FOLLOWING <span class="following">{$this->friends}</span>
				</div>
			</div>
		';
	}


	public function isTrustable()
	{
		$trustable = true;

		if ( $this->verified ) {
			return true;
		}
		if ( $this->friends_count > 0 && ( (int)$this->followers_count / (int)$this->friends_count ) < 4 ) {
			$trustable = false;
		}
		if ( $this->followers_count < 3000 ) {
			$trustable = false;
		}
		return $trustable;
	}

}