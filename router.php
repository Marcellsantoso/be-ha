<?php

/* **********************************

 * 

 *        Leap System eLearning

 *      @author elroy,efindi,budiarto

 *          www.leap-systems.com

 * 

 ************************************/

/******************************
 *  LOAD All Frameworks
 *  using Leap loosely coupled Object Oriented Framework
 *  using PHP Framework Interop Group Standard
 *****************************/

require_once 'SplClassLoader.php';

//enginepath

$enginepath = 'framework';

//namespace or vendorname

$ns = "Leap";

//autoload all Classes in the FrameWork

$loader = new SplClassLoader($ns, $enginepath);

$loader->register();


//get the init class, kalau tidak ada perubahan juga bisa langsung pakai Init yang di framework

//use Leap\InitLeap;

require_once 'Init.php'; // pembedanya adalah yg disini untuk load yg local classes saja

//get global functions 

require_once 'functions.php';


/******************************
 *  AUTO LOAD Apps
 *****************************/

$di = new RecursiveDirectoryIterator('app', RecursiveDirectoryIterator::SKIP_DOTS);
//pr($di);
$it = new RecursiveIteratorIterator($di);
//pr($it);

//sort function
$files2Load = array ();
foreach ($it as $file) {

    if (pathinfo($file, PATHINFO_EXTENSION) == "php") {
        $files2Load[] = $file->getPathname();
    }
}
sort($files2Load);
//pr($files2Load);

foreach ($files2Load as $file) {
    //penambahan mold
    if (strpos($file, 'BPlugin') && (strpos($file, 'Mold') || strpos($file, 'functions.php'))) {
        continue;
    }
    //echo $file;echo "<br>";
    require_once $file;

}

// include db setting, web setting, and paths

require_once 'include/access.php';

//init db setting
$DbSetting = array ("serverpath" => $serverpath, "db_username" => $db_username, "db_password" => $db_password,
                    "db_name"    => $db_name, "db_prefix" => $db_prefix);

// init web setting
$WebSetting = array ("domain"          => $domain, "folder" => $folder, "title" => $title, "metakey" => $metakey,
                     "metadescription" => $metadescription, "lang" => $lang, "currency" => $currency,
                     "photopath"       => $photo_path, "photourl" => $photo_url, "themepath" => $themepath);

$init = new Init($mainClass, $DbSetting, $WebSetting, $timezone, $js, $css, $nameSpaceForApps);

//mainClass singleton
$main = new $mainClass();

//starting the session
session_start();
//pr($WebSetting);
//Init Languange

$lang = new Lang($WebSetting['lang']);

$lang->activateLangSession();

$lang->activateGetSetLang();
//pr($lang);
//pr($_SESSION);
$selected_lang = Lang::getLang();
if (!isset($selected_lang) || $selected_lang == "" || is_object($selected_lang)) {
    $selected_lang = "en";
}

//pr($selected_lang);

//echo "lang/".strtolower($selected_lang).".php";
require_once("lang/" . strtolower($selected_lang) . ".php");

//get globals

$db = $init->getDB();

$params = $init->getParams();

$template = $init->getTemplate();


//dynamic theme selection
if($useDynamicTheme){
    //echo $backEndClass;
    //echo "<br>".$_GET['url'];
    if (strpos(strtolower($_GET['url']), strtolower($backEndClass)) !== false){       
           $themepath = $backEndTheme;                     
    }else{
        $themepath = ThemeItem::getTheme();
    }
    
}
$init->setThemeDynamic($themepath);

//include the functions 
foreach ($files2Load as $file) {
    //penambahan mold
    if (strpos($file, 'BPlugin') && strpos($file, 'functions.php')) {
        require_once $file;
    }
}

//set session for photopath and photourl
$_SESSION['photopath'] = _PHOTOPATH;
$_SESSION['photourl'] = _SPPATH._PHOTOURL;


if($useDynamicWebSetting){
    //coba di load websettingnya
    $ef = new Efiwebsetting();
    $ef->loadToSession();
    //pr($_SESSION);
    //echo Efiwebsetting::getWebTitle();
    //pr($init);
    $template->setTitle(Efiwebsetting::getWebTitle());
    $template->setMetaKey(Efiwebsetting::getWebMetaKey());
    $template->setMetaDesc(Efiwebsetting::getWebMetaDesc());
}
//pr($template);
$init->run();


