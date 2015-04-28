<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TutorialFWWeb_Themes
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TutorialFWWeb_Themes extends WebService{
    public function segment_themes(){
        $arrContent = array(
          //"Theme" => new Portlet("TutorialFWWeb_Concept", "URLLocation"),
          "Template" => new Portlet("TutorialFWWeb_Themes", "Template"),  
          "skeleton.php" => new Portlet("TutorialFWWeb_Themes", "skeleton"), 
          "ThemeModifier" => new Portlet("TutorialFWWeb_Themes", "ThemeModifier"),  
        );
        BootstrapUX::accordion($arrContent);
    }
    public function ThemeModifier(){
        ?>
<p>
    Ini adalah Plugin untuk penggantian Theme secara Database. Selain itu theme juga dapat dimodifikasi bagian per bagian.
</p>            
<p>
    Bagian yang bisa dimodifikasi harus diregister melalui static function <mark>ThemeReg::mod($id,$default_value,$type);</mark>
</p>
<pre>
&lt;style>
    &lt;?         
    $bgitem = ThemeReg::mod("headbg", _SPPATH."images/grass-pattern.jpg","image"); 
    ?>
    background: #209b59 url('&lt;?=$bgitem;?>') repeat-x top left;
&lt;/style>
</pre>
         <?
    }

    public function skeleton(){
        ?>
<p>
    Skeleton.php ada file minimal dalam pembuatan theme.
</p>
<p>
    Anatomi skeleton adalah sbb:
</p>
<pre>
&lt;html>
&lt;head>
&lt;title>&lt;?=$title;?>&lt;/title>
&lt;?= $metaKey; ?>
&lt;?= $metaDescription; ?>

&lt;? $this->getHeadfiles(); ?>
&lt;/head>
&lt;body >
&lt;?= $content; ?>
&lt;/body>
&lt;/html>
</pre>
<p>
    Untuk fungsi-fungsi tambahan lain, seperti onLoad, bodyFirst, dll. Bisa didefinisikan menggunakan teknik extend.
</p>
<p>
    Untuk membuat theme, silahkan buat folder didalam /themes/, setelah itu create skeleton.php didalamnya.
    Anatomi skeleton.php minimal sesuai contoh diatas.
</p>
<p>
    Untuk penambahan file css dan javascript dapat melalui cara standar dengan bantuan _THEMEPATH maupun dengan
    bantuan class Mold::theme.
</p>
<h3>Skeleton.php custom</h3>
<p>
    Untuk membuat agar tampilan beberapa page bisa berubah drastis, programmer dapat membuat skeleton khusus untuk tiap
    class atau tiap fungsi yang ada di mainClass.
</p>
<p>
    Contoh : skeleton--index.php //artinya skeleton ini hanya berlaku untuk fungsi index di mainClass
    <br>skeleton--Murid.php // bisa berarti 2, 1 skeleton untuk class Murid(semua fungsi) atau skeleton untuk fungsi Murid di mainClass
</p>
<p>
    Jadi format penulisan skeleton custom adalah <mark>skeleton--classname.php</mark> atau <mark>skeleton--mainClassFunctioName.php</mark>
</p>

        <?
    }
    public function Template(){
        ?>
<p>
    Pengaturan visual diatur oleh class ini. Baik dari include theme. 
    Pengaturan _THEMEPATH. Pengisian title, meta, content dll.
</p>            
<p>
    Object dari Template merupakan $template, yang merupakan singleton, sehingga bisa di alter oleh tiap fungsi yang terlibat sebelum di print di screen.
</p>
         <?
    }
}
