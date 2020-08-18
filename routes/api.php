<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Services\EmployeeBirthdayApi;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/birthdayWishes', function(Request $request) {

	try {

		$client = new \GuzzleHttp\Client();

		$employeeRequest = $client->get(config('services.acme_soft.api_url') . 'Employees', ['verify' => false]);
		
		$BirthdayWishExclusionsRequest = $client->get(config('services.acme_soft.api_url') . 'BirthdayWishExclusions', ['verify' => false]);
	
		$BirthdayWishExclusionsRequest = json_decode($BirthdayWishExclusionsRequest->getBody());
		
		$employee_arr = json_decode($employeeRequest->getBody());
		
		foreach ($employee_arr as $employee) {
			
			if (!empty($BirthdayWishExclusionsRequest) && in_array($employee->id, $BirthdayWishExclusionsRequest)) {
				continue;
			}
			
			$birthday = new EmployeeBirthdayApi($employee);
			$birthday->execute();
			
		}

	} catch (\GuzzleHttp\Exception\RequestException $e) {
		Log::error("Birthday API have failed");
	}
	
});