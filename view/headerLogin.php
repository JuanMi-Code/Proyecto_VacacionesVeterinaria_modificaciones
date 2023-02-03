<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="web/css/style.css">
</head>

<body>
    <header>
        <span id="titulo">Clínica Veterinaria</span>
        <ul class="nav">
            <li><a href="index.php?ctl=paginaHomeLogged&mainLogged">Home</a></li>
            <li><a href="index.php?ctl=paginaAnimalesLogged&verAnimales">Ver Animales</a></li>
            <li>
                Solicitar Cita
                <ul>
                    <?php
                    for ($i = 0; $i < count($_SESSION['nombreAnimales']); $i++) {
                        echo '<li><a href="index.php?ctl=paginaPedirCitaLogged&solicitarCita=' . $_SESSION['nombreAnimales'][$i]['NomAnimal'] . '&primero">' . $_SESSION['nombreAnimales'][$i]['NomAnimal'] . '</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <li>
                Anular Cita
                <ul>
                    <?php
                    for ($i = 0; $i < count($_SESSION['nombreAnimales']); $i++) {
                        echo '<li><a href="index.php?ctl=paginaAnularCitaLogged&anularCita=' . $_SESSION['nombreAnimales'][$i]['NomAnimal'] . '&primero">' . $_SESSION['nombreAnimales'][$i]['NomAnimal'] . '</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <li>
                Ver Vacunas
                <ul>
                    <?php
                    for ($i = 0; $i < count($_SESSION['nombreAnimales']); $i++) {
                        echo '<li><a href="index.php?ctl=vacunasCliente&generar='.$_SESSION['nombreAnimales'][$i]['NumHistorial'].'">' . $_SESSION['nombreAnimales'][$i]['NomAnimal'] . '</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <!-- <li id="loginImgNombre"><a href="index.php?paginaCerrarSesionLogged&logout">Cerrar Sesión de <?php 
            // $this->nombreUsuario ?></a><img id="fotoPerfil" src="<?php 
            // $this->fotoPerfil ?>
            " alt="foto de perfil"></li> -->
            <li id="loginImgNombre"><a href="index.php?paginaCerrarSesionLogged&logout">Cerrar Sesión de <?= $_SESSION['perfil']['nombreUsuario'] ?></a><img id="fotoPerfil" src="<?= $_SESSION['perfil']['fotoPerfil'] ?>" alt="foto de perfil"></li>

        </ul>
    </header>