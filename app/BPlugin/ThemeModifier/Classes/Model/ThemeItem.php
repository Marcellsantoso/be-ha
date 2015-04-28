<?php

/**
 * Description of ThemeItem
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class ThemeItem extends Model{
    //Nama Table
    public $table_name = "sp_theme__item";  
    
    //Primary
    public $main_id = 'theme_id';
    
    //Default Coloms for read
    public $default_read_coloms = 'theme_id,theme_name,theme_dir,theme_active';
    
    //allowed colom in CRUD filter
    public $coloumlist = 'theme_id,theme_name,theme_dir,theme_active';
    
    public static function nonActiveAll(){
        global $db;
        $hh = new ThemeItem();
        $q = "UPDATE {$hh->table_name} SET theme_active = 0";
        $db->query($q,0);
    }
    public static function emptyAll(){
        global $db;
        $hh = new ThemeItem();
        $q = "TRUNCATE {$hh->table_name}";
        $db->query($q,0);
    }
    public static function getTheme(){
        global $db;
        $hh = new ThemeItem();
        $q = "SELECT theme_dir FROM {$hh->table_name} WHERE theme_active = 1 LIMIT 0,1";
        $obj = $db->query($q,1);
        return $obj->theme_dir;
    }
}     