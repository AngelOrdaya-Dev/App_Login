<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email', 'angel1120171@hotmail.com')->first();
if ($user) {
    $user->two_factor_enabled = false;
    $user->save();
    echo "2FA_DESACTIVADO";
} else {
    echo "USUARIO_NO_ENCONTRADO";
}
