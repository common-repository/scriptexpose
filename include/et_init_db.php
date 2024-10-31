<?php


namespace SPEX\inc\activation ;


//activation_plugin create new table is not exist , to manage data 
// for testing and  using the project .


class activation_plugin{


	public $tab_css_name = 'present' ;
	
	public function __construct(){
		
		$enable = get_option('catalog_active') ;
		
		if( $enable  === 'active' ){

			$css_init = $this->make_example_css();
			update_option( 'current_style' , $css_init , 'yes' );

		}else if( $enable  === 'off'){
			$this->make_option();
			update_option( 'catalog_active' , 'active', '' , 'yes' );

		}else{

			//do register option   
			$this->make_option();
			//do database for css style 
			$this->load_db_forge();
			//do example module 
			$this->make_example_module();
			//set register option of init 
			$css_init = $this->make_example_css();
			update_option( 'current_style' , $css_init , 'yes' );
			update_option( 'catalog_active' , 'active', '' , 'yes' );
		}
		

	}
			
	//records option table 
	public function make_option(){

		add_option( 'current_style' , '', '' , 'yes' ); //record for the table style with which you are working
		add_option( 'catalog_active' , '', '' , 'yes' );
		add_option( 'catalog_load' , '', '' , 'yes' );
		//temp option use to test callback jequery data in et_register_script 
		//add_option( 'temp_array' , '', '' , 'yes' ); 
		
	}

		//records database for script_expose 

	public  function load_db_forge(){
		
	global $wpdb;

	$table_name = $wpdb->prefix . 'theme_module';

	    $this_table = "CREATE TABLE $table_name (
		id int(10) NOT NULL AUTO_INCREMENT,
		url text DEFAULT NULL,
		text_area_a text DEFAULT NULL,
		text_area_b text DEFAULT NULL,
		text_area_d text DEFAULT NULL,
		text_area_c text DEFAULT NULL,
		theme_module text DEFAULT NULL,
		shortcode  text DEFAULT NULL, 
		style_table  text DEFAULT NULL, 
		UNIQUE KEY id (id)
	    );";

		$table_name = $wpdb->prefix . 'theme_module_css';

