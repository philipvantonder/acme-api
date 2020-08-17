<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Services\EmployeeBirthdayApi;

function view_arr($arr) { echo "<pre>"; print_r($arr); echo "</pre>"; }

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

	$client = new \GuzzleHttp\Client();

	$request = $client->get(config('services.acme_soft.api_url') . 'Employees', ['verify' => false]);

	$response = $request ? $request->getBody()->getContents() : null;
	
	$status = $request ? $request->getStatusCode() : 500;

	if ($response && $status === 200 && $response !== 'null') {

		$employee_arr = json_decode($request->getBody());

		foreach ($employee_arr as $employee) {

			$birthday = new EmployeeBirthdayApi($employee);
			$birthday->execute();

		}

	}

});