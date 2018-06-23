<?php

class Install
{
	
	private $sample_dir = 'vendor/geegler/geegler/example/';
	
	private $app_dir = [
					'app/configs', 'app/controllers','app/models', 'app/helpers', 'app/libraries'
                    ];
	
	private $public_dir = [
					'public/html', 'public/html/templates', 'public/images', 'public/js', 'public/styles', 'public/json',
					'public/html/templates/tbs', 'public/html/templates/tbs/cache', 'public/html/templates/tbs/parents',
				];
	
	
	private $example_files = [
                    'composer_sample.txt' => 'composer.json',
					'404.txt' => 'public/html/404.php',
                    //'init_sample.txt' => 'app/init.php',
					'appconfig_sample.txt' => 'app/configs/appconstants.php',
					'routing_sample.txt' => 'app/configs/routing.php',
					'htaccess_sample.txt' => '.htaccess',
					'maincontroller_sample.txt' => 'app/controllers/main.php',
					'mainmodel_sample.txt' => 'app/models/main_model.php',
					'maintemplate_sample.txt' => 'public/html/templates/tbs/main.html',
					'index_sample.txt' => 'index.php',
					'w3_sample.txt' => 'public/styles/w3.css',

				];
	
	public function __construct(){
		
	}
	
	public function makeAppDir(){
		
		foreach($this->app_dir as $ad){
		if(!is_dir($ad)){
					
					$x = mkdir($ad,0755,TRUE);
					
					}
					else{
							//echo '>>> '. $dir .'directories already exists! <br/>';
							//$x = true;
						}
	}
	}
	public function makePubDir(){
		foreach($this->public_dir as $pd){
			if(!is_dir($pd)){
				$y = mkdir($pd,0755, true);
		}else{
		echo $pd .' already exists <br/>';
		echo "\n";
	}
	}
	}
	
	public function makeSampleApp(){
		foreach($this->example_files as $sample => $newfile){
		//echo 'vendor location : '. $sample .'  destination : '. $newfile .'<br/>';
		if(file_exists($this->sample_dir.$sample) && (!file_exists($newfile))){
			copy($this->sample_dir.$sample, $newfile);
		}else{
			echo 'this already exist '. $newfile .'<br/>';
		}
}
	}
}

$installer = new Install();
$installer->makeAppDir();
$installer->makePubDir();
$installer->makeSampleApp();
