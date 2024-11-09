<?php

require_once 'Employee.php';

class PieceWorker extends Employee {
    private $numberItems;
    private $wagePerItem;

    public function __construct($name, $address, $age, $companyName, $numberItems, $wagePerItem) {
        parent::__construct($name, $address, $age, $companyName);
        $this->numberItems = $numberItems;
        $this->wagePerItem = $wagePerItem;
    }

    public function earnings() {
        return $this->numberItems * $this->wagePerItem;
    }

    public function toString() {
        return parent::toString() . ", Number of Items: {$this->numberItems}, Wage Per Item: {$this->wagePerItem}";
    }
}

?>
