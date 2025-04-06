<?php
if (isset($_POST['comment'])) {
        // para manejar el caso de que no se haya enviado ningún comentario
    // htmlspecialchars convierte caracteres especiales en equivalentes html
    $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

}
?>
<form method="post">
	<input type="text" name="comment">
	<button type="submit">Enviar</button>
</form>
