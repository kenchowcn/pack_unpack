<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author ZhouWei
 */

class Person{
    public $name;
    public $age;
    public $gender;
    
    function packPerson(){
        $protocolFormat = array(
            "name" => array("Z10", $this->name),
            "age" => array("n", $this->age),
            "gender" => array("Z5", $this->gender)
        );
        
        $bin_array = array();
        foreach ($protocolFormat as $key => $value) {
            $bin_array[] = pack($value[0], $value[1]);
        }
        
        return implode("", $bin_array);
    }
    
    function unpackPerson($raw){
        $protocolFormat = array(
            "name" => array("Z10", $this->name),
            "age" => array("n", $this->age),
            "gender" => array("Z5", $this->gender)
        );
   
        $format = array();
        foreach ($protocolFormat as $key => $value) {
            $format[] = $value[0] . $key . "/";
        }
        
        return unpack(implode($format), $raw);
    }
    
    function arrayToObj($array){
        $obj = new Person("", 0, "");
     
        foreach ($array as $key => $value) {
            $obj->{$key} = $value;
        }
        
        return $obj;
    }
            
    function __construct($name, $age, $gender) {
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
    }
}
    // allocating a new person
    echo "allocating a new person:\n";
    $me = new Person("Ken", 28, "Male");
    var_dump($me);
    
    // pack its binary stream according to protocol format
    echo "pack its binary stream according to protocol format.\n";
    $binary = $me->packPerson();
    
    // unpack it to array
    echo "unpack it to array:\n";
    $binary_array = $me->unpackPerson($binary);
    var_dump($binary_array);
    
    // converting array to object
    $person = $me->arrayToObj($binary_array);
    echo "converting array to object:\n";
    var_dump($person);

    