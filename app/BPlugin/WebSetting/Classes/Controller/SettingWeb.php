<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb
 *
 * @author User
 */
class SettingWeb extends WebService {


    public function efiwebsetting ()
    {
        //create the model object
        $cal = new Efiwebsetting();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

}
