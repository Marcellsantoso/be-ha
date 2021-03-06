<?php
namespace Leap\Model;

use Leap\View\Lang;

/**
 * Description of Model
 * Model adalah kelas dari Objects e.g User, Account, Guru, Murid dll yang state dan value nya bisa berubah
 * oleh panggilan URL yang akan dikerjakan oleh Controller
 * Value dari Object2 ini sebagian diambil dari database
 *
 * @author ElroyHardoyo
 */
abstract class Model {

    //nama table di db
    public $table_name;

    //primary id
    public $main_id;

    //colom yang dipakai untuk query sql statt pakai '*'
    public $default_read_coloms;

    //insert str
    public $insertStr = array ();

    //load, artinya object ini di create dr db
    public $load;

    // loadDBColList dipakai waktu di CRUD, colom apa saja yang boleh di load
    public $loadDbColList = array ();

    //qid dipakai saat inset apakah unique insert id di return..
    public $qid;

    /*
     * default array yesno
     *
     */
    public $arrayYesNO = array("0"=>"No","1"=>"Yes");
    /*
     * read filter array
     */
    public $read_filter_array;
    /*
     * get One Object by its ID
     */

	public function __construct(){
		$this->default_read_coloms = str_replace(" ", "",$this->default_read_coloms);
		$this->coloumlist = str_replace(" ", "", $this->coloumlist);
	}

    public function save ($onDuplicateKey = 0)
    {
        //default insert adalah tanpa syarat, kalau mau ada syarat sebaiknya di filter dulu sebelum di insert
        // filternya pakai subclasse method save
        $colomlist = $this->getColumnlist();
        $insertStr = array ();
        $updateStr = array ();
        $mainValue = "";
        $useQID = 0;
        $load = (isset($this->load) ? addslashes($this->load) : 0);
        foreach ($colomlist as $colom) {
            //cek if use query id
            if ($colom->Extra == "auto_increment") {
                if (!$load) {
                    $useQID = 1;
                }
            }

            $field = $colom->Field;
            $post = (isset($this->{$field}) ? addslashes($this->{$field}) : '');
            /*if ($post == '') {
                continue;
            }*/
            if ($field == $this->main_id) {
                $mainValue = $post;
                $this->qid = $post;
                if ($colom->Extra == "auto_increment") {
                    continue;
                }
            }
            $insertStr[] = " {$field} = '$post' ";

            if ($field != $this->main_id) {
                $updateStr[] = " {$field} = '$post' ";
            }

        }
        $insertStrImp = implode(",", $insertStr);
        $updateStrImp = implode(",", $updateStr);

        //on duplicate key
        $onDuplicateKeyString = "";
        if ($onDuplicateKey) {
            $onDuplicateKeyString = " ON DUPLICATE KEY UPDATE $insertStrImp";
        }

        $q = "INSERT INTO {$this->table_name} SET $insertStrImp $onDuplicateKeyString";

        if ($load) {
            $q = "UPDATE {$this->table_name} SET $updateStrImp WHERE {$this->main_id} = '$mainValue' ";
        }

        global $db;
        //echo $q;
        //return 0,1 utk cek masuk ga hasilnya
        //use qid kalau id nya dibutuhkan
        if ($useQID) {
            $this->qid = $db->qid($q);

            return $this->qid;
        }

        return $db->query($q, 0);

    }

    /*
     * fill object properties automaticaly
     */

    protected function getColumnlist ()
    {
        if (!isset($this->table_name)) {
            Ausnahme::notFound();
        }
        //if(isset($this->loadDbColList))return $this->loadDbColList;
        $sql = "SHOW COLUMNS FROM {$this->table_name}";
        global $db;
        $arr = $db->query($sql, 2);

        return $arr;
    }

    /*
     * get list of coloms in database
     */

    public function insertPostDataToObject ()
    {
        //default insert adalah tanpa syarat, kalau mau ada syarat sebaiknya di filter dulu sebelum di insert
        // filternya pakai subclasse method save
        $colomlist = $this->getColumnlist();
        $insertStr = array ();
        $updateStr = array ();
        $mainValue = "";
        $load = (isset($_POST['load']) ? addslashes($_POST['load']) : 0);
        foreach ($colomlist as $colom) {
            $field = $colom->Field;
            $post = (isset($_POST[$field]) ? addslashes($_POST[$field]) : '');
            if ($post == '') {
                continue;
            }
            $insertStr[$field] = $post;
            $this->$field = $post;
        }
        $this->load = $load;
        $this->insertStr = $insertStr;
        $this->fill($insertStr);
        $this->loadDbColList = $colomlist;
    }

