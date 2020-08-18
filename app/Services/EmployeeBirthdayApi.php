<?php

namespace App\Services;

use App\Mail\EmployeeBirthday;

class EmployeeBirthdayApi extends \App\Services\Employee {

    public function executeInternal($name) 
    {

		$is_leap_year = date("L");

		$employeee_birth_date = date("m-d", strtotime($this->employee->dateOfBirth));
		if (!$is_leap_year && date("m-d", strtotime($this->employee->dateOfBirth)) == "02-29") {
			$employeee_birth_date = date("m-d", strtotime("{$this->employee->dateOfBirth} -1 day"));
		}

		if ($employeee_birth_date == date("m-d")) {
			\Mail::to(config('services.acme_soft.email'))->send(new EmployeeBirthday($name));
		}
		
    }

}