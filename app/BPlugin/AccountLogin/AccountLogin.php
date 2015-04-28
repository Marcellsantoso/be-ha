<?php


class AccountLogin {
    public $login_hook = array ();

    function loginForm ()
    {
        //check apakah ada cookie untuk remember
        Auth::indexCheckRemember();
        if (Auth::isLogged()) { // kl sukses login pakai cookie
            //load school setting
            //$ss = new Schoolsetting();
            //$ss->loadToSession();
            Hook::processHook($this->login_hook);
            Account::setRedirection();
        }
        //kalau tidak ada keluarkan loginform
        Mold::plugin("AccountLogin", "loginform");
    }

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
            //load school setting
            // $ss = new Schoolsetting();
            // $ss->loadToSession();
            //redirect
            //Account::setRedirection ();
            Hook::processHook($this->login_hook);
            Redirect::firstPage();
        } else {
            Redirect::loginFailed();
        }
    }

    function process_logout ()
    {
        Auth::logout();
    }
}