    /*
     * save all properties to database, automaticaly
     */

    public function fill (array $row)
    {
        // fill all properties from array
        foreach ($row as $num => $r) {
            $this->{$num} = $r;
        }
    }

    /*
     * Automaticaly get Post Data from $_POST, name hrs sesuai dengan property
     */

    public function delete ($id)
    {
        //$id = (isset($_GET['id'])?addslashes($_GET['id']):0);
        if (!isset($id)) {
            return 0;
        } else {
            if ($id < 0) {
                return 0;
            }
            if ($id == '') {
                return 0;
            }
        }
        //return 0,1 utk cek masuk ga hasilnya

        global $db;
        $q = "DELETE FROM {$this->table_name} WHERE {$this->main_id} = '$id'";

        //echo $q;
        return $db->query($q, 0);
    }

    /*
     * Delete row by ID
     */

    public function getJumlah ($clause = "")
    {
        global $db;

        //sambung where
        if ($clause != "") {
            $clause = "WHERE " . $clause;
        }

        $q = "SELECT count(*) as nr FROM {$this->table_name} $clause";
        $nr = $db->query($q, 1);

        return $nr->nr;
    }

    /*
     * get jumlah data dengan syarat tertentu
     */

    public function read ($perpage = 20)
    {
        global $db;
        $page = (isset($_GET['page']) ? addslashes($_GET['page']) : 1);
        $all = 0;
        if ($page == "all") {
            $page = 1;
            $all = 1;
        }
        $begin = ($page - 1) * $perpage;
        $limit = $perpage;
        // get columnlist filter
        $clms = (isset($_GET['clms']) ? addslashes($_GET['clms']) : '');
        if ($clms == "") {
            $clms = $this->default_read_coloms;
        }
        $clmsPlaceholder = $clms;
        $clms = $this->main_id . "," . $clms; // add main id to the filter
        $arrClms = explode(",", $clms);
        // searchh
        $searchdb = " ";
        $search = (isset($_GET['search']) ? addslashes($_GET['search']) : 0);

        $w = (isset($_GET['word']) ? addslashes($_GET['word']) : '');
        if ($search == 1 && $w != '') {
            $searchdb .= " WHERE ";
            foreach ($arrClms as $col) {

                //disini di filter...
                if(!array_key_exists($col, $this->read_filter_array))
                    $imp[] = " $col LIKE '%{$w}%' ";

            }
            $searchdb .= implode(" OR ", $imp);
            $searchdb .= " ";

        }
        //begin filter
        //edit by roy 2 des 2014
        $imp2 = array();
        if(count($this->read_filter_array)>0){
            foreach ($arrClms as $col) {
                if(array_key_exists($col, $this->read_filter_array))
                    $imp2[] = " $col = '".$this->read_filter_array[$col]."' ";
            }

            if($searchdb != " "){
                //ada search
                //kita kasi kurung dan kasi AND
                $searchdb = str_replace("WHERE ", "WHERE (", $searchdb);
                $searchdb = $searchdb.") AND ".implode(" AND ", $imp2);
            }
            else{
                //kalau masi kosong
                $searchdb = "WHERE ".implode(" AND ", $imp2);
            }

        }
        // get placeholder
        $placeholder = "";
        $p = array ();
        foreach ($arrClms as $col) {
            $p[] = Lang::t($col);
        }
        $placeholder = implode(",", $p);


        $t = time();
        $q = "SELECT count(*) as nr FROM {$this->table_name} $searchdb";
        $nr = $db->query($q, 1);
        //echo $q;echo "<br>";
        $sortdb = $this->main_id . " ASC";
        $sort = (isset($_GET['sort']) ? addslashes($_GET['sort']) : $sortdb);
        $sortdb = $sort;

        $beginlimit = "LIMIT $begin,$limit";
        if ($all) {
            $beginlimit = "";
            $perpage = $nr->nr;
        }

        //echo $searchdb;

        $q = "SELECT $clms FROM {$this->table_name} $searchdb ORDER BY $sortdb $beginlimit";
        //echo $q;

        //create return array
        $return['objs'] = $db->query($q, 2);
        $return['totalpage'] = ceil($nr->nr / $perpage);
        $return['perpage'] = $perpage;
        $return['page'] = $page;
        $return['sort'] = $sort;
        $return['search'] = $placeholder;
        $return['search_keyword'] = $w;
        $return['search_triger'] = $search;
        $return['coloms'] = $clmsPlaceholder;
        $return['colomslist'] = $this->coloumlist;
        $return['main_id'] = $this->main_id;
        $return['classname'] = get_class($this);

        $export = (isset($_GET['export']) ? addslashes($_GET['export']) : 0);
        if ($export) {
            $this->exportIt($return);
        }

        return $return;
    }

