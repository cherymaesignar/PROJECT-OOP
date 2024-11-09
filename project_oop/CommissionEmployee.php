<?php

require_once 'Employee.php';

class CommissionEmployee extends Employee {
    private $regularSalary;
    private $itemSold;
    private $commissionRate;

    public function __construct($name, $address, $age, $companyName, $regularSalary, $itemSold, $commissionRate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->regularSalary = $regularSalary;
        $this->itemSold = $itemSold;
        $this->commissionRate = $commissionRate;
    }

    public function earnings() {
        return $this->regularSalary + ($this->itemSold * $this->commissionRate);
    }

    public function toString() {
        return parent::toString() . ", Regular Salary: {$this->regularSalary}, Items Sold: {$this->itemSold}, Commission Rate: {$this->commissionRate}";
    }
}

?>
