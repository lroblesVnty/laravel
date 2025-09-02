<?php

namespace App\Exceptions;

use Exception;

class MiembroInactivoException extends Exception{
    public function render($request){
        return response()->json([
            'error' => 'El miembro no está activo. No se puede registrar asistencia.'
        ], 409);
    }

}
