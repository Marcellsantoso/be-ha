<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TutorialFWWeb_Start
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TutorialFWWeb_Start extends WebService{
   public function segment_start(){
        $arrContent = array(
          "Pembuatan Project dan MainClass" => new Portlet("TutorialFWWeb_Start", "mainClass"),
          "Pembuatan Model" => new Portlet("TutorialFWWeb_Start", "Model"),
          "Pembuatan Controller" => new Portlet("TutorialFWWeb_Start", "Controller"),
          "Pembuatan dan Pemakaian Plugin" => new Portlet("TutorialFWWeb_Start", "Plugin"),
          "Pembuatan Mold" => new Portlet("TutorialFWWeb_Start", "Mold")   
        );
        BootstrapUX::accordion($arrContent);
    }
    
    public function Mold(){
        ?>
<p>
    Pembuatan Mold cukup mudah. 
</p>    
<ol>
    <li>
        Setelah anda mendapat semua data yang akan anda print, masukan semua data ini kedalam sebuah associative array.
        <br>baca Utility/Mold.
        <pre>
public function printDepartmentWall($cmd = ""){
        
        /*
         * pertama print wall berdasarkan org ID nya
         */
        $type = $_GET['type'];
        $org_id = (isset($_GET['kelasid']) ? addslashes($_GET['kelasid']) : die('Please define target id'));
        $begin = (isset($_GET['begin']) ? addslashes($_GET['begin']) : 0);
        
        $return['$arrWall'] = $this->getKelasWall($org_id,$type, $begin);
                       
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['cmd'] = $cmd;
        
        Mold::plugin("Wall", "all_class_wall", $return);
    }            
        </pre>
    </li>
    <li>
        Setelah itu buat file yang akan dijadikan cetakan, dalam contoh diatas kita akan membuat
        file all_class_wall.php didalam /app/BPlugin/Wall/Mold/. 
        <br>
        Isi file tersebut semisal :
        <pre>
&lt;div id="walllist">
&lt;? foreach ($arrWall as $m) {
    Mold::plugin("Wall","einzel_post",
        array ("m" => $m, "typ" => $type, "klsid" => $kelas_id, "newFor" => $newFor));
} ?>
&lt;/div>            
        </pre>
        <p>
            Pada contoh di atas kita menggunakan dua kali Mold supaya semua mold bisa reusable.
        </p>
    </li>
</ol>
        <?
    }


    public function Plugin(){
        ?>
<p>
    Plugin adalah sarana untuk menambah fitur/fungsi dari suatu WebApps dengan mudah, cepat serta reusable.
</p>            
<p>
    Ada 2 topik penting yang akan diulas disini.
</p>
<ol>
    <li>
        Pembuatan Plugin
    </li>
    <li>
        Pemakaian predefined Plugin
    </li>
</ol>
<h3>Pembuatan Plugin</h3>
<p>
    Untuk membuat plugin hanya perlu menambah folder baru di <mark>/app/BPlugin/plugin_name</mark>.
</p>
<p>
    Setelah itu buatlah folder "Classes" yang nanti berisikan MVC folder kita, kecuali folder Mold(View)
    yang akan kita tarus sejajar dengan folder "Classes". 
</p>
<p>
    Biasanya plugin membutuhkan folder Model, Controller, Mold dan Utility. <br>
    Buatlah folder-folder tersebut pada folder Classes (Model, Controller dan Utility). <br>
    Sehingga semuanya menjadi <mark>/app/BPlugin/plugin_name/Classes/Model/</mark> , 
    <mark>/app/BPlugin/plugin_name/Classes/Controller/</mark> dan <mark>/app/BPlugin/plugin_name/Classes/Utility/</mark>.
    <br>
    Selanjutnya buat folder "Mold" sejajar dengan folder Classes sehingga pathnya menjadi <mark>/app/BPlugin/plugin_name/Mold/</mark>
</p>
<p>
    Setelah itu buat file <mark>"functions.php"</mark> yang berfungsi sebagai hook yang akan selalu di execute
    jika apps dipanggil.
</p>
<p>
    Setelah itu mulai buat semua Model, Controller serta Mold sesuati dengan tutorial masing-masih kelas.
</p>
<p>
    Plugin sudah siap dipanggil melalui Logic Layer yang berada didalam folder /app/Logic/ yang tidak lain 
    adalah app dari Project kita.
</p>
<h3>Pemakaian predefined Plugin</h3>
<p>
    Untuk memakai predefined plugin, pertama-tama cari plugin apa yang anda mau pakai.
</p>
<p>
    Setelah ada temukan sekarang anda bisa menambahkan plugin tersebut ke backend anda, dengan cara
    meng-uncomment perintah Registor yang ada di file functions.php.
</p>
<pre>
<mark>/*</mark> //hapus ini 
//set menu format domain, menuname. menu url
Registor::registerAdminMenu("LandingPage", "Quotes", "QuoteWeb/quotes");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Quotes");
<mark>*/</mark> //hapus ini
</pre>
<p>
    Setelah anda menghapus commentnya, plugin akan bisa diakses lewat backend.    
</p>
<p>
    Untuk memasang ke front-end, anda bisa membaca file readme (TODO) atau membuka file Controller dari plugin-plugin tersebut.
</p>
<p>
    Karena FrontEnd hanya boleh mengakses plugin melalui Controller Class dari suatu plugin, dapat dipastikan semua logic 
    yang dibutuhkan untuk mengakses plugin terdapat didalam controller class. (loosely coupled)
</p>
         <?
    }


    public function Controller(){
        ?>
<p>
    Yang dimaksud SubClass Controller adalah class yang dapat diakses via URL (yang memproses interaksi dari User).
</p>            
<p>
    Controller diharuskan untuk meng-extends class WebApps dan class WebService.
</p>
<pre>
class MuridWeb extends WebApps{
    function profile(){
        $id = isset($_GET['id'])?addslashes($id):die(''no ID); //take value from GET
        $murid = new Murid();
        $murid->getByID($id);
        $murid->printProfile();
    }
}    
</pre>
<p>
    Contoh diatas akan dapat dipanggil di URL <mark>http://www.yourdomain.com/muridweb/profile?id=1</mark>.
</p>
<p>
    File untuk controller dapat ditaruh didalam folder <mark>/app/Logic/app_name/Controller/</mark> atau bisa juga dibuat sebagai 
    tampilan untuk sebuah plugin <mark>/app/BPlugin/plugin_name/Classes/Controller/</mark>.
</p>
        <?
    }

    public function Model(){
        ?>
<p>
    Pembuatan SubClass Model hanya membutuhkan configurasi seperti contoh di concept/model.
</p>
<p>
    File untuk Model dapat ditaruh didalam folder <mark>/app/Logic/app_name/Model/</mark> atau bisa juga dibuat sebagai 
    tampilan untuk sebuah plugin <mark>/app/BPlugin/plugin_name/Classes/Model/</mark>.
</p>
<p>
    Contoh dapat dilihat dibawah ini. 
</p>            

        <?
        $tc = new TutorialFWWeb_Concept();
        $tc->Model();
        
    }

    public function mainClass(){
        ?>
<p>
    Berikut adalah list untuk memulai suatu project.
<ol>
    <li><b>Copy Seluruh File Framework dari Git</b></li>
    <li><b>Modify include/access.php</b><br>
        Cara dapat dilihat dibagian Installasi.<br>
        <mark>Jangan Lupa ganti value $mainclass sesuai project</mark>
    </li>
    <li>
        <b>Buat project folder di <mark>/app/Logic/projectname</mark></b>
    </li>
    <li>
        <b>Create mainClass didalam folder project</b> 
        <br>
        Pastikan nama mainClass sesuai dengan nama file dan value yang ada di access.php.
        <br>
        Jangan lupa extend mainClass dengan <mark>extends WebApps</mark>.
        <br>
        Untuk lebih jelasnya bisa dibaca dibagian concept/mainclass.
    </li>
    <li>
        <b>Buat method index di mainClass</b>
        <pre>
class mainClass extends WebApps{
    public function index(){
        echo "hello world";
    }
}  </pre>
    </li>
    <li>
        <b>Lanjutkan dengan membuat class-class logic lainnya.</b>
    </li>
</ol>    
</p>            
        <?
    }
}
