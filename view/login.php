<br><br><br>
<main id="loginMain">
    <span id="error"><?= $error ?></span>
    <form action="index.php?ctl=paginaLogin" method="post">
        <label for="usuario">Nombre de Usuario</label>
        <br>
        <input type="text" name="user" id="usuario">
        <br>
        <label for="contrasena">Contraseña</label>
        <br>
        <input type="password" name="passwd" id="contrasena">
        <br>
        <br>
        <input type="submit" value="Iniciar Sesión" name="iniciarSesion">
    </form>
</main>
<br><br><br>