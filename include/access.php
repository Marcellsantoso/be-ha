<?php
/*
 *  Database, Websetting and Path Setting
 *  untuk multiple selection di def di init.php
 */
$serverpath = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "ballers";
$db_prefix = '';

//Websetting
$domain = "localhost:8888";
$folder = '/ballers/';
$title = 'Hulx';
$metakey = 'Hulx';
$metadescription = 'Hulx';
$lang = 'en';
$currency = 'IDR';
//path untuk save, filesystem path kalau untuk linux bisa dari depan /opt/lamp/...
$photo_path = '/Users/MarcelSantoso/Documents/PHP/ballers/upload/';
//path utk url, tanpa http:// dan tanpa folder e.g /leapportal/
$photo_url = 'upload/';

//use setting from DB
$useDynamicWebSetting = 1;

//use Theme Selector FROM DB
$useDynamicTheme = 1;
$themepath = 'fashion'; //default theme
$backEndTheme = "adminlte"; //default backend theme

//pakai 2 themes 1 utk Backend 1 utk frontend
$useBackEnd = 1;

//adminsite url, the login page is at backEndClass/index 
$backEndClass = "BackEnd";

//main class MUST BE subclass of Apps
$mainClass = "Home";

//timezone
$timezone = 'Asia/Jakarta';

//javascript files
$js = "loader_js.php";
//css files
$css = "loader_css.php";


//set namespace for apps
$nameSpaceForApps = array ("");