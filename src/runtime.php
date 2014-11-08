<?php
	require_once('config/base_config.php');

	//Set default values (only used if no values can be found in database)
	$GLOBALS['installed'] = false;
	$GLOBALS['template'] = "freifunk_oldenburg";

	$GLOBALS['community_name'] = "Freifunk Deinestadt";
	$GLOBALS['community_slogan'] = "Die freie WLAN-Community aus deiner Stadt • Freie Netze für alle!";
		
	//check if netmons root path and the config path is writable to created temp dirs and config file

	$check_writable[] = '/config/';
	$not_writeable=0;
	foreach($check_writable as $path) {
		if (!is_writable(ROOT_DIR.$path)) {
			echo ROOT_DIR.$path."<br>";
			$not_writeable++;
		}
	}
	if($not_writeable>0) {
		echo "Please set writable permissions to the above files and directories and reload the site.";
		die();
	}
	unset($check_writable);
		
	//create temp directories
	$create_dirs[] = '/view/templates_c/';
	$create_dirs[] = '/view/tmp/';
	$create_dirs[] = '/view/rrdtool/';
	$create_dirs[] = '/view/rrdtool/databases/';
	$not_created=0;
	foreach($create_dirs as $dir) {
		if(!file_exists(ROOT_DIR.$dir)){
			if(mkdir(ROOT_DIR.$dir)==false){
				echo ROOT_DIR.$dir."<br>";
				$not_created++;
			};
		}
	}
	
	if($not_writeable>0) {
		echo "The directries above could not be created. Check your configuration!";
		die();
	}
	
	//check if directories and files are writable
	$check_writable = $create_dirs;
	$check_writable[] = '/';
// 	$check_writable[] = '/config/config.local.inc.php';
	$not_writeable=0;
	foreach($check_writable as $path) {
		if (!is_writable(ROOT_DIR.$path)) {
			echo ROOT_DIR.$path."<br>";
			$not_writeable++;
		}
	}

	if($not_writeable>0) {
		echo "Please set writable permissions to the above files and directories and reload the site.";
		die();
	}

	// set content type and timezone
	header("Content-Type: text/html; charset=UTF-8");
	date_default_timezone_set('Europe/Berlin');
	

	
	//include important classes
	require_once(ROOT_DIR.'/lib/core/Db.class.php');
	require_once(ROOT_DIR.'/lib/core/Config.class.php');
	
	if ($GLOBALS['installed']) {
		//NETWORK
		$GLOBALS['community_name'] = Config::getConfigValueByName('community_name');
		$GLOBALS['community_slogan'] = Config::getConfigValueByName('community_slogan');
		
		//PROJEKT
		$GLOBALS['hours_to_keep_mysql_crawl_data'] = Config::getConfigValueByName('hours_to_keep_mysql_crawl_data');
		$GLOBALS['hours_to_keep_history_table'] = Config::getConfigValueByName('hours_to_keep_history_table');
		
		//GOOGLEMAPSAPIKEY
		$GLOBALS['google_maps_api_key'] = Config::getConfigValueByName('google_maps_api_key');

		//TEMPLATE
		$GLOBALS['template'] = Config::getConfigValueByName('template');
	}

	//load smarty template engine
	require_once (ROOT_DIR.'/lib/extern/smarty/Smarty.class.php');
	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = true;

	// base template directory
	// this is used as a fallback if nothing is found in the custom template folder
	// lookup ordered by param2
	$smarty->addTemplateDir(ROOT_DIR.'/view/templates/base/html', 10);
	// custom template folder - smarty will try here first ( order 0 )
	$smarty->addTemplateDir(ROOT_DIR.'/view/templates/'.$GLOBALS['template'].'/html', 0);

	$smarty->compile_dir = ROOT_DIR.'/view/templates_c';
	$smarty->assign('template', $GLOBALS['template']);
	$smarty->assign('installed', $GLOBALS['installed']);
	$smarty->assign('community_name', $GLOBALS['community_name']);
	$smarty->assign('community_slogan', $GLOBALS['community_slogan']);


	$smarty->assign('zeit', date("d.m.Y H:i:s", time())." Uhr");
?>