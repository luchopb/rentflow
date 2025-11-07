<?php
// Helper para enviar emails usando PHPMailer y SMTP de Gmail
// Recuerda: Debes poner la contraseña de aplicación de Gmail en la variable correspondiente.

require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Enviar un email usando SMTP de Gmail
 * @param array|string $destinatarios Lista de emails o string
 * @param string $asunto Asunto del correo
 * @param string $cuerpo Cuerpo HTML del correo
 * @param array $adjuntos (opcional) Rutas de archivos a adjuntar
 * @return bool|string true si ok, string con error si falla
 */
function enviar_email($destinatarios, $asunto, $cuerpo, $adjuntos = []) {
    $mail = new PHPMailer(true);
    try {
        // Configuración SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fasterworks@gmail.com'; // Cambiar si es necesario
        $mail->Password = 'gynw guzc orio ndai'; // Cambiar por contraseña de app Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('fasterworks@gmail.com', 'RentFlow');

        // Soporta múltiples destinatarios separados por coma o array
        if (is_string($destinatarios)) {
            $destinatarios = explode(',', $destinatarios);
        }
        foreach ($destinatarios as $email) {
            $email = trim($email);
            if ($email) $mail->addAddress($email);
        }

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo;

        // Adjuntos
        foreach ($adjuntos as $adj) {
            if (file_exists($adj)) {
                $mail->addAttachment($adj);
            }
        }

        $mail->send();
        return true;
    } catch (Exception $e) {
        return 'Error al enviar email: ' . $mail->ErrorInfo;
    }
} 