<?php
/**
 * Description of ModelPortalContent
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class ModelPortalContent extends Model{
    public $date_start;
    public $date_end;
    public $tag;
    public $date_post;
    public $date_update;
    /*
    * fungsi untuk ezeugt select/checkbox
    *
    */
    public function overwriteForm ($return, $returnfull)
    {
	    $return['date_start'] = new Leap\View\InputText("date", "date_start", "date_start", $this->date_start);
        $return['date_end'] = new Leap\View\InputText("date", "date_end", "date_end", $this->date_end);
        if(isset($_GET['load']) && $_GET['load'])
            $return['date_post'] = new Leap\View\InputText("hidden", "date_post", "date_post", $this->date_post);
        else
            $return['date_post'] = new Leap\View\InputText("hidden", "date_post", "date_post", leap_mysqldate());
        $return['date_update'] = new Leap\View\InputText("hidden", "date_update", "date_update", leap_mysqldate());
        return $return;
    }
    /*
     * waktu read alias diganti objectnya/namanya
     */
    public function overwriteRead ($return)
    {
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->date_post)) {
                $obj->date_post = date("d-m-Y", strtotime($obj->date_post));
            }
            if (isset($obj->date_update)) {
                $obj->date_update = date("d-m-Y", strtotime($obj->date_update));
            }
            if (isset($obj->date_start)) {
                $obj->date_start = date("d-m-Y", strtotime($obj->date_start));
            }
            if (isset($obj->date_end)) {
                $obj->date_end = date("d-m-Y", strtotime($obj->date_end));
            }
        }
        //pr($return);
        return $return;
    }
}