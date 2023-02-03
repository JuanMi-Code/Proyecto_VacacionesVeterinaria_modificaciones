<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="web/css/style.css">
    <style>
        .fotoVacunar{
            width: 100px;
        }
    </style>
</head>

<body>
    <header>
        <span id="titulo">Clínica Veterinaria</span>
        <ul class="nav">
            <li><a href="index.php?ctl=paginaHomeVetLogged">Detalles Veterinario</a></li>
            <li><a href="index.php?ctl=paginaVacunar">Vacunar</a></li>
            <li id="loginImgNombre">
                <a href="index.php?paginaCerrarSesionLogged&logout">
                    Cerrar Sesión de <?= $this->nombreVeterinario ?>
                </a>
                <img id="fotoPerfil" src="<?= $this->fotoVeterinario ?>" alt="foto de perfil">
            </li>
        </ul>
    </header>