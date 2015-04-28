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
class ThemeModWeb extends WebService {

    public $arrActive = array("0"=>"inactive","1"=>"<b>active</b>");
    public function ThemeMod ()
    {
        //create the model object
        $cal = new ThemeMod();
        //send the webclass 
        $webClass = __CLASS__;

        //filter only for active theme
        $dir = ThemeItem::getTheme();
        $cal->read_filter_array = array("set_theme_id"=>$dir);
        
        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    
    

    public function select(){
        
        $dir    = './themes';
        $files1 = scandir($dir);
        //pr($files1);
        $arrThemes = array();
        //ThemeItem::emptyAll();
        foreach($files1 as $tname){
            if(!strstr($tname,".")){
                if($tname != "adminlte"){
                    $themeItem = new ThemeItem();
                    $themeItem->theme_dir = $tname;
                    $themeItem->save();
                    $arrThemes[] = $tname;
                    
                }
            }
        }
        //get All
        $themeItem = new ThemeItem();
        $arrThemes2 = $themeItem->getAll();
        $t = time();
        ?>
<table class="table">
    <thead>
    <tr>
        <th><?=Lang::t('Theme Name');?></th>
        <th><?=Lang::t('Status');?></th>
        <?/* <th><?=Lang::t('Preview');?></th>*/?>
        <th><?=Lang::t('Edit Colors');?></th>
    </tr>
    
    </thead>
    <tbody>
        <?
        foreach($arrThemes2 as $theme){
            if(in_array($theme->theme_dir, $arrThemes)){
                               
            ?>
        <tr>
            <td><?=$theme->theme_dir;?></td>
            <td>
                <? if(!$theme->theme_active){?>
                <select class="form-control" id="select_<?=$theme->theme_id;?>_<?=$t;?>">
                    <? foreach($this->arrActive as $num=>$h){?>
                    <option value="<?=$num;?>" <? if($theme->theme_active ==  $num)echo "selected";?>><?=$h;?></option>
                    <? } ?>
                </select>
                <? }else{
                echo $this->arrActive[$theme->theme_active];
                 } ?>
            </td>
            <!--<td>
                <button class="btn btn-default"><?=Lang::t('Preview');?></button>
            </td>-->
            <td>
              <?if($theme->theme_active){?>
                <button onclick="openLw('ThemeSetting','<?=_SPPATH;?>ThemeModWeb/ThemeMod?ti='+$.now(),'fade');" class="btn btn-default"><?=Lang::t('Edit Colors');?></button>
              <?}?>
            </td>
        </tr>
    <script>
        $("#select_<?=$theme->theme_id;?>_<?=$t;?>").change(function(){
           var slc =  $("#select_<?=$theme->theme_id;?>_<?=$t;?>").val();
           $.get("<?=_SPPATH;?>ThemeModWeb/activate?id=<?=$theme->theme_id;?>&active="+slc,function(data){
                console.log(data);
                if(data.bool){
                    lwrefresh('ThemeSelector');
                }else{
                    alert('<?=Lang::t('failed');?>');
                }
           },'json');
        });
        </script>
        <? } //if
        }?>
    </tbody>
</table>
        <?
    }
    public function activate() {
        //pr($_GET);
        $id = isset($_GET['id'])?addslashes($_GET['id']):die("NO ID");
        $active = isset($_GET['active'])?addslashes($_GET['active']):die("NO ID");
        $json = array();
        $json['bool'] = 0;
        if($active){
            ThemeItem::nonActiveAll();
        
            $tm = new ThemeItem();
            $tm->getByID($id);
            $tm->theme_active = $active;
            $tm->load = 1;
            $json['bool'] = $tm->save();
        }
        echo json_encode($json);
    }

}
