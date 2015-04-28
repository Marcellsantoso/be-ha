<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TutorialFWWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TutorialFWWeb extends WebService{
    
    public function index(){
        $_GET['t'] = time();
        //BootstrapUX::pageHeader("Tutorial Framework");
        ?>
        <h1>Leap FW Tutorial</h1>    
        <script>
            function changeCanvas_<?=$_GET['t'];?>(url){
                $("#canvas_<?=$_GET['t'];?>").load(url);
            }
        </script>
        <?
        
        $arrLeft = array(
           new Portlet("TutorialFWWeb","segment_menu")
           
           );
       $arrRight = array(
           new Portlet("TutorialFWWeb","blankCanvas")
           
           );
       BootstrapUX::twoColoums($arrLeft, $arrRight,2,10);
       
       
        
    }
    public function blankCanvas(){
        ?>
        <div id="canvas_<?=$_GET['t'];?>"></div>
        <?
    }
    public function noContent(){
        
    }

    public function segment_menu(){
        $arrList = array(
           "changeCanvas_".$_GET['t']."('"._SPPATH."TutorialFWWeb_Installation/segment_installation');"=> "installation",
           "changeCanvas_".$_GET['t']."('"._SPPATH."TutorialFWWeb_Concept/segment_concept');"=> "concept",
           "changeCanvas_".$_GET['t']."('"._SPPATH."TutorialFWWeb_Crud/segment_crud');"=> "crud",
           "changeCanvas_".$_GET['t']."('"._SPPATH."TutorialFWWeb_Utility/segment_utility');"=> "utility",
           "changeCanvas_".$_GET['t']."('"._SPPATH."TutorialFWWeb_Themes/segment_themes');"=> "themes",           
           "changeCanvas_".$_GET['t']."('"._SPPATH."TutorialFWWeb_Start/segment_start');"=> "start",
           "changeCanvas_".$_GET['t']."('"._SPPATH."TutorialFWWeb_Examples/segment_example');"=> "example",
           "changeCanvas_".$_GET['t']."('"._SPPATH."TutorialFWWeb_Plugin/segment_plugin');"=> "plugins"            
            );
        BootstrapUX::listGroupOpenLw($arrList);
    }
    

    
   
   
    
    
}
