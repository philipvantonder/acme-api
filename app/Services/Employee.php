<?php

namespace App\Services;

abstract class Employee {

	public $employee;

    public function __construct($employee) {
		$this->employee = $employee;	
    }

	abstract protected function executeInternal($name);

    public function execute() {

		if (!$this->hasEnded($this->employee->employmentEndDate) && $this->hasStarted($this->employee->employmentStartDate) && $this->hasBirthdayToday($this->employee->dateOfBirth)) {	
			$this->executeInternal($this->employee->name . " " . $this->employee->lastname);
		}

	}

	public function hasEnded($end_date) 
	{

		if ($end_date != "null" && date("Y-m-d", strtotime($end_date)) > date("Y-m-d")) {
			return true;
		}

		return false;

	}

	public function hasStarted($start_date) 
	{

		if (date("Y-m-d", strtotime($start_date)) < date("Y-m-d")) {
			return true;
		}

		return false;

	}

	public function hasBirthdayToday($dob) 
	{

		if (date("m-d", strtotime($dob)) == date("m-d")) {
			return true;
		}

		return false;

	}
    
}