<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TutorialFWWeb_Crud
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TutorialFWWeb_Crud extends TutorialFWWeb{
    public function segment_crud(){
        $arrContent = array(
          "Concept" => new Portlet("TutorialFWWeb_Crud", "concept"),
          "Start" => new Portlet("TutorialFWWeb_Crud", "start"),
          "constraint" => new Portlet("TutorialFWWeb_Crud", "constraint"),
          "overwriteRead" => new Portlet("TutorialFWWeb_Crud", "overwriteRead"),
          "overwriteForm" => new Portlet("TutorialFWWeb_Crud", "overwriteForm")  
        );
        BootstrapUX::accordion($arrContent);
    }
    public function overwriteForm(){
        ?>
<p>
    Fungsi ini bertujuan sebagai hook untuk mengganti input dari add atau edit form.
</p>
<p>
    Biasanya berguna untuk mengeluarkan tipe input lain seperti foto, file, array select, dan object dari class lain.
</p>
<p>
    Method ini diinisiasi di SubClass Model. Tidak pada class CRUD nya.
</p>
<p>
    Contoh :
</p>
<pre>
class Video extends Model{
    public function overwriteForm ($return, $returnfull)
    {
        $return = parent::overwriteForm($return, $returnfull);

        $return['test_author'] = new \Leap\View\InputText("hidden","test_author", "test_author", Account::getMyID());
        $return['test_date'] = new \Leap\View\InputText("hidden","test_date", "test_date", leap_mysqldate());
        $return['test_color'] = new \Leap\View\InputText("color","test_color", "test_color", $this->test_color);
        $return['test_foto'] = new \Leap\View\InputFoto("test_foto", "test_foto", $this->test_foto);
        $return['test_file'] = new \Leap\View\InputFile("test_file", "test_file", $this->test_file);
        
        $acc = new Account();
        $acc->default_read_coloms = "admin_id,admin_nama_depan";
        $arrSementara = $acc->getAll();
        
        foreach($arrSementara as $ac){
            $arr[$ac->admin_id] = $ac->admin_nama_depan;
        }
        
        $return['test_sel'] = new \Leap\View\InputSelect($arr, "test_sel", "test_sel", $this->test_sel);
        return $return;
    }
}    
</pre>            
            <?
    }

    public function overwriteRead(){
        ?>
<p>
    Fungsi ini bertujuan sebagai hook untuk mengganti display dari data yang ada ditable.
</p>
<p>
    Biasanya berguna untuk mengeluarkan foto, file, array select, dan object dari class lain.
</p>
<p>
    Method ini diinisiasi di SubClass Model. Tidak pada class CRUD nya.
</p>
<p>
    Contoh :
</p>
<pre>
class Video extends Model{
    public function overwriteRead ($return)
    {

        $return = parent::overwriteRead($return);

        $objs = $return['objs'];
        foreach ($objs as $obj) {
                if (isset($obj->video_upload_preview)) {
                        $obj->video_upload_preview = \Leap\View\InputFoto::getAndMakeFoto($obj->video_upload_preview,
                                "video_upload_" . $obj->video_id);
                }
        }

        return $return;
    }
}    
</pre>
        <?
    }

    public function constraint(){
        ?>
<p>
    Method constraint/Pembatasan adalah cara untuk validasi user input. 
    Fungsi ini akan diinisiasi secara automatis setelah proses Edit dan Add pada CRUD form.
</p>
<p>
    Jika hasil mengandung error, form tidak akan disubmit dan errmsg akan dikembalikan sesuai dengan posisi input yang salah.
</p>
<p>
    Method ini diinisiasi di SubClass Model. Tidak pada class CRUD nya.
</p>
<p>
    Contoh:
</p>
<pre>
class Video extends Model{
    public function constraints ()
    {

            $err = array ();
            //check apakah video title kosong
            if (!isset($this->video_title)) {
                    $err['video_title'] = Lang::t('Video title cannot be empty');
            }        
            return $err;
    }
}    
</pre>
<p>
    Contoh tampilan jika ada error :
</p>
<p>
    <img src="<?=_SPPATH;?>app/BPlugin/TutorialFW/Mold/img/constraint.jpg" width="100%" />
</p>
         <?
    }

    public function start(){
     ?>
<p>
    Untuk memulai proses CRUD. Ikuti langkah-langkah dibawah ini :
</p>
<ol>
    <li>
        <b>Buat SubClass Model (seperti pada Tutorial Concept/Model)</b>
    </li>
    <li>
        <b>Buat Controller Class dimana CRUD process diinisiasi.</b>
        <p>
            Controller menyebabkan CRUD dapat diakses dari URL(Luar).
        </p>
        <pre>
//notice that methodname and the classname must be identical
public function <mark>Classname</mark> ()
    {
        //create the model object
        $cal = new <mark>Classname</mark>();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);
    }
        </pre>
    </li>
    <li>
        <b>Kalau menggunakan themes SPA e.g adminlte, masukan registor.</b>
        <pre>
//set menu format domain, menuname. menu url
Registor::registerAdminMenu("TopMenuName", "MenuName", "ClassName/MethodName");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("MenuName");            
        </pre>
    </li>
    <li>
        <b>Thats's it. Sekarang kita bisa mendefinisikan constraint, overwriteForm and overwriteRead.</b>
    </li>
</ol>
     <?   
    }

    public function concept(){
        ?>
<p>
    CRUD adalah sebuah plugin yang digunakan untuk memudahkan proses , Create, Read, Update and Delete. 
</p>
<p>
    Untuk sementara CRUD GUI hanya compatible dengan <mark>Single Page Application Themes</mark>.
</p>
<p>
    CRUD dengan multi page Site bisa dibuat dengan cara mengoverwrite openLw dengan fungsi document.location.
</p>
<p>
    Contoh : 
</p>
<pre>
    &lt;script&gt;
    
    function openLw(id,url,fade){
        if(url.indexOf("cmd=edit") < 0){
            
                document.location = url+"&vmode=front";
            
        }
        else{
            if(url.indexOf("EfiHome/Page") < 0){
                
            }else{
                console.log('in');
                var news = btoa(url);
                document.location = '<?=_SPPATH;?>EfiHome/redirect?news='+news;
            }
        }
    }
    &lt;/script&gt;
</pre>
         <?
    }
}
