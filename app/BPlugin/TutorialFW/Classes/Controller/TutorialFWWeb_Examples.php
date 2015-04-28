<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TutorialFWWeb_Examples
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TutorialFWWeb_Examples extends TutorialFWWeb{
    public function segment_example(){
        $arrContent = array(
          "Old School vs Leap Framework" => new Portlet("TutorialFWWeb_Examples", "osfw"),  
          "Static Web" => new Portlet("TutorialFWWeb_Examples", "sweb"),
          "Panggilan Database" => new Portlet("TutorialFWWeb_Examples", "dbcall"),  
          /*"Penambahan jQuery" => new Portlet("TutorialFWWeb", "noContent"),
          "Form" => new Portlet("TutorialFWWeb", "noContent"),
          "BackEnd" => new Portlet("TutorialFWWeb", "noContent"),
          "jQuery" => new Portlet("TutorialFWWeb", "noContent"),
          "Dynamic Page" => new Portlet("TutorialFWWeb", "noContent")  */
        );
        BootstrapUX::accordion($arrContent);
    }
    public function dbcall(){
        ?>
<p>
    Untuk menyelesaikan project yang sangat sederhana, dimana kita tidak membutuhkan Model,
    kita tetap bisa memanggil query ke database dengan cara berikut.
</p>            
<ol>
    <li>Panggil <mark>global $db</mark></li>
    <li>Siapkan query anda <mark>$q = "SELECT * FROM mytable WHERE field = 'id'";</mark></li>
    <li>
        Panggil query ada menggunakan fungsi <mark>$db->query($q,2);</mark>.
        <br>
        Dimana argument kedua (dicontoh angka 2) melambangkan apakah query tersebut ada return nya.
        <p>
        <ul>
            <li>
                2 => return array of objects, digunakan sewaktu memanggil banyak entry
            </li>
            <li>
                1 => return single object, digunakan sewaktu memanggil 1 entry
            </li>
            <li>
                0 => not returning any object, but return boolean, true if query is well executed and false otherwise.
            </li>
        </ul>
        </p>
    </li>
</ol>
<p>
    Contoh lengkapnya sbb:
</p>
<pre>
class mainClass extends WebApps{
    public function <mark>product</mark>(){
        //contoh pengambilan data dari DB tanya penggunaan model class
        <mark>global $db;</mark>
        <mark>$q = "SELECT * FROM product ORDER BY product_name ASC";</mark>
        <mark>$arr = $db->query($q,2);</mark>
        ?>
        &lt;div class='container'>
        &lt;?
        //print the array
        <mark>foreach($arr as $prod){
            echo "&lt;div class='prod-item'>".$prod->product_name."&lt;/div>";
        }</mark>
        ?>
        &lt;/div>
        &lt;?
    }
}   
</pre>
         <?
    }

    public function sweb(){
        ?>
<p>
    Pembuatan static web sangat simple dengan Leap Framework.
</p>            
<p>
    Programmer hanya perlu untuk mengedit 3 file saja.
<ol>
    <li><b>include/access.php</b> untuk setup standar configuration</li>
    <li><b>themes/theme_name/skeleton.php</b> untuk perubahan desain</li>
    <li>membuat mainClass baru pada <b>/app/Logic/project_name/mainClass.php</b></li>
</ol>
</p>
<p>
    Contoh kedua bagian atas sudah dibahas pada masing-masing tutorial.
</p>
<p>
    Contoh mainClass Web Static sederhana :
</p>
<pre>
class mainClass extends WebApps{
    public function <mark>index</mark>(){
        //content start here
        ?>
        &lt;div class='container'>
        &lth1>our company&lt/h1>
         //text here
        &lt;/div>
        &lt;?
    }
    public function <mark>menu</mark>(){
        //menu akan dipanggil diskeleton.php
        ?>
        &lt;div class='menu-top'>
        menu1 menu2 menu3 menu4 menu5
        &lt;/div>
        &lt;?
    }
    public function <mark>contact_us</mark>(){
        //content start here
        ?>
        &lt;div class='container'>
        &lth1>contact us&lt/h1>
         //text here
        &lt;/div>
        &lt;?
    }
    public function <mark>about_us</mark>(){
        //content start here
        ?>
        &lt;div class='container'>
        &lth1>about us&lt/h1>
        //text here
        &lt;/div>
        &lt;?
    }
    public function <mark>product</mark>(){
        //content start here
        ?>
        &lt;div class='container'>
        &lth1>about us&lt/h1>
        //text here
        &lt;/div>
        &lt;?
    }
}     
</pre>
<p>
    Sekarang web anda sudah mempunyai 5 halaman status yang sudah bisa mempresentasikan perusahaan anda.
</p>
         <?
    }
     public function osfw(){
        ?>
<p>
    Pembuatan aplikasi web secara php old school dengan leap framework sangat berbeda.
</p>            
<p>
    Pada segmen ini akan ditampilkan beberapa contoh penyelesaian melalui old school vs leap framework.
</p>
<ol>
    <li>
        <b>Old School mengharuskan banyak include/require</b>
        <p>
            Pada web aplikasi dan tutorial di internet, normalnya semua file biasanya mengandung include/require, yang
            nantinya dengan semakin besar dan kompleknya aplikasi akan sangat susah untuk dimaintain.
            
        </p>
        <pre>
file <b>index.php</b> //old school
&lt;?php
//all 
require_once 'config.php';
require_once 'db.php';

require_once 'header.php';

//content start here
?>
&lt;div class='container'>
hello world
&lt;/div>
&lt;?
require_once 'footer.php';
?>      </pre>
        <p>
            Sedangkan dengan Leap Framework
        </p>
        <pre>
class mainClass extends WebApps{
    public function <mark>index</mark>(){
        //content start here
        ?>
        &lt;div class='container'>
        hello world
        &lt;/div>
        &lt;?
    }
}            
        </pre>
        <p>
            Inklusi config dan db akan diproses secara automatis dengan sistem OOP. 
            <br>
            Inklusi header dan footer akan dilakukan di skeleton.php.
        </p>
    </li>
    <li>
        <b>PHP Old School memerlukan banyak file.</b>
        <p>
            Karena php aslinya bersifat file based program, jadi tiap logic dari suatu program haruslah dibuatkan file tertentu.
            <br>
            Approach ini akan membuat sebuah project besar php sangat tidak rapi, karena masing-masing dari logic tersebut
            masih harus dibuatkan class MVC nya.
            <br>
            Approach Leap Framework adalah benar-benar mengkonversi semua request tanpa kecuali menjadi Class-Method based.
            Sehingga untuk mendefinisikan suatu Simple App Logic (static Website) mungkin hanya akan dibutuhkan 1 file saja.
            Dan para programmer memang hanya akan mengedit satu file saja selama proses pembuatannya.
        </p>
        <p>
            Contoh approach tradisional :
        </p>
        <pre>
file <b>index.php</b> //old school
&lt;?php
//all 
require_once 'config.php';
require_once 'db.php';

require_once 'header.php';

//content start here
?>
&lt;div class='container'>
&lt;a href="home.php">pindah ke home&lt;/a> //buat simple link
&lt;/div>
&lt;?
require_once 'footer.php';
?>      
<hr>
file <b>home.php</b> //old school
&lt;?php
//all 
require_once 'config.php';
require_once 'db.php';

require_once 'header.php';

//content start here
?>
&lt;div class='container'>
This is home
&lt;/div>
&lt;?
require_once 'footer.php';
?> 
<b>Dibutuhkan 2 file untuk menangani logic seperti diatas.</b>     
        </pre>
        <p>
            Contoh approach Leap :
        </p>
        <pre>
class mainClass extends WebApps{
    public function <mark>index</mark>(){
        //content start here
        ?>
        &lt;div class='container'>
        &lt;a href="home">pindah ke home&lt;/a> //buat simple link
        &lt;/div>
        &lt;?
    }
    public function <mark>home</mark>(){
        //content start here
        ?>
        &lt;div class='container'>
        This is home
        &lt;/div>
        &lt;?
    }
} 
<b>That's it, clean and simple</b>                       
        </pre>
    </li>
    <li>
        <b>Karena Old School membutuhkan banyak file serta banyak include/require, sangat sulit untuk memindahkan lokasi file jika logic suatu programm berubah.</b>
    </li>
</ol>
         <?
    }
}
