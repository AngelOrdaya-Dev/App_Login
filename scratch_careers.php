<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Career;
use Illuminate\Support\Facades\DB;

try {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    Career::truncate();
    $careers = [
        'Informática y Desarrollo de Aplicaciones Web',
        'Ingeniería de Sistemas',
        'Diseño Gráfico y Multimedia',
        'Administración de Negocios Internacionales',
        'Psicología Organizacional',
        'Contabilidad y Finanzas',
        'Derecho y Ciencias Políticas',
        'Arquitectura y Urbanismo',
        'Ingeniería Civil',
        'Marketing y Gestión Comercial'
    ];
    foreach ($careers as $name) {
        Career::create(['name' => $name]);
    }
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "Carreras insertadas correctamente\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
