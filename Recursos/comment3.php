<?php
//sanitizar comentario
$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
if (!empty($comment) && strlen($comment) <= 500) {
        echo "Comentario publicado: " . $comment;
} else {
        echo "Error: El comentario no puede estar vacío y debe tener máximo 500caracteres.";
}
?>

<form method="post">
        <input type="text" name="comment">
        <button type="submit">Enviar</button>
</form>
