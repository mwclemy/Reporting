<?php

class Myclass {

    public $var = "this class";

    public function setProperty($value) {
        $this->var = $value;
    }

    public function getProperty() {
        return $this->var;
    }

}

$object = new Myclass();
//var_dump($object);
$object->setProperty("wow it worked!!");
echo $object->getProperty();

