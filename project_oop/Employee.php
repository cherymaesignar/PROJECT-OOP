<?php

require_once 'Person.php';

abstract class Employee extends Person {
    private $companyName;

    public function __construct($name, $address, $age, $companyName) {
        parent::__construct($name, $address, $age);
        $this->companyName = $companyName;
    }

    public function getCompanyName() {
        return $this->companyName;
    }

    abstract public function earnings();

    public function toString() {
        return parent::toString() . ", Company Name: {$this->companyName}";
    }
}

?>
