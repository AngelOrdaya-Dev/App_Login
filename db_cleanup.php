<?php
use Illuminate\Support\Facades\DB;

try {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    $tables = ['users', 'classrooms', 'careers'];
    
    foreach ($tables as $table) {
        // Obtener datos actuales
        $records = DB::table($table)->orderBy('id')->get();
        
        // Limpiar tabla
        DB::table($table)->truncate();
        
        // Re-insertar con IDs nuevos
        foreach ($records as $index => $record) {
            $data = (array)$record;
            $data['id'] = $index + 1;
            DB::table($table)->insert($data);
        }
        
        $nextId = count($records) + 1;
        DB::statement("ALTER TABLE $table AUTO_INCREMENT = $nextId");
        echo "Tabla $table reordenada. Proximo ID: $nextId\n";
    }
    
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "Base de datos sincronizada con éxito.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
