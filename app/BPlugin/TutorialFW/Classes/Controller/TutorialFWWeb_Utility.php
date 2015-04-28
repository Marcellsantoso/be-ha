<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TutorialFWWeb_Utility
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TutorialFWWeb_Utility extends TutorialFWWeb{
    public function segment_utility(){
        $arrContent = array(
          "Lang" => new Portlet("TutorialFWWeb_Utility", "Lang"),
          "Mold" => new Portlet("TutorialFWWeb_Utility", "Mold"),
          "Registor" => new Portlet("TutorialFWWeb_Utility", "Registor"),
          "Inputs" => new Portlet("TutorialFWWeb_Utility", "Inputs"),         
          "Redirect" => new Portlet("TutorialFWWeb_Utility", "Redirect"),  
          "Hook" => new Portlet("TutorialFWWeb_Utility", "Hook"),  
          "BootstrapUX" => new Portlet("TutorialFWWeb_Utility", "BootstrapUX"),  
          "jQuery" => new Portlet("TutorialFWWeb_Utility", "jQuery"),  
          "openLw" => new Portlet("TutorialFWWeb_Utility", "openLw"),
          "pr" => new Portlet("TutorialFWWeb_Utility", "pr"),
          "leap_mysqldate" => new Portlet("TutorialFWWeb_Utility", "leap_mysqldate"),
          "indonesian_date" => new Portlet("TutorialFWWeb_Utility", "indonesian_date"),
        );
       
        BootstrapUX::accordion($arrContent);
    }
    public function Redirect(){
        ?>
<p>
    Fungsi untuk static redirection, supaya tidak menulis satu-satu. Just a container.
</p>
<pre>
Redirect::firstPage();//redirect ke home
Redirect::loginFailed();//redirect ke index atau page yang ditentukan
</pre>
          <?
    }

    public function Hook(){
        ?>
<p>
    Class Hook, dipakai untuk membuat dan memanggil Hook terhadap suatu method di class.
</p>            
<p>
    Contoh Penggunaan, di AccountLogin Plugin
</p>
<pre>
//pemakaian di class AccountLogin
public $login_hook = array ();
function process_login ()
{
    $username = addslashes($_POST["admin_username"]);
    $password = addslashes($_POST["admin_password"]);
    $rememberme = (isset($_POST["rememberme"]) ? 1 : 0);
    $row = array ("admin_username" => $username, "admin_password" => $password, "rememberme" => $rememberme);
    //login pakai row credential
    Auth::login($row);
    //kalau sukses
    if (Auth::isLogged()) {
        <mark>Hook::processHook($this->login_hook);</mark>
        Redirect::firstPage();
    } else {
        Redirect::loginFailed();
    }
}    
</pre>
<p>
    Pemakaian dari Luar
</p>
<pre>
function login ()
{
        /*
         * login logic
         */
        $acc = new AccountLogin();
        //create hook
        <mark>$acc->login_hook = array (
                "PortalHierarchy" => "getSelectedHierarchy",
                "NewsChannel"     => "loadSubscription",
                "Role"            => "loadRoleToSession"
        );</mark>

        $acc->process_login();
}    
</pre>
        <?
    }

    public function indonesian_date(){
        ?>
<p>
    return indonesian date format d/m/y hh:mm. Formatting function only.
</p>
<pre>
    $now = indonesian_date($mysqldate); return indonesian date format 
</pre>
         <?
    }
    public function leap_mysqldate(){
        ?>
<p>
    return datetime now pre formated for mysql. Digunakan jika waktu local server berbeda dengan waktu programm.
    e.g server di US.
</p>
<pre>
    $now = leap_mysqldate(); //return datetime now pre formated for mysql, 
</pre>
         <?
    }
    public function pr(){
        ?>
<p>
    Fungsi ini adalah fungsi print anything di php, bisa buat object, array maupun variable. pengeprintan disertai
    tag &lt;pre&gt; sehingga mudah dibaca.
</p>
<pre>
    pr($murid);
</pre>
         <?
    }

    public function openLw(){
        ?>
<p>
    openLw adalah fungsi javascript untuk membuat object Lw (Leap Window) yang berguna agar pembuatan window
    dilakukan secara automatis oleh sistem.
</p>
<p>
    Cara Pemakaian :
</p>    
<pre>
  &lt;a onclick="openLw('ID','Path','Animation');">&lt;/a> //animation sementara hanya ada fade dan scrollBottom
</pre>

        <?
    }
    public function jQuery(){
        ?>
<p>
    jQuery class dipergunakan untuk mempermudah pemakaian jQuery. Sehingga programmer hanya perlu memakai kelas ini.    
</p>
<p>
    Status : masih ongoing
</p>
        <?
    }
    public function BootstrapUX(){
        ?>
<p>
    BootstrapUX class dipergunakan untuk mempermudah pemakaian bootstrap. Sehingga programmer hanya perlu memakai kelas ini.    
</p>
<p>
    Status : masih ongoing
</p>
        <?
    }

    public function Inputs(){
        ?>
<p>Untuk memudahkan dan menstandarkan inisiasi input pada form. Leap FW sudah dilengkapi dengan berbagai macam Inputs</p>            
<p>
    Jenis-jenis input tersebut adalah :
<ol>
    <li>
        <b>InputText</b>
        <p>
            Auto Input Text Creation
        </p>
        <pre>
//jenis-jenis tipe sesuai standar html5
$input = new \Leap\View\InputText("text","test_date", "test_date", $this->test_date); //type text
$input = new \Leap\View\InputText("hidden","test_date", "test_date", $this->test_date); //type hidden          
$input = new \Leap\View\InputText("color","test_date", "test_date", $this->test_date); //type color
$input = new \Leap\View\InputText("email","test_date", "test_date", $this->test_date); //type email
$input = new \Leap\View\InputText("date","test_date", "test_date", $this->test_date); //type date
$input = new \Leap\View\InputText("datetime","test_date", "test_date", $this->test_date); //type datetime
$input = new \Leap\View\InputText("password","test_date", "test_date", $this->test_date); //type password
$input = new \Leap\View\InputText("number","test_date", "test_date", $this->test_date); //type number
        </pre>
    </li>
    <li>
        <b>InputTextArea</b>
        <p>
            Auto Input TextArea Creation
        </p>
        <pre>

$input = new \Leap\View\InputTextArea("test_date", "test_date", $this->test_date); 
        </pre>
    </li>
    <li>
        <b>InputSelect</b>
        <p>
            Auto Input Select Box Creation
        </p>
        <pre>
//$arr associative array untuk mengisi option value dan option text
$arrYesNo = array(0=>"No",1=>"Yes");
$input = new \Leap\View\InputSelect($arrYesNo,"test_date", "test_date", $this->test_date); 
        </pre>
    </li>
    <li>
        <b>InputFoto</b>
        <p>
            Auto Foto Uploader Creation
        </p>
        <pre>
$input = new \Leap\View\InputFoto("test_date", "test_date", $this->test_date); 
        </pre>
    </li>
    <li>
        <b>InputFile</b>
        <p>
            Auto File Uploader Creation
        </p>
        <pre>

$input = new \Leap\View\InputFile("test_date", "test_date", $this->test_date); 
        </pre>
    </li>
    <li>
        <b>InputRTE</b>
        <p>
            Coming soon
        </p>
        
    </li>
</ol>
</p>
        <?
    }

    public function Registor(){
        ?>
<p>
    Sesuai dengan namanya, Registor berfungsi untuk meregister roles dan menu. Kelas ini merupakan bagian dari 
    AccountLogin Plugin.
</p>            
<p>
    Contoh cara Pemakaian :
</p>
<pre>
//set menu format domain, menuname. menu url
Registor::registerAdminMenu("LandingPage", "Carousel", "CarouselPortalWeb/CarouselPortal");
//set role yang bisa lihat menu, akan keluar di admin
Registor::setDomainAndRoleMenu("Carousel");
</pre>
        <?
    }

    public function Mold(){
        ?>
<p>
    Class Mold bertujuan sebagai kelas bantu untuk memisahkan desain dengan Logic, serta supaya
    desain bisa reusable.
</p>   
<p>
    Mold mengenal 3 fungsi utama.
<ol>
    <li>
        <b>both</b>
        <pre>both ($act, $arr = array ())</pre>
        <p>
            Mold::both adalah fungsi untuk melakukan molding/mencetak dengan dua argument, yaitu $act dan $arr.<br>
            $act bertindak sebagai pemberitahu path dan filename dari mold. <br>
            Lokasi file mold bertempat di dalam folder <mark>/Mold/</mark>.<br>
            $arr berfungsi untuk mengirimkan data untuk diprosses di mold file.<br>
            Arraynya hrs associative karena nanti isi dari array akan di auto convert menjadi variable dengan nama
            sesuai pada key associativenya.
        </p>
        <p>
            Contoh :
        </p>
        <pre>
$murid = new Murid();
$return = array();
$return['arrMurid'] = $murid->getAll(); //harus associative array
Mold::both("muridTable",$return);</pre>
    </li>
    <li>
        <b>plugin</b>
        <pre>plugin ($pluginname, $act, $arr = array ())</pre>
        <p>
            Mold::plugin adalah fungsi untuk melakukan molding/mencetak dengan cetakan pada plugin tertentu 
            yang mempunyai tiga argument, yaitu $pluginname,$act dan $arr.<br>
            $pluginname adalah nama plugin yang dituju.<br>
            $act bertindak sebagai pemberitahu path dan filename dari mold. <br>
            Lokasi file mold bertempat di dalam folder <mark>/app/BPlugin/Pluginame/Mold/</mark>.<br>
            $arr berfungsi untuk mengirimkan data untuk diprosses di mold file.<br>
            Arraynya hrs associative karena nanti isi dari array akan di auto convert menjadi variable dengan nama
            sesuai pada key associativenya.
        </p>
        <p>
            Contoh :
        </p>
        <pre>
$murid = new Murid();
$return = array();
$return['arrMurid'] = $murid->getAll(); //harus associative array
Mold::plugin("Murid","muridTable",$return);</pre>
    </li>
    <li>
        <b>theme</b>
        <pre>theme ($act, $arr = array ())</pre>
        <p>
            Mold::theme adalah fungsi untuk melakukan molding/mencetak dengan cetakan pada plugin tertentu 
            yang mempunyai dua argument, yaitu $act dan $arr.<br>
            Perbedaan dengan both disini hanya pada lokasi Moldnya saja, lokasi akan berubah secara dinamis, tergantung pada theme yang aktif.<br>
            $act bertindak sebagai pemberitahu path dan filename dari mold. <br>
            Lokasi file mold bertempat di dalam folder <mark>/themes/activetheme/Mold/</mark>.<br>
            $arr berfungsi untuk mengirimkan data untuk diprosses di mold file.<br>
            Arraynya hrs associative karena nanti isi dari array akan di auto convert menjadi variable dengan nama
            sesuai pada key associativenya.
        </p>
        <p>
            Contoh :
        </p>
        <pre>
$murid = new Murid();
$return = array();
$return['arrMurid'] = $murid->getAll(); //harus associative array
Mold::theme("muridTable",$return);</pre>
    </li>
</ol>
</p>
         <?
    }

    public function Lang(){
        ?>
<p>
    Class Lang bertujuan untuk menjalankan auto replace string dengan bahasa yang dipilih user.
</p>
<p>
    Cara pemakaian :
</p>
<pre>Lang::t('video_name'); //akan mereplace video_name dengan translation jika ada</pre>
<p>
    Jika tidak ada, video_name akan tetap di print dengan video_name.
</p>
        <?
    }
}
