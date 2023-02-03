<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= $ruta ?>web/css/stylePdf.css">
    <link rel="stylesheet" href="<?= $ruta ?>web/css/estiloPdf.css">
</head>

<body>

    <section class="contenido">
        <h1>Cartilla sanitaria y de identificación oficial de animales de compañía.</h1>

        <h2>Comunidad de Castilla y León</h2>
    

    <!-- Footer 1 Hoja -->
    <div class="pie">
        <p>Consejo de Colegios Veterinarios de Castilla y León</p>
    </div>
    </section>
<!-- ---------------------------------------------------------- -->
<section>
    <p>El propietario es el responsable último de la
        salud y la protección de sus animales. En la
        Comunidad de Castilla y León existe una Ley
        de Protección Animal que contempla las
        normas para la protección de los animales
        domésticos y, en particular, los de compañía y
        establece las obligaciones y prohibiciones que
        deben observar los propietarios de dichos
        animales. El veterinario es el profesional que
        se encarga de vigilar su estado de salud y
        bienestar, controlando las enfermedades que
        pueden aparecer y de indicar las medidas
        preventivas más adecuadas. El
        incumplimiento de lo establecido en la
        normativa de la Comunidad de Castilla que
        regula los aspectos relativos a la tenencia,
        protección, identificación y vacunación de los
        animales de compañía, está sujeto al régimen
        de infracciones y sanciones establecido en la
        Ley 1/1990, de 1 de febrero, de Protección de los Animales Domésticos.
        Consejo de Colegios Veterinarios de Castilla y León
    </p>
    </section>
<!-- Footer 2 Hoja -->
    <div class="pie">
        <p>Consejo de Colegios Veterinarios de Castilla y León</p>
    </div>
<!-- ---------------------------------------------------------- -->
<br><br><br><br><br>
<section>
<table>
    <tr>
        <td colspan="2">Cartilla Sanitaria</td>
    </tr>
    <tr>
        <td colspan="2">
            <img src="<?=$fotoAnimal?>" alt="animal" style="width: 400px;" class="center">
        </td>
    </tr>
    <tr>
        <td>Nombre del animal</td>
        <td><?=$nombreAnimal?></td>
    </tr>
    <tr>
        <td>Raza del animal</td>
        <td><?=$razaAnimal?></td>
    </tr>
    <tr>
        <td>Identificación Nº del microchip</td>
        <td><?=$idAnimal?></td>
    </tr>
    <tr>
        <td>Nombre del veterinario</td>
        <td><?=$nombreVeterinario?></td>
    </tr>
    <tr>
        <td>Nº colegiado</td>
        <td><?=$numVeterinario?></td>
    </tr>
    <tr>
        <td>Firma del Veterinario</td>
        <td><img src="<?=$firmaVeterinario?>" alt="firma" class="firmaP"></td>
    </tr>
    <tr>
        <td>Sello de la Clínica</td>
        <td><img src="<?=$selloClinica?>" alt="sello" class="firmaP"></td>
    </tr>
</table>
</section>
<br><br><br><br><br>

<!-- Footer 3 Hoja -->
<div class="pie">
        <p>Consejo de Colegios Veterinarios de Castilla y León</p>
    </div>
<!-- ---------------------------------------------------------- -->
<section>
<table>
    <tr>
        <th colspan="4">Registro de Vacunas</th>
    </tr>
    <tr>
        <th>Nombre de la vacuna</th>
        <th>Fecha</th>
        <th>Nº Colegiado</th>
        <th>Firma</th>
    </tr>
    <tr>
        <?php
            for ($i=0; $i < count($infoVacunas); $i++) {
                echo '<td>'.$infoVacunas[$i]['nombreVacuna'].'</td>';
                echo '<td>'.$infoVacunas[$i]['fecha'].'</td>';
                echo '<td>'.
                $infoVacunas[$i]['numColegiado']
                .'<img src="'.$ruta.'web/veterinarios/'.$infoVacunas[$i]['FirmaRegistrada'].'" alt="firma" class="firmaP">'
                .'</td>';
                echo '<td><img src="'.$ruta.'web/veterinaria/logo.png" alt="" class="firmaP"></td>';
                echo '</tr><tr>';
            }
        ?>
    </tr>
</table>
</section>
<!-- Footer 4 Hoja -->
<div class="pie">
        <p>Consejo de Colegios Veterinarios de Castilla y León</p>
    </div>

</body>
</html>




<!-- 
<br><br><br><br>

<table>
    <tr>
        <th colspan="4">
            Últimas vacunas de <?=$_SESSION['pdf']['nomAnimal']?>
        </th>
    </tr>
    <tr>
        <td>Foto</td>
        <td>Vacuna</td>
        <td>Fecha</td>
        <td>Veterinario</td>
    </tr>
    <tr>
        <td rowspan="<?=count($vacunas)?>"><img class="fotoVacunar" src="<?=$ruta?>web/animales/<?=$_SESSION['pdf']['nombreFoto']?>" alt="foto animal"></td>
        <?php
            foreach ($vacunas as $key => $value) {
            // var_dump($value);
            echo '<td>'.$value['nombreVacuna'].'</td>';
            echo '<td>'.$value['fecha'].'</td>';
            echo '<td>'.$value['NombreCompleto'].'</td>';
            echo '</tr><tr>';
            }
        ?>
    </tr>
</table>

<br><br><br><br> -->