    /*
     * CRUD READ includes read, getByID, fill, save, export As Excel
     */

    public function exportIt ($return)
    {
        $filename = $return['classname'] . "_" . date('Ymd') . ".xls";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");
        $flag = false;

        foreach ($return['objs'] as $key => $obj) {

            foreach ($obj as $name => $value) {
                echo Lang::t($name) . "\t";
            }
            break;
        }
        print("\n");
        foreach ($return['objs'] as $key => $obj) {

            foreach ($obj as $name => $value) {
                echo $value . "\t";
            }
            print("\n");
        }
        exit;
    }

    /*
     * export table as excel
     */

    public function createForm ()
    {

        $return = array ();
        //load data kalau ada id yang dikirim..
        $return['load'] = 0;
        $id = (isset($_GET['id']) ? addslashes($_GET['id']) : 0);
        if ($id) {
            $this->getByID($id);
            $return['load'] = 1;
        }
        $return['classname'] = get_class($this);
        $return['id'] = $this;
        $return ['colomlist'] = $this->getColumnlist();
        $return['colomlistUI'] = $this->colomUI($return);
        $return ['formColoms'] = $this->overwriteForm($return['colomlistUI'], $return);
        $return['method'] = "post";

        return $return;
    }

    /*
     * fungsi untuk createForm load data yang diperlukan, cek constraint, action dll
     */

    public function getByID ($id,$readcoloums = "*")
    {
        global $db;
        $q = "SELECT $readcoloums FROM {$this->table_name} WHERE {$this->main_id} = '$id'";
        $obj = $db->query($q, 1);
        $row = toRow($obj);
        $this->fill($row);
        $this->load = 1;
    }

    /*
     * Crud Helper Function
     */

    public function colomUI ($return)
    {
        $new = array ();
        foreach ($return['colomlist'] as $colom) {

            if ($colom->Extra == "auto_increment" && !$return['load']) {
                continue;
            }
            if ($colom->Type == "timestamp") {
                continue;
            }

            $exp = explode("(", $colom->Type);
            $val = $colom->Field;
            $new[$colom->Field] = new \Leap\View\InputText("text", $colom->Field, $colom->Field, $this->{$val});

            //cek if Primary
            $isKey = (($colom->Key == "PRI") ? 1 : 0);
            if ($isKey && $return['load']) {
                $new[$colom->Field]->setReadOnly();
            }

        }

        $new["load"] = new \Leap\View\InputText("hidden", "load", "load", $return['load']);

        return $new;
    }

    /*
     * fungsi pas cek insert
     */

    public function overwriteForm ($return, $returnfull)
    {
        return $return;
    }

    /*
     * fungsi untuk ezeugt select/checkbox
     *
     */

    public function constraints ()
    {
        $err = array ();

        return $err;
    }

    /*
     * untuk overwrite yang dikeluarkan pas read item
     */

    public function overwriteRead ($return)
    {
        return $return;
    }

    /*
     * get name return admin nama depan kl ga ada return nama depan
     */
    public function getName ()
    {
        $nama = "Please Specify getName Function in " . get_called_class();

        return $nama;
    }

    /*
     * return all no where
     */
    public function getAll ($sort = "", $limit = "")
    {
        global $db;
        $q = "SELECT {$this->default_read_coloms} FROM {$this->table_name} $sort $limit";
        $arr = $db->query($q, 2);
        $classname = get_called_class();
        $newMurid = array();
        foreach ($arr as $databasemurid) {

            $m = new $classname();
            $m->fill(toRow($databasemurid));
            $newMurid[] = $m;
        }

        return $newMurid;
    }

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
    public function truncate(){
        global $db;
        $q = "TRUNCATE TABLE {$this->table_name}";
        return $db->query($q,0);
    }
    public function printColumlistAsAttributes(){
        $colomlist = $this->getColumnlist();

        pr($colomlist);

        foreach($colomlist as $cc){
           $txt .= 'public $'.$cc->Field.'; <br>';
           $imp[] = $cc->Field;
        }
        $all = implode(",",$imp);
        echo '//Default Coloms for read<br>
    public $default_read_coloms = "'.$all.'";
    <br><br>
    //allowed colom in CRUD filter<br>
    public $coloumlist = "'.$all.'";<br>';
        echo $txt;
    }
}