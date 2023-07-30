<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Lib\CryptoHelper;
use App\Models\User;

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $crypto = new CryptoHelper();
    $certificates = $crypto->GetCertificates();
    $users = User::all();
    #dd($certificates);
    #$certificate = $certificates[2];
    #dd($certificate);
    #$certificate->SetPin('1q2w3e4r');
    #$secret = 'My secret string';
    #$sign = $crypto->Sign($certificate, $secret);
    #dd($sign);
    #$secret = 'My secret string';
    #$signInfo = $crypto->Verify($secret, $sign, true);
    #dd($signInfo);
    dump($users);
    return view('regcif', compact('certificates'));
});
Route::post('/reg', function(Request $request){
	$crypto = new CryptoHelper();
	$certificates = $crypto->GetCertificates();
	
	foreach($certificates as $certificate) {
		if ($certificate->Subject->Name == $request->all()['cert']) {
			$certificate->SetPin($request->all()['password']);
			$user = new User();
			$user->password = $crypto->Sign($certificate, 'password');;
			$user->email = $certificate->Subject->Email;
			$user->name = $certificate->Subject->Name;
			$user->save();
		}
	}
	
	return redirect()->back();
})->name('reg');
