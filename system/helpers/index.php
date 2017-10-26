<?php require_once(__DIR__ .'/vendor/geeglerapp/app/config/appconstants.php');

require_once(__DIR__ .'/vendor/autoload.php');

$controller = "App\Controller\Main";
/*
use FormManager\Builder as F;

$name = F::text()->class('my-input')->required();

echo $name; //<input type="text" class="my-input" required>

//print the input with extra attributes
echo $name->addClass('text-input')->placeholder('Your name');
*/
use System\Helpers\FormHelper;

FormHelper::testFormHelper();
echo '<br/>';

$form = new FormHelper();
//($name,$class,$id,$type,$method,$action)
echo $form->openForm('test','form_class', 'form_id', 'encytpe','POST', 'self');
echo $form->makeInput('text','input');
echo '<br/>';
/*

use App\Controller\Main;
//use $controller;
Main::testMain();
*/


/*
+-------------------------------------+
+ Testing System\Core Namespace       +
+-------------------------------------+
*/
echo '<h3>System Core Tests</h3>';
use System\Core\Controller\Controller;
Controller::testSystemController();








$included_files = get_included_files();

echo '<br/>';
foreach ($included_files as $filename) {
    echo $filename .'<br/>';
}


/*
+-----------------------------------------------+
+ Libraries and Helpers Tests                   +
+-----------------------------------------------+
*/


echo '<h3>Router Test</h3>';
use System\Libraries\Router;

Router::testRouter();

echo '<h4>System Helpers Test</h4>';

use System\Helpers\Loader;

Loader::testFileLoader();

echo '<br/>';

use System\Helpers\UrlHelper;
UrlHelper::testUrlHelper();



echo '<h4>Dispatcher Test</h4> ';
use System\Libraries\Dispatcher;
Dispatcher::testDispatcher();

echo '<br/>';

echo '<h4> File helper test</h4>';
use System\Helpers\FileHelper;

FileHelper::testFileHelper();

echo '<br/>';
use System\Libraries\GeeglerTbs;

//GeeglerTbs::testGeeglerTbs();
$render = new GeeglerTbs();

$summary = (FileHelper::parse_json('summary', 'summary', 'posts'));
$render->view($summary,'test');
//echo file_get_contents(CONTENT_DIR .'20.txt' , true);

