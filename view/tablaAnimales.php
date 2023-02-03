<br><br><br><br>
<main id="main1">
    <div>
        <?php
        echo '<a href="index.php?ctl=paginaAnimalesLogged&verAnimales&pagina=' . ($actual - 1) . '" class="table1Paginacion"> Anterior </a>';
        for ($i = 1; $i <= $paginas; $i++) {
            echo '<a href="index.php?ctl=paginaAnimalesLogged&verAnimales&pagina=' . $i . '" class="table1Paginacion"> ' . $i . ' </a>';
        }
        echo '<a href="index.php?ctl=paginaAnimalesLogged&verAnimales&pagina=' . ($actual + 1) . '" class="table1Paginacion"> Siguiente </a>';
        ?>
    </div>
    <br>
    <br>
    <br>
    <br>
    <table id="table1">
        <tr>
            <th colspan="3" class="table1Verde">Animales</th>
        </tr>
        <tr>
            <th class="table1Verde">Nombre</th>
            <th class="table1Verde">Foto</th>
            <th class="table1Verde">Especie</th>
        </tr>
        <tr>
            <?php
            for ($i = 0; $i < count($fotos); $i++) {

                echo '<td class="table1Azul">' . $fotos[$i]['nombre'] . '</td>';
                echo '<td class="table1Azul"><img src="web/animales/' . $fotos[$i]['foto'] . '" id="fotoAnimal"></td>';
                echo '<td class="table1Azul">' . $fotos[$i]['especie'] . '</td>';
                echo '</tr><tr>';
            }
            ?>
        </tr>
    </table>
</main>
<br><br><br><br>