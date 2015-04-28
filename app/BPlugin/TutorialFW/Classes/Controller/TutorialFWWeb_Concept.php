<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TutorialFWWeb_Concept
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TutorialFWWeb_Concept extends TutorialFWWeb{
    public function segment_concept(){
        $arrContent = array(
          "URL Processing and Logic" => new Portlet("TutorialFWWeb_Concept", "URLLocation"),
          "MainClass" => new Portlet("TutorialFWWeb_Concept", "MainClass"),
          "AutoLoad" => new Portlet("TutorialFWWeb_Concept", "autoload"),    
          "Path" => new Portlet("TutorialFWWeb_Concept", "Path"),  
          "Singleton" => new Portlet("TutorialFWWeb_Concept", "Singleton"),             
          "Model" => new Portlet("TutorialFWWeb_Concept", "Model"),
          "View" => new Portlet("TutorialFWWeb_Concept", "View"),
          "Controller" => new Portlet("TutorialFWWeb_Concept", "Controller"),
          
          
             
        );
        BootstrapUX::accordion($arrContent);
    }
    public function URLLocation(){
        ?>
        
        <p>
            Alih-alih metode lama yang menggunakan file untuk mengarahkan panggilan URL request.
        </p>
        <p>
            Framework Leap menggunakan <mark>URL to Class-Method parsing.</mark>
        </p>
        <p>
        <pre>URL : http://www.yourdomain.com/page/home</pre>
        URL diatas mengindikasikan panggilan terhadap Object dari class page dengan method home.
        <pre>
class <mark>Page</mark> extends WebApps{
    
    public function <mark>home</mark>(){
        echo "hello world";
    }
}
        </pre>
        Yang pada kasus diatas akan mengeluarkan String "hello world" pada Web.
        </p>
        <p>
            <b>Question #1 : Jadi kalau begitu, nanti semua class yang saya buat akan dapat diakses dari luar/URL donk?</b>
            <p>
                Tidak, untuk menghindari itu kami membuat 2 BaseClass yang dapat kita pergunakan untuk mengindikasikan bahwa
                class tersebut dapat diakses dari luar.
    
            </p>
            <p>
                Coba perhatikan phrase berikut <pre>class Page <mark>extends WebApps</mark></pre>
                Menggunakan metode extends pada PHP OOP kita dapat membatasi panggilan URL terhadap suatu class.
            </p>
            <p>
                BaseClass yang menunjukan bahwa suatu class dapat diakses dari URL adalah
                <ol>
                    <li>
                        <b>WebApps</b>
                        <p>
                            SubClass dari WebApps akan dapat diakses dari URL dan akan mereturn full page content 
                            (Themes dan Method Content).
                        </p>
                    </li>
                    <li>
                        <b>WebService</b>
                        <p>
                            SubClass dari WebService akan dapat diakses dari URL dan akan hanya mereturn Content dari method yang dipanggil
                            tanpa mereturn theme/design dari Web.(biasa dipakai dalam metode ajax/webservice).
                        </p>
                    </li>
                </ol>
            </p>
        </p>
        <p>
            <b>Question #2 : Bagaimana dengan GET dan POST request?</b>
            <p>
                Normal GET dan POST dapat dipakai didalam Class.
            <pre>URL : http://www.yourdomain.com/page/home<mark>?id=10</mark></pre>
                Dapat diambil melalui methode get biasa didalam class.
        <pre>
class Page extends WebApps{
    
    public function home(){
        <mark>$id = $_GET['id'];</mark>
        //do something with the id
    }
}
        </pre>                
            </p>
        </p>
        
        <p>
            <b>Question #3 : Bagaimana jika kita ingin memberi argument kepada method yang dipanggil?</b>
            <p>
                Argument dapat diberikan melalui URL. Contoh :
            <pre>URL : http://www.yourdomain.com/page/home<mark>/1/judul_artikel</mark></pre>
            Penambahan <mark>/1/judul_artikel</mark> akan diteruskan menjadi argument dari metode <mark>home</mark>.
        <pre>
class Page extends WebApps{
    
    public function home(<mark>$args</mark>){ //pertama kita tambahkan variabel untuk contain argument
        //argument yang dikirim akan diubah menjadi array, 
        //jadi kita hanya perlu mendefinisikan 1 buah variable argument saja
        //methode pengkorversian array menjadi variabel ada banyak. 
        //boleh pakai yang mana saja, disini kita pakai list
        <mark>list($id,$judul) = $args;</mark>

        //do something with the id and judul
    }
}
        </pre>                
            </p>
        </p>
        <p>
            <mark>URL untuk MainClass sedikit berbeda concept dengan URL biasa. Konsep dapat dipelajari di Tutorial 
                Bagian MainClass</mark>
        </p>
        <?
    }
    public function MainClass(){
        ?>
        <p>
            mainClass adalah Class utama, where all programs start. Atau kalau secara klasik PHP 
            mainClass menunjukan <mark>index page</mark>. 
        </p>
        <p>
            Kalau di Java, mainClass adalah seperti class dimana terdapat <mark>"public static void main([]args)"</mark>.
        </p>
        <p>
            mainClass harus didefinisikan manually di <mark>include/access.php</mark>, lihat tutorial bagian 
            <b>Installation/access.php</b>
        </p>
        <pre>
//main class MUST BE subclass of WebApps
$mainClass = <mark>"Leap"</mark>; //main class for your Apps, kalau di java, class dimana 'public void main' berada        
        </pre>    
        <p>
            <b>Hal-hal yang harus diperhatikan dalam pembuatan mainClass</b>
            <ol>
                <li>
                    Nama dari mainClass adalah bebas, selama tidak ada konflik nama dengan kelas lainnya.
                </li>
                <li>
                    mainClass harus merupakan <mark>SubClass dari WebApps</mark>.
                </li>
                <li>
                    mainClass harus mempunyai method <mark>index</mark>, yang akan menjadi starting point Web Apps.
                </li>
            </ol>
            
        </p>
        <pre>
//sebagai contoh kita pakai mainClass = Leap
class <mark>Leap</mark> extends WebApps{
    
    public function <mark>index</mark>(){ 
        echo  "this is where all starts";
    }
}
        </pre>  
        <p>
            <b>URL untuk panggilan mainClass hanya membutuhkan 1 parameter saja, yaitu parameter method</b>
        <p>
            Parameter Class tidak perlu dituliskan. Ini membuat panggilan sbb mungkin :
            
        <pre>URL : http://www.yourdomain.com/<mark>index</mark></pre>
        <pre>URL : http://www.yourdomain.com/<mark>Leap/index</mark></pre>
        <pre>URL : http://www.yourdomain.com/</pre>
        
            Ketiga panggilan diatas akan memanggil method yang sama, yaitu index dari mainClass Leap.
        </p>
        </p>
        <? 
        $html = "Panggilan URL terhadap mainClass tidak bisa menggunakan metode arguments (lihat Tutorial URL Question #3).
        Karena akan menyebabkan konflik dengan panggilan Class-method yang biasa.";
        BootstrapUX::alert($html, 0); 
    }

    public function autoload(){
        ?>
        <p>
            Leap Framework menggunakan dua macam autoloader.
        </p>        
        
        <ol>
            <li>
                <b>SplClassLoader</b>
                <p>
                    SplClassLoader dibuat oleh <a href="http://www.php-fig.org/psr/psr-0/" target="_blank">PHP-FIG</a>
                    untuk menjadikan PHP seperti bahasa OOP lainnya mempunyai standar untuk autoload.
                </p>
                <p>
                    Di framework Leap, class ini berfungsi untuk meng-autoload classes dari core-framework <mark>/framework</mark> dengan namespace <mark>/Leap</mark>.
                </p>
            </li>
            <li>
                <b>RecursiveDirectoryIterator</b>
                <p>
                    RecursiveDirectoryIterator menggunakan include_once stadard yang secara recursive mencari Classes untuk diload.
                </p>
                <p>
                    Di framework Leap, class ini berfungsi untuk meng-autoload classes dari <mark>/app</mark>.
                </p>
                <p>
                    Autoload ini diperlukan, karena untuk menjaga kedinamisan kita dalam mencapai "URL to Class-method" Coversion.
                </p>
                <p>
                    Karena Classes dari fungsi SplClassLoader tidak bisa berfungsi didalam (is_a() php function) sebelum object dari Class itu didefinisikan.
                </p>
            </li>
        </ol>
        
        <?
    }
    public function Path(){
        ?>
        <p>
            Seringkali developer PHP kesulitan dalam menentukan path dalah membuat link atau menentukan img src.
        </p>        
        <p>
            Leap Framework mempunyai standar Path yang memudahkan para programmer dalam membuat link.
            Semua path Leap FW berbentuk PHP Constant.
        </p>
        <ol>
            <li>
                <b>_SPPATH</b>
                <p>
                    _SPPATH, adalah path standard untuk memulai suatu panggilan URL. 
                    _SPPATH berfungsi untuk menormalisasi panggilan ke folder terdepan dari suatu Web URL.
                <pre>&lt;a href="&lt;?_SPPATH;?&gt;page/home"&gt;Home&lt;/a&gt;</pre>
                akan melakukan panggilan ke <mark>page/home</mark>.
                </p>
            </li>
            <li>
                <b>_BPATH</b>
                <p>
                    _BPATH, adalah path absolute standard untuk memulai suatu panggilan URL.(contain http://www.yourdomain.com)                     
                <pre>&lt;a href="&lt;?_BPATH;?&gt;page/home"&gt;Home&lt;/a&gt;</pre>
                akan melakukan panggilan ke <mark>http://www.yourdomain.com/page/home</mark>.
                </p>
            </li>
            <li>
                <b>_THEMEPATH</b>
                <p>
                    _THEMEPATH, adalah path yang menunjuk ke theme yang aktif.                     
                <pre>&lt;img src="&lt;?_SPPATH._THEMEPATH;?&gt;images/logo.png" /&gt;</pre>
                akan melakukan panggilan ke <mark>/themes/nama_theme_aktif/images/logo.png</mark>.
                </p>
            </li>
            <li>
                <b>_PHOTOPATH</b>
                <p>
                    _PHOTOPATH, adalah path filesystem untuk melakukan process upload/saving files. (di inisiasi di access.php)   
                    <br>Contoh pemakaian :
                <pre>
                    
// Generate filename
$filename = md5(mt_rand()) . '.jpg';

// Read RAW data
$data = file_get_contents('php://input');

// Read string as an image file
$image = file_get_contents('data://' . substr($data, 5));

// Save to disk
if (!file_put_contents(_PHOTOPATH . $filename, $image)) {
    header('HTTP/1.1 503 Service Unavailable');
    exit();
}
                </pre>
                
                </p>
            </li>
            <li>
                <b>_PHOTOURL</b>
                <p>
                    _PHOTOURL, adalah path relative menunjuk ke folder penyimpanan foto. (di inisiasi di access.php)                     
                <pre>&lt;img src="&lt;?_SPPATH._PHOTOURL;?&gt;1.png" /&gt;</pre>
                akan melakukan panggilan ke <mark>/lokasi_ke_folder_foto/1.png</mark>.
                </p>
            </li>
        </ol>
        
        <?
    }
    public function Singleton(){
        ?>
        <p>
            Ada beberapa singleton yang auto-generated tiap apps dipanggil.
        </p>        
        
        <ol>
            <li>
                <b>$db</b>
                <p>
                    $db adalah object singleton dari class Db() yang berfungsi untuk melakukan query.
                </p>
                <p>
                <pre>
//how to use inside a function
function home(){
    //get global variable database
    global $db;
    $q = "YOUR DB QUERY";
    $arr = $db->query($q,2);

    //now you can process the $arr array of objects
}                    
                </pre>
                </p>
            </li>
            <li>
                <b>$template</b>
                <p>
                    $template adalah object singleton dari class Template() yang berfungsi untuk melakukan hook pada tampilan sebelum diprint ke skeleton.
                </p>
                <p>
                <pre>
//how to use inside a function
function home(){
    //get global variable template
    global $template;
    $template->title = "Website Home"; //change the &lt;title&gt; element

}                    
                </pre>
                </p>
            </li>
            <li>
                <b>$init</b>
                <p>
                    $init adalah object singleton dari class Init() yang berfungsi untuk menyimpang dan menjalankan configurasi awal framework.
                </p>
                <p>
                    Semua process framework diawali dari class Init();
                </p>
                <?
                        BootstrapUX::alert("Tidak disarankan untuk meng-alter \$init.php, karena dapat mempengaruhi logic dari framework.", 0);
                ?>
            </li>
        </ol>
        
        <?
    }
    
    public function Model(){
        ?>
        <p>
            Model adalah BaseClass yang menangani hubungan dengan <mark>layer persistent atau database.</mark>            
        </p> 
        <p>
            Semua koneksi ke database diharuskan melalui subclass dari model.
        </p>
        <p>
            Pemakaian Model di awali dengan deklarasi Subclass seperti contoh dibawah ini:
        </p>
        <pre>
 class <mark>TestDemo extends Model</mark>{
    <mark>//Nama Table</mark>
    public $table_name = "test__demo";  
    
    <mark>//Primary</mark>
    public $main_id = 'test_id';
    
    <mark>//Default Coloms for read</mark>
    public $default_read_coloms = 'test_id,test_foto,test_name,test_date,test_color,test_author,test_file,test_sel';
    
    <mark>//allowed colom in CRUD filter</mark>
    public $coloumlist = 'test_id,test_foto,test_name,test_date,test_color,test_author,test_file,test_sel';
    
    public $test_id; <mark>//pencerminan colom test_id di database</mark>
    public $test_foto; <mark>//pencerminan colom test_foto di database</mark>
    public $test_name; <mark>//pencerminan colom test_name di database</mark>
    public $test_date; <mark>//pencerminan colom test_date di database</mark>
    public $test_color; <mark>//pencerminan colom test_color di database</mark>
    public $test_author; <mark>//pencerminan colom test_author di database</mark>
    public $test_file; <mark>//pencerminan colom test_file di database</mark>
    public $test_sel; <mark>//pencerminan colom test_sel di database</mark>
 }           
        </pre>   
        <p>
            Class TestDemo tersebut mencerminkan database dibawah ini :
        <pre>

CREATE TABLE IF NOT EXISTS `test__demo` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `test_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `test_date` datetime NOT NULL,
  `test_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `test_author` int(11) NOT NULL,
  `test_foto` varchar(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'foto',
  `test_file` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `test_sel` int(11) NOT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
            
        </pre>
        </p>
        <p>
            By default setelah itu kita bisa memakai object dari TestDemo untuk melakukan panggilan ke database. 
        </p>
        <p>
            Hasil dari panggilan tersebut akan automatis dikonversi sebagai object dari TestDemo dengan semua attribute terisi.
        </p>
        <p>
            Contoh :
        </p>
        <pre>
function home(){
    <mark>$td = new TestDemo();</mark>
    <mark>$td->getById(5);</mark> //akan mengambil test demo object dengan ID = 5
    <mark>echo $td->test_name;</mark> //akan mengeprint isi dari attribute test_name pada object $td
}       </pre>
        <h3>
            Berikut adalah method dari Model Class yang dapat dipakai pada SubClass
        </h3>
        
        <ol>
            <li>
                <b>getByID</b>
                <pre>getByID ($id,$readcoloums = "*")</pre>
                <p>
                    akan mengisi attributes object yang memanggil dengan hasil yang diterima dari database.
                </p>
                <p>
                    Pengaturan jenis coloums dapat dilakukan melalui variable $readcoloums yang by default diisi oleh value *.
                </p>
            </li>
            <li>
                <b>getAll</b>
                <pre>getAll ($sort = "", $limit = "")</pre>
                <p>
                    Akan mereturn array dari objects bertipe subclass.
                </p>
                <p>
                    Pengaturan sort dapat dilakukan melalui variable $sort yang by default diisi oleh value "".
                </p>
                <p>
                    Pengaturan limit dapat dilakukan melalui variable $limit yang by default diisi oleh value "".
                </p>
            </li>
            <li>
                <b>getWhere</b>
                <pre>getWhere ($whereClause, $selectedColom = "*")</pre>
                <p>
                    Akan mereturn array dari objects bertipe subclass dengan syarat tertentu.
                </p>
                <p>
                    Pengaturan jenis coloums dapat dilakukan melalui variable $selectedColom yang by default diisi oleh value *.
                </p>
            </li>
            <li>
                <b>getJumlah</b>
                <pre>getJumlah ($clause = "")</pre>
                <p>
                    Akan mereturn jumlah dari entries subclass, bisa dengan ataupun tanpa syarat tertentu.
                </p>
                
            </li>
            <li>
                <b>getColumnlist</b>
                <pre>getColumnlist ()</pre>
                <p>
                    Akan mereturn coloumlist dari database.
                </p>               
            </li>
            <li>
                <b>fill</b>
                <pre>fill (array $row)</pre>
                <p>
                    Mengisi attribute dari query database.
                </p>               
            </li>
            <li>
                <b>save</b>
                <pre>save ($onDuplicateKey = 0)</pre>
                <p>
                    Menyimpan object ke database beserta semua attributenya.
                </p>
                <pre>
function addMember(){
    <mark>$td = new TestDemo();</mark>
    <mark>$td->test_name = "hello";</mark> //isi attribute test_name dengan string "hello"
    <mark>$td->test_author = 1;</mark> //isi attribute test_author dengan int 1
    <mark>$id =$td->save();</mark> //save dan $id adalah kembalian primary ID nya, hanya berlaku juga ID auto increment
}       </pre>
                <p>
                    Kalau $onDuplicateKey = 1, maka akan dijalankan command <mark>ON DUPLICATE KEY UPDATE</mark>
                    jadi akan auto_update, digunakan jika ID bukan auto increment
                </p>
                <p>
                    Contoh fungsi update :
                </p>
                <pre>
function updateMember($id){
    <mark>$td = new TestDemo();</mark>
    <mark>$td->getById($id);</mark>
    <mark>$td->test_name = "hello";</mark> //isi attribute test_name dengan string "hello"
    <mark>$td->save();</mark> //update entry
}       </pre>
            </li>
            <li>
                <b>delete</b>
                <pre>delete ($id)</pre>
                <p>
                    Menghapus entry dari database dengan ID = $id.
                </p>  
                <pre>
function deleteMember($id){
    <mark>$td = new TestDemo();</mark>
    <mark>$td->delete($id);</mark> //delete entry
}       </pre>
            </li>
            <li>
                <b>loadToSession</b>
                <pre>loadToSession ($whereClause = '', $selectedColom = "*")</pre>
                <p>
                    Memasukan array hasil tarikan database ke SESSION. Biasa dipakai sebagai Hook sewaktu Login Process.
                </p>  
                <pre>
function loadMember(){
    <mark>$td = new TestDemo();</mark>
    <mark>$td->loadToSession();</mark> //load to sessions
}       </pre>
                <p>
                    $whereClause untuk membatasi pengambilan data dengan clausal tertentu.
                </p>
                <p>
                    $selectedColom untuk membatasi jenis coloums yang diambil.
                </p>
            </li>
            <li>
                <b>getFromSession</b>
                <pre>getFromSession ()</pre>
                <p>
                    Return array object dari Session (see loadToSession).
                </p>               
            </li>
            <li>
                <b>getWhereFromMultipleTable</b>
                <pre>getWhereFromMultipleTable ($whereClause, $arrTables = array (), $selectedColom = "*")</pre>
                <p>
                    Return array dari gabungan beberapa table disimpan dalam bentuk Class yang dipanggil.
                </p>
                <pre>
function getMultiple($id){
    //contoh ini adalah mengambil data murid dan data account terhadap satu ID $id
    <mark>$td = new Murid();</mark>
    <mark>$acc = new Account();</mark>
    $arrTables = array($acc->table_name);
    <mark>$arr = $td->getWhereFromMultipleTable("account_id = murid_id AND murid_id = '$id'",$arrTables);</mark> //multiple table
}               </pre>                
            </li>
        </ol>
        
        
         <?
         BootstrapUX::alert("Automatisasi CRUD dapat dilihat dibagian CRUD", 3);
    }
    
    public function View(){
    ?>
        <p>
            View adalah sebuah Interface yang berguna sebagai container dari Class Html, 
            dimana class Html berguna untuk mengautomatisasi pembuatan design.
        </p>  
        <p>
            Notable SubClasses
        </p>
        <ol>
            <li>Html</li>
            <li>Form</li>
            <li>Ajax</li>
            <li>InputText</li>
            <li>InputTextArea</li>
            <li>InputSelect</li>
            <li>InputFoto</li>
            <li>InputFile</li>
            <li>InputFileVideo</li>
        </ol>
    <?    
    }
    
    public function Controller(){
        ?>
        <p>
            Controller adalah sebuah Interface yang berguna sebagai container dari Class WebApps dan WebService, 
            dimana interface ini merupakan yang menentukan apakah suatu class bisa diakses lewat URL.
        </p>  
        <p>
            SubClasses
        </p>
        <ol>
            <li>WebApps</li>
            <li>WebService</li>
            
        </ol>
    <? 
    }
}
