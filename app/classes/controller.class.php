<?php 

// namespace Stefnoman\Twitterbot;

/**
* Core Controller
*/
 class Controller
 {

 	public 
 		$name,
 		$app;


	function __construct( $app )
	{
		$this->name = get_class( $this );
		$this->app = $app;
	}


 	public function defaultAction()
 	{
 		echo "<h1>Default Action</h1>";
 	}

	
	protected function render( $view = 'index', $vars = array() ) 
	{
		// View
		// $view = $controller;
		// $view_file = self::VIEWS_DIR . '/' . $view . '.html';

		// if ( file_exists( $view_file ) )
		// 	// echo $this->render( $view, $vars );
		// 	echo $this->app->render( $view );
		// else
		// 	throw new AppException("View (". $view_file .") not found", 1);
			
		$this->app->render( $view, $vars );
	}

 } 


 ?>