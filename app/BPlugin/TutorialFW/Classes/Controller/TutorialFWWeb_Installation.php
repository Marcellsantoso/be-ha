<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TutorialFWWeb_Installation
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TutorialFWWeb_Installation extends WebService{
    /*
     * Installation
     */
    public function segment_installation(){
        $arrContent = array(
          "access.php" => new Portlet("TutorialFWWeb_Installation", "access_php"),
          "php.ini" => new Portlet("TutorialFWWeb_Installation", "php_ini") 
        );
        BootstrapUX::accordion($arrContent);
    }
    public function access_php(){
        ?>
        <h1>Modify access.php</h1>
        <p>
            Setelah mendownload dari Git sebuah project berbasis LeapFW, jangan lupa untuk mengedit file <mark>include/access.php</mark>
        </p>
        <p>
            Keterangan dapat dilihat dibawah ini.
        </p>
        <pre>
/*
 *  Database, Websetting and Path Setting
 *  Change according to your server setting
 */
$serverpath = "localhost"; <mark>//db server location</mark>
$db_username = "dbusername"; <mark>//db username</mark>
$db_password = "passwd"; <mark>//db password</mark>
$db_name = "db1"; <mark>//db name</mark>
$db_prefix = ''; //db prefix //blm bs jalan

//Websetting
$domain = "www.yourdomain.com"; <mark>// main URL e.g localhost</mark>
$folder = '/'; <mark>//folder normaly '/', if installed on main folder</mark>
$title = 'Web Title'; <mark>//default title for the site</mark>
$metakey = 'Meta Key'; <mark>//default key</mark>
$metadescription = <mark>'Meta Description'; //default meta description</mark>
$lang = 'en'; <mark>//default language</mark>
$currency = 'IDR'; //default currency //blm jalan
$photo_path = 'C:/path/to/photos/'; <mark>//absolute file system path, utk linux /opt/public_html/..</mark>
$photo_url = '/path/to/photos'; <mark>//URL path</mark>

//main class MUST BE subclass of Apps
$mainClass = "Leap"; <mark>//main class for your Apps, kalau di java, class dimana 'public void main' berada</mark>
        </pre>
        <p>
            <b>
                Rubah config terutama yang <mark>dihighlight</mark> saja.
            </b>
        </p>
        <?
    }
    public function php_ini(){
        ?>
        <h1>Modify php.ini <small>if needed</small></h1>
        <p>
            Ada beberapa hal yang perlu di edit untuk pertama kalinya.<i>(biasanya setelah install xampp).</i>
        </p>
        <ul>
            <li>Aktifkan php short tag => <mark>short_open_tag=On</mark></li>
            <li>Ubah display error menjadi E_ERROR => <mark>error_reporting=E_ERROR</mark></li>
        </ul>
        <?
    }
}
