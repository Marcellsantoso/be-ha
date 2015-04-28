<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Redirect
 * Kelas redirect bertugas membuat redirection menjadi einheitlich, ada 2 macam, normal (url) atau pakai js/ajax
 * redirect mendapat isi adalah action class
 *
 * @author ElroyHardoyo
 */
class Redirect {
    public static function firstPage ()
    {
        global $backEndClass;
        //echo $backEndClass;
        //die("Location:" . _BPATH .$backEndClass. "/home");
        header("Location:" . _BPATH .$backEndClass. "/home");
        exit();
    }

    public static function index ($str)
    {
        global $backEndClass;
        //die("Location:" . _BPATH .$backEndClass. "/index?msg=");
        header("Location:" . _BPATH .$backEndClass. "/index?msg=" . Lang::t($str));
        exit();
    }

    public static function loginFailed ()
    {
        global $backEndClass;
        //die("Location:" . _BPATH .$backEndClass. "index?msg=");
        header("Location:" . _BPATH .$backEndClass. "/index?msg=" . Lang::t("Wrong Credentials"));
        exit();
    }
}
