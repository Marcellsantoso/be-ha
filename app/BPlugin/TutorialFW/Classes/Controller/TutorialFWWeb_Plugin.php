<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TutorialFWWeb_Plugin
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TutorialFWWeb_Plugin extends WebService{
    public function segment_plugin(){
        $arrContent = array(
          "AccountLogin" => new Portlet("TutorialFWWeb", "noContent"),
          "Crud" => new Portlet("TutorialFWWeb", "noContent") 
        );
        BootstrapUX::accordion($arrContent);
    }
}
