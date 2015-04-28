<?php
namespace Leap\View;
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

/**
 * Description of InputText
 *
 * @author User
 */
class InputText extends Html {

    public $type;


    public function __construct ($type, $id, $name, $value, $classname = 'form-control')
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->classname = $classname;
        $this->value = stripslashes($value);
    }

    public function p ()
    {
        echo "<input type='{$this->type}' name='{$this->name}' value='{$this->value}' id='{$this->id}' class='{$this->classname}' {$this->readonly}>";
    }
}
