<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'angel1120171@hotmail.com')->first();
if ($user) {
    $user->password = Hash::make('Angel.2026');
    $user->save();
    echo "CONTRASENA_ACTUALIZADA";
} else {
    echo "USUARIO_NO_ENCONTRADO";
}
