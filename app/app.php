<?php 

namespace Stefnoman\Twitterbot;

class App 
{
	const
		ROOT_DIR = __DIR__,
		MODELS_DIR = __DIR__ . '/models',
		VIEWS_DIR = __DIR__ . '/views',
		CONTROLLERS_DIR = __DIR__ . '/controllers',
		CLASSES_DIR = __DIR__ . '/classes';

	private 
		$config = array();

	public
		$twitter,
		$notifications = array();


	function __construct() 
	{
		$this->config = require_once( self::ROOT_DIR . '/config.php' );
		
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
		require_once( self::CLASSES_DIR . '/controller.class.php' );
		require_once( self::CLASSES_DIR . '/tools.class.php' );

		require_once( self::MODELS_DIR . '/user.class.php' );
		require_once( self::MODELS_DIR . '/status.class.php' );
		require_once( self::MODELS_DIR . '/twitter.class.php' );
	}


	/**
	 * Core function of the App
	 */
	public function run()
	{
		try {

			// Controller
			$controller = ( isset($_REQUEST['controller']) ) ? Tools::sanitize($_REQUEST['controller']) : 'default' ;
			$controller_name = ucfirst( strtolower( $controller ) ) . 'Controller';
			$controller_filepath = self::CONTROLLERS_DIR . '/' . $controller_name . '.php';

			if ( file_exists( $controller_filepath ) )
			{
				include_once( $controller_filepath );
				$controller = new $controller_name( $this );
				
				$action = ( isset( $_REQUEST['action'] ) ) ? Tools::sanitize($_REQUEST['action']) : 'defaultAction' ;
				if ( method_exists( $controller, $action ) )
					$controller->$action();
				else
					throw new AppException("Action (". $action .") not found", 1);
			}
			else 
			{
				throw new AppException("Controller (". $controller_name .") not found", 1);
			}
			
		} catch (AppException $e) {
			echo $e->getMessage();
		}
	}



	/**
	 * Render HTML to the browser
	 */
	public function render( $view = 'index', $vars = array() )
	{
		ob_start();

		include( self::VIEWS_DIR . '/header.html');
		include( self::VIEWS_DIR . '/' . $view . '.html');
		include( self::VIEWS_DIR . '/footer.html');

		$template = ob_get_clean();

		// templating engine
		$matches = array();
		if ( preg_match_all( '/{{(\w+)}}/', $template, $matches ) )
		{
			foreach ( $matches[0] as $key => $value ) {
				if ( isset( $matches[1][$key] ) ) {
					if ( isset( $vars[$matches[1][$key]] ) ) {
						$template = str_replace( $value, $vars[$matches[1][$key]], $template );
					}
					else
						throw new AppException("Unknown template variable : {{" . $matches[1][$key] . "}}", 1);
						
				}
			}
		}

		echo $template;
	}


}


class AppException extends \Exception
{

}