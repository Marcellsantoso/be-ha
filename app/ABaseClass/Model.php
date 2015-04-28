<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author User
 */
class Model extends Leap\Model\Model {
    public $default_read_coloms;

    /*
     * @return array of objects
     */
    public function getWhere ($whereClause, $selectedColom = "*")
    {
        global $db;
        $q = "SELECT {$selectedColom} FROM {$this->table_name} WHERE $whereClause";

        $muridkelas = $db->query($q, 2);
        $newMurid = array ();
        $classname = get_called_class();
        foreach ($muridkelas as $databasemurid) {

            $m = new $classname();
            $m->fill(toRow($databasemurid));
            $newMurid[] = $m;
        }

        return $newMurid;
    }

    public function loadToSession ($whereClause = '', $selectedColom = "*")
    {
        global $db;
        if ($whereClause != '') {
            $where = " WHERE " . $whereClause;
        }
        $q = "SELECT {$selectedColom} FROM {$this->table_name} $where";

        $_SESSION[get_class(this)] = $db->query($q, 2);
    }

    public function getFromSession ()
    {
        return $_SESSION[get_class(this)];
    }

    public function getWhereFromMultipleTable ($whereClause, $arrTables = array (), $selectedColom = "*")
    {
        global $db;
        //implode the tables
        if (count($arrTables) < 1) {
            die("please use normal getWhere");
        }
        foreach ($arrTables as $tableClassname) {
            $m = new $tableClassname();
            $imp[] = $m->table_name;
        }

        $implode = implode(",", $imp);

        $q = "SELECT {$selectedColom} FROM {$this->table_name},$implode WHERE $whereClause";

        $muridkelas = $db->query($q, 2);
        $newMurid = array ();
        $classname = get_called_class();
        foreach ($muridkelas as $databasemurid) {

            $m = new $classname();
            $m->fill(toRow($databasemurid));
            $newMurid[] = $m;
        }

        return $newMurid;
    }
}
