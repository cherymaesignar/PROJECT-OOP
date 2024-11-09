<?php

require_once 'Person.php';
require_once 'Employee.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';
require_once 'EmployeeRoster.php';

class Main
{
    private EmployeeRoster $roster;
    private int $size;
    private bool $continueProcess;

    public function start()
    {
        $this->clearScreen();
        $this->displayWelcomeMessage();
        
        do {
            $this->size = (int)readline("Enter the roster size (minimum 1): ");
            if ($this->size < 1) {
                echo "⚠️ Invalid input. Please enter a number greater than zero.\n";
            }
        } while ($this->size < 1);

        $this->roster = new EmployeeRoster($this->size);
        echo "✅ Roster initialized with a capacity of $this->size employees.\n";
        readline("Press Enter to continue...");

        $this->mainMenu();
    }

    private function displayWelcomeMessage()
    {
        echo "*****************************************\n";
        echo "👥 Welcome to the Employee Roster System 👥\n";
        echo "*****************************************\n\n";
        echo "Manage employees efficiently and track payrolls.\n\n";
    }

    private function mainMenu()
    {
        while (true) {
            $this->clearScreen();
            echo "*** MAIN MENU ***\n";
            echo "[1] ➕ Add Employee\n";
            echo "[2] 🗑️ Delete Employee\n";
            echo "[3] 📊 View Reports\n";
            echo "[0] 🚪 Exit\n";

            $choice = (int)readline("Choose an option: ");
            switch ($choice) {
                case 1:
                    $this->addEmployeeMenu();
                    break;
                case 2:
                    $this->deleteEmployee();
                    break;
                case 3:
                    $this->viewReportsMenu();
                    break;
                case 0:
                    echo "👋 Thank you for using the Employee Roster System! Goodbye!\n";
                    return;
                default:
                    echo "⚠️ Invalid option. Please select a valid choice.\n";
                    readline("Press Enter to continue...");
            }
        }
    }

    private function addEmployeeMenu()
    {
        $this->clearScreen();
        echo "--- Add New Employee ---\n";
        $name = readline("Employee Name: ");
        $address = readline("Employee Address: ");
        $age = (int)readline("Employee Age: ");
        $companyName = readline("Company Name: ");

        $this->selectEmployeeType($name, $address, $age, $companyName);
    }

    private function selectEmployeeType($name, $address, $age, $companyName)
    {
        $this->clearScreen();
        echo "--- Select Employee Type ---\n";
        echo "[1] 💼 Commission Employee\n";
        echo "[2] ⏰ Hourly Employee\n";
        echo "[3] 🛠️ Piece Worker\n";

        $type = (int)readline("Choose the employee type: ");
        switch ($type) {
            case 1:
                $this->addCommissionEmployee($name, $address, $age, $companyName);
                break;
            case 2:
                $this->addHourlyEmployee($name, $address, $age, $companyName);
                break;
            case 3:
                $this->addPieceWorker($name, $address, $age, $companyName);
                break;
            default:
                echo "⚠️ Invalid choice. Please select a valid type.\n";
                readline("Press Enter to continue...");
                $this->selectEmployeeType($name, $address, $age, $companyName);
        }
    }

    private function addCommissionEmployee($name, $address, $age, $companyName)
    {
        $regularSalary = (float)readline("Enter Regular Salary: ");
        $itemsSold = (int)readline("Enter Number of Items Sold: ");
        $commissionRate = (float)readline("Enter Commission Rate: ");

        $this->roster->add(new CommissionEmployee($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate));
        $this->confirmAddition();
    }

    private function addHourlyEmployee($name, $address, $age, $companyName)
    {
        $hoursWorked = (float)readline("Enter Hours Worked: ");
        $rate = (float)readline("Enter Hourly Rate: ");

        $this->roster->add(new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate));
        $this->confirmAddition();
    }

    private function addPieceWorker($name, $address, $age, $companyName)
    {
        $piecesProduced = (int)readline("Enter Number of Pieces Produced: ");
        $ratePerPiece = (float)readline("Enter Rate per Piece: ");

        $this->roster->add(new PieceWorker($name, $address, $age, $companyName, $piecesProduced, $ratePerPiece));
        $this->confirmAddition();
    }

    private function confirmAddition()
    {
        echo "✅ Employee successfully added!\n";
        if ($this->roster->count() < $this->size) {
            $addMore = readline("Would you like to add another employee? (y/n): ");
            if (strtolower($addMore) === 'y') {
                $this->addEmployeeMenu();
            }
        } else {
            echo "⚠️ Roster is full. Cannot add more employees.\n";
            readline("Press Enter to continue...");
        }
    }

    private function deleteEmployee()
    {
        $this->clearScreen();
        echo "--- Delete Employee ---\n";
        $this->roster->display();

        $id = (int)readline("Enter the Employee ID to delete (0 to cancel): ");
        if ($id === 0) {
            return;
        } else {
            $this->roster->remove($id);
            echo " ✅ Employee successfully deleted.\n";
            readline("Press Enter to continue...");
        }
    }

    private function viewReportsMenu()
    {
        $this->clearScreen();
        echo "--- View Reports ---\n";
        echo "[1] 📄 Display All Employees\n";
        echo "[2] 📊 Employee Counts\n";
        echo "[3] 💵 Payroll Summary\n";
        echo "[0] 🔙 Return to Main Menu\n";

        $choice = (int)readline("Choose an option: ");
        switch ($choice) {
            case 1:
                $this->displayEmployees();
                break;
            case 2:
                $this->countEmployees();
                break;
            case 3:
                $this->roster->payroll();
                readline("Press Enter to continue...");
                break;
            case 0:
                return;
            default:
                echo "⚠️ Invalid input. Please try again.\n";
                readline("Press Enter to continue...");
        }
    }

    private function displayEmployees()
    {
        $this->clearScreen();
        echo "--- Display Employees ---\n";
        echo "[1] All Employees\n";
        echo "[2] Commission Employees\n";
        echo "[3] Hourly Employees\n";
        echo "[4] Piece Workers\n";
        echo "[0] Return to Reports Menu\n";

        $choice = (int)readline("Choose an option: ");
        switch ($choice) {
            case 1:
                $this->roster->display();
                break;
            case 2:
                $this->roster->displayCE();
                break;
            case 3:
                $this->roster->displayHE();
                break;
            case 4:
                $this->roster->displayPE();
                break;
            case 0:
                return;
            default:
                echo "⚠️ Invalid input. Please try again.\n";
        }

        readline("Press Enter to continue...");
    }

    private function countEmployees()
    {
        $this->clearScreen();
        echo "--- Employee Counts ---\n";
        echo "Total Employees: " . $this->roster->count() . "\n";
        echo "Commission Employees: " . $this->roster->countCE() . "\n";
        echo "Hourly Employees: " . $this->roster->countHE() . "\n";
        echo "Piece Workers: " . $this->roster->countPE() . "\n";

        readline("Press Enter to continue...");
    }

    private function clearScreen()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cls');
        } else {
            system('clear');
        }
    }
}

$main = new Main();
$main->start();
