<?php

namespace App\Services;

use App\Mail\EmployeeBirthday;

class EmployeeBirthdayApi extends \App\Services\Employee {

    public function executeInternal($name) 
    {

		if (date("m-d", strtotime($this->employee->dateOfBirth)) == date("m-d")) {
			\Mail::to(config('services.acme_soft.email'))->send(new EmployeeBirthday($name));
		}
		
    }

}