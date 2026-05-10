<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

$email = 'ricardohuamanculi@gmail.com';
$pass = 'Ricardo.2026';

$user = User::where('email', $email)->first();

if($user) {
    echo "USER FOUND\n";
    echo "Name: " . $user->name . "\n";
    echo "Password check: " . (Hash::check($pass, $user->password) ? "OK" : "WRONG") . "\n";
    echo "2FA Enabled: " . ($user->two_factor_enabled ? "YES" : "NO") . "\n";
    
    // Test manual Auth::attempt
    echo "Auth attempt test: " . (Auth::attempt(['email' => $email, 'password' => $pass]) ? "SUCCESS" : "FAILED") . "\n";
} else {
    echo "USER NOT FOUND\n";
}