	    $this_table_b = "CREATE TABLE $table_name (
		id int(10) NOT NULL AUTO_INCREMENT,
		style_table text DEFAULT NULL ,
		css_script_a longtext DEFAULT NULL,
		css_script_b longtext DEFAULT NULL,
		css_script_c longtext DEFAULT NULL,
		css_script_d longtext DEFAULT NULL,
		css_script_e longtext DEFAULT NULL,
		css_script_f longtext DEFAULT NULL,
		UNIQUE KEY id ( id ) 
	    );";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	    dbDelta(  $this_table_b );
	    dbDelta(  $this_table );
				    

	}



	/*
	*
	* @return string name table_css  
	*/
	//creates an example of the css and content
	public function make_example_module(){

		global $wpdb;
		$this->tab_css_name = 'present' ;
		$css_name_ = 'presentation' ;
		$css_name_s = 'Simple' ;
		$tab_css_name_s = 'Simple' ;
		$image_path =  plugins_url() . '/' .  STE_ABS  . '/image' ; 
		$_image_one = $image_path . '/flower.jpg' ;
		$_image_two = $image_path . '/Spiral.png' ;


		//check if DB init data has just saved 
		if( ! $wpdb->update( $wpdb->prefix . 'theme_module' , array( 'text_area_a' => 'text description', 'url' => $_image_one , 'text_area_b' => $this->tab_css_name  , 
						'text_area_d' => '1250.5'  , 'text_area_c' => '1000' ,'theme_module' => $this->tab_css_name , 'shortcode' => $this->tab_css_name , 'style_table'=> $css_name_ ) , array( 'text_area_a' => 'text description' ) , array( 
						'%s', '%s' , '%s', '%s', '%s',  '%s' , '%s' , '%s' )  )){

		$wpdb->replace(  $wpdb->prefix . 'theme_module' , array( 'text_area_a' => 'text description',  'url' => $_image_one , 'text_area_b' => $this->tab_css_name  , 
									'text_area_d' => '1250.5'  , 'text_area_c' => '1000' ,'theme_module' => $this->tab_css_name , 'shortcode' => $this->tab_css_name , 'style_table'=> $css_name_ ) , array( 
									'%s', '%s' , '%s', '%s', '%s',  '%s' , '%s' , '%s' )  );
		}


		if( ! $wpdb->update( $wpdb->prefix . 'theme_module' , array( 'text_area_a' => 'Golden rectangle' ,  'url' => $_image_two , 'text_area_b' => 'algebraic calculation'  , 
						'text_area_d' => 'formula '  , 'text_area_c' => 'Area' ,'theme_module' => $tab_css_name_s , 'shortcode' => $tab_css_name_s , 'style_table'=> $css_name_s ), array( 'text_area_a' => 'Golden rectangle' ) , array( 
						'%s', '%s' , '%s', '%s', '%s',  '%s' , '%s' , '%s' )  ) ){

		$wpdb->replace($wpdb->prefix . 'theme_module' , array( 'text_area_a' => 'Golden rectangle', 'url' => $_image_two , 'text_area_b' => 'algebraic calculation'  , 
									'text_area_d' => 'formula '  , 'text_area_c' => 'Area' ,'theme_module' => $tab_css_name_s , 'shortcode' => $tab_css_name_s , 'style_table'=> $css_name_s ),  array( 
									'%s', '%s' , '%s', '%s', '%s',  '%s' , '%s' , '%s' )  );

		}



	}


	public function testclass(){

	echo "ciao db" ;
	}



	public function make_example_css(){

	global $wpdb;
	$css_name_ = 'presentation' ;
	$image_path =  plugins_url() . '/' .  STE_ABS  . '/image' ; 
	$_image_tree = $image_path . '/formula.png' ;
	$_image_tree = trim($_image_tree , " " );
	$_image_tree = "url(" . $_image_tree . ")" ;
	$length_tree = strlen($_image_tree) ;


	$_css_init_example =

	array( 'table_work' => array(
		
	 'style_table' => 'Simple',

	 'css_script_a' => 'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"18";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:37:"rgba(30,152,171,0.017483234405517578)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"15";s:5:"color";s:7:"#4d19e8";s:6:"height";s:3:"238";s:5:"width";s:3:"402";s:4:"left";s:2:"-1";s:3:"top";s:2:"88";s:13:"border-radius";s:2:"22";s:12:"border-width";s:1:"3";s:12:"border-color";s:7:"#ee3030";s:17:"background-origin";s:7:"inherit";s:15:"background-size";s:7:"initial";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"dashed";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:10:"border-box";}',  'css_script_b' => 'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"14";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:35:"rgba(24,186,165,0.2752821445465088)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"20";s:5:"color";s:7:"#b826d9";s:6:"height";s:2:"52";s:5:"width";s:3:"189";s:4:"left";s:3:"211";s:3:"top";s:3:"364";s:13:"border-radius";s:2:"15";s:12:"border-width";s:1:"2";s:12:"border-color";s:7:"#bbae52";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"dashed";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:11:"content-box";}', 
	 'css_script_c' =>	'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"14";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:36:"rgba(191,251,232,0.7596571445465088)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"15";s:5:"color";s:7:"#1d30df";s:6:"height";s:2:"35";s:5:"width";s:3:"192";s:4:"left";s:1:"7";s:3:"top";s:2:"17";s:13:"border-radius";s:2:"15";s:12:"border-width";s:1:"3";s:12:"border-color";s:7:"#7e397e";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"dashed";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:11:"content-box";}','css_script_d' => 'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"14";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:35:"rgba(229,32,139,0.2635633945465088)";s:16:"background-image";s:1:" ";s:9:"font-size";s:2:"15";s:5:"color";s:7:"#1d30df";s:6:"height";s:2:"50";s:5:"width";s:3:"190";s:4:"left";s:1:"6";s:3:"top";s:3:"364";s:13:"border-radius";s:2:"15";s:12:"border-width";s:1:"2";s:12:"border-color";s:7:"#6752ed";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"dashed";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:11:"content-box";}' ,'css_script_e' =>	'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"14";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:35:"rgba(232,29,169,0.2987332344055176)";s:16:"background-image";s:'. $length_tree .':"' . $_image_tree .'";s:9:"font-size";s:2:"16";s:5:"color";s:7:"#4d19e8";s:6:"height";s:2:"35";s:5:"width";s:3:"175";s:4:"left";s:3:"224";s:3:"top";s:2:"18";s:13:"border-radius";s:2:"15";s:12:"border-width";s:1:"3";s:12:"border-color";s:7:"#e81bd4";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:7:"contain";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"dashed";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:11:"content-box";}',
	 'css_script_f' => 'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"18";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:33:"rgba(229,233,253,0.9158935546875)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"15";s:5:"color";s:7:"#000000";s:6:"height";s:3:"459";s:5:"width";s:3:"432";s:4:"left";s:2:"-4";s:3:"top";s:2:"-1";s:13:"border-radius";s:2:"44";s:12:"border-width";s:1:"4";s:12:"border-color";s:7:"#5c1ce1";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:7:"initial";s:10:"text-align";s:5:"start";s:12:"border-style";s:6:"dotted";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:11:"content-box";}',),
		

		array( 'style_table' => 'presentation',

		 'css_script_a' => 'a:24:{s:11:"padding-top";s:1:"0";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:5:"color";s:7:"#e1c334";s:16:"background-color";s:19:"rgba(172,146,234,1)";s:12:"table-layout";s:2:"10";s:7:"opacity";s:1:"1";s:5:"width";s:3:"442";s:6:"height";s:3:"344";s:4:"left";s:2:"-2";s:3:"top";s:1:"3";s:9:"font-size";s:2:"10";s:6:"margin";s:2:"10";s:13:"border-radius";s:2:"20";s:12:"border-color";s:7:"#e14634";s:12:"border-width";s:1:"7";s:8:"overflow";s:4:"auto";s:16:"background-image";s:1:"0";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:5:"right";s:12:"border-style";s:6:"dashed";s:14:"vertical-align";s:6:"middle";}',
		  'css_script_b' => 'a:24:{s:11:"padding-top";s:1:"6";s:12:"padding-left";s:2:"20";s:13:"padding-right";s:2:"35";s:14:"padding-bottom";s:1:"0";s:5:"color";s:7:"#f0edf4";s:16:"background-color";s:19:"rgba(164,129,237,1)";s:12:"table-layout";s:3:"tad";s:7:"opacity";s:1:"1";s:5:"width";s:3:"189";s:6:"height";s:3:"102";s:4:"left";s:1:"9";s:3:"top";s:2:"15";s:9:"font-size";s:2:"20";s:6:"margin";s:1:"8";s:13:"border-radius";s:2:"20";s:12:"border-color";s:7:"#433957";s:12:"border-width";s:1:"7";s:8:"overflow";s:4:"auto";s:16:"background-image";s:1:"0";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:7:"initial";s:10:"text-align";s:4:"left";s:12:"border-style";s:4:"none";s:14:"vertical-align";s:3:"sub";}' 
		  ,'css_script_c' => 'a:24:{s:11:"padding-top";s:2:"21";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:5:"color";s:1:"0";s:16:"background-color";s:18:"rgba(20,141,102,1)";s:12:"table-layout";s:2:"10";s:7:"opacity";s:1:"1";s:5:"width";s:3:"400";s:6:"height";s:2:"55";s:4:"left";s:2:"20";s:3:"top";s:3:"365";s:9:"font-size";s:2:"25";s:6:"margin";s:2:"10";s:13:"border-radius";s:2:"20";s:12:"border-color";s:1:"0";s:12:"border-width";s:1:"7";s:8:"overflow";s:4:"auto";s:16:"background-image";s:1:"0";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"dashed";s:14:"vertical-align";s:3:"sub";}' ,
		  'css_script_d' => 'a:24:{s:11:"padding-top";s:2:"10";s:12:"padding-left";s:1:"5";s:13:"padding-right";s:2:"22";s:14:"padding-bottom";s:1:"0";s:5:"color";s:1:"0";s:16:"background-color";s:18:"rgba(22,106,102,1)";s:12:"table-layout";s:2:"10";s:7:"opacity";s:1:"1";s:5:"width";s:2:"18";s:6:"height";s:2:"33";s:4:"left";s:3:"346";s:3:"top";s:3:"382";s:9:"font-size";s:2:"10";s:6:"margin";s:2:"10";s:13:"border-radius";s:2:"44";s:12:"border-color";s:7:"#4af4eb";s:12:"border-width";s:1:"7";s:8:"overflow";s:4:"auto";s:16:"background-image";s:0:"";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:5:"right";s:12:"border-style";s:6:"double";s:14:"vertical-align";s:3:"sub";}' ,
		  'css_script_e' => 'a:24:{s:11:"padding-top";s:1:"7";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:5:"color";s:7:"#df2ca7";s:16:"background-color";s:19:"rgba(238,245,238,1)";s:12:"table-layout";s:2:"10";s:7:"opacity";s:3:"0.6";s:5:"width";s:3:"115";s:6:"height";s:2:"37";s:4:"left";s:2:"31";s:3:"top";s:3:"380";s:9:"font-size";s:2:"18";s:6:"margin";s:2:"10";s:13:"border-radius";s:3:"111";s:12:"border-color";s:7:"#82f5f4";s:12:"border-width";s:2:"11";s:8:"overflow";s:4:"auto";s:16:"background-image";s:1:"0";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:6:"center";s:12:"border-style";s:5:"ridge";s:14:"vertical-align";s:3:"sub";}' ,
		  'css_script_f' => 'a:24:{s:11:"padding-top";s:2:"10";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:5:"color";s:7:"#f2efef";s:16:"background-color";s:19:"rgba(176,198,196,1)";s:12:"table-layout";s:2:"10";s:7:"opacity";s:1:"1";s:5:"width";s:3:"484";s:6:"height";s:3:"493";s:4:"left";s:3:"-23";s:3:"top";s:1:"1";s:9:"font-size";s:2:"-1";s:6:"margin";s:2:"10";s:13:"border-radius";s:2:"20";s:12:"border-color";s:1:"0";s:12:"border-width";s:1:"7";s:8:"overflow";s:4:"auto";s:16:"background-image";s:1:"0";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"outset";s:14:"vertical-align";s:3:"sub";}',),
		array( 'style_table' => 'GalleryStyle', 
			'css_script_a' => 'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"18";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:33:"rgba(69,27,233,0.368991494178772)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"15";s:5:"color";s:7:"#4d19e8";s:6:"height";s:3:"193";s:5:"width";s:3:"204";s:4:"left";s:2:"-1";s:3:"top";s:2:"-6";s:13:"border-radius";s:1:"0";s:12:"border-width";s:1:"7";s:12:"border-color";s:7:"#d2e833";s:17:"background-origin";s:7:"inherit";s:15:"background-size";s:7:"inherit";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"hidden";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:7:"initial";}',
			'css_script_b' =>	'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"18";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:33:"rgba(69,27,233,0.368991494178772)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"15";s:5:"color";s:7:"#4d19e8";s:6:"height";s:3:"195";s:5:"width";s:3:"158";s:4:"left";s:3:"211";s:3:"top";s:2:"-6";s:13:"border-radius";s:1:"0";s:12:"border-width";s:1:"4";s:12:"border-color";s:7:"#d2e833";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:7:"inherit";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"hidden";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:7:"initial";}', 
			'css_script_c' =>	'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"18";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:33:"rgba(69,27,233,0.368991494178772)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"15";s:5:"color";s:7:"#2ce819";s:6:"height";s:2:"45";s:5:"width";s:3:"126";s:4:"left";s:1:"0";s:3:"top";s:3:"285";s:13:"border-radius";s:1:"0";s:12:"border-width";s:1:"7";s:12:"border-color";s:7:"#d2e833";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:6:"center";s:12:"border-style";s:4:"none";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:7:"initial";}', 
			'css_script_d' =>	'a:22:{s:6:"margin";s:2:"12";s:11:"padding-top";s:2:"53";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:33:"rgba(69,27,233,0.368991494178772)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"19";s:5:"color";s:7:"#2ce819";s:6:"height";s:2:"81";s:5:"width";s:3:"236";s:4:"left";s:3:"130";s:3:"top";s:3:"212";s:13:"border-radius";s:1:"0";s:12:"border-width";s:1:"7";s:12:"border-color";s:7:"#d2e833";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:6:"center";s:12:"border-style";s:4:"none";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:7:"initial";}', 
			'css_script_e' =>	'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"18";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:33:"rgba(69,27,233,0.368991494178772)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"15";s:5:"color";s:7:"#2ce819";s:6:"height";s:2:"48";s:5:"width";s:3:"127";s:4:"left";s:2:"-1";s:3:"top";s:3:"214";s:13:"border-radius";s:1:"0";s:12:"border-width";s:1:"4";s:12:"border-color";s:7:"#d2e833";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"hidden";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:7:"initial";}', 
			'css_script_f' =>	'a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"18";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:35:"rgba(77,25,232,0.20884883403778076)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"15";s:5:"color";s:7:"#2ce819";s:6:"height";s:3:"359";s:5:"width";s:3:"384";s:4:"left";s:2:"-3";s:3:"top";s:1:"0";s:13:"border-radius";s:2:"41";s:12:"border-width";s:2:"38";s:12:"border-color";s:7:"#eb1755";s:17:"background-origin";s:10:"border-box";s:15:"background-size";s:5:"cover";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"dashed";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:7:"initial";}',),
	);
			

		foreach ( $_css_init_example as $key ){
			if( is_array($key) ){
					$wpdb->replace( $wpdb->prefix . 'theme_module_css' , $key , array( '%s', '%s', '%s', '%s' , '%s' , '%s' , '%s'  )  );
			}		
		}
		 
		return $css_name_ ;
	}


}

?>