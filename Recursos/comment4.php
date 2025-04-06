<?php
function filter_string_polyfill(string $string): string
{
    // Elimina caracteres nulos y etiquetas HTML
    $str = preg_replace('/\x00|<[^>]*>?/', '', $string);
    // Sustituye comillas por entidades HTML
    return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
}
session_start();
// Generar token CSRF si no existe
if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar el token CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !==$_SESSION['csrf_token']) {
                die("Error: Token CSRF inválido.");
        }// Verificar si el comentario ha sido enviado
        // Obtener y sanitizar el comentario
        $comment = filter_string_polyfill($_POST['comment'] ?? ''); // Usamos '??' para manejar el caso de que no se haya enviado ningún comentario
        $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
    // Validación de longitud y evitar comentarios vacíos.
    if (!empty($comment) && strlen($comment) <= 500) {
        echo "Comentario publicado: " . $comment;
    } else {
        echo "Error: El comentario no puede estar vacío y debe tener máximo 500 caracteres.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Comentarios Seguros</title>
</head>
<body>
        <form method="post">
                <label for="comment">Escribe tu comentario:</label>
                <input type="text" name="comment" id="comment" required maxlength="500">
                <input type="hidden" name="csrf_token" value="<?php echo
$_SESSION['csrf_token']; ?>">
                <button type="submit">Enviar</button>
        </form>
</body>
</html>
