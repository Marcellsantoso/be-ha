<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author User
 */
class BackEnd extends WebApps {
    /*
     * index
     */
    function index(){
        $acc = new AccountLogin();
	$acc->loginForm();
    }
    function ses(){
        pr($_SESSION);
    }
    /*
    * login webview
    */
    function login ()
    {
        /*
         * login logic
         */
        $acc = new AccountLogin();
        $acc->login_hook = array (
              //  "PortalHierarchy" => "getSelectedHierarchy",
              //  "NewsChannel"     => "loadSubscription",
                "Role"            => "loadRoleToSession"
        );
        
        $acc->process_login();
    }

    var $access_home = "admin";
    function home ()
    {
        //echo "in";
        Registor::redirectOpenLW("BackEnd", "BackEnd/homeLoad");
    }
    
    /*
    * Web View For logout
    */
    function logout ()
    {
            $acc = new AccountLogin();
            $acc->process_logout();
    }
    /*
     * Default Landing Page as User Got Into admin site
     */
    function homeLoad ()
    {
        //Mold::both("mainmenu");
        exit();
    }

    function p404 ()
    {

        echo $_GET['msg'];
        die();
    } 
}
