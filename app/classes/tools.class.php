<?php 

namespace Stefnoman\Twitterbot;

/**
* TOOLS
*/
class Tools
{

	public static function sanitize( $string, $type = 'text' )
	{
		return strip_tags( $string );
	}

}