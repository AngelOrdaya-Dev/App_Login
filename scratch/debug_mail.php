<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'ricardohuamanculi@gmail.com';
$user = User::where('email', $email)->first();

if($user) {
    echo "User found: " . $user->name . "\n";
    echo "Updating password to Ricardo.2026...\n";
    $user->update([
        'password' => Hash::make('Ricardo.2026'),
        'two_factor_enabled' => true
    ]);
    
    echo "Attempting to send 2FA mail...\n";
    try {
        $user->generateTwoFactorCode();
        echo "SUCCESS: Mail sent to " . $email . "\n";
    } catch (\Exception $e) {
        echo "FAILED: " . $e->getMessage() . "\n";
        echo "Trace: " . $e->getTraceAsString() . "\n";
    }
} else {
    echo "User not found: " . $email . "\n";
}
