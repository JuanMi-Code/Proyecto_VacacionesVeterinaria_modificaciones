<br><br><br><br>

    <table>
        <tr>
            <th colspan="4">
                últimas vacunas de <?=$nomAnimal?>
            </th>
        </tr>
        <tr>
            <td>Foto</td>
            <td>Vacuna</td>
            <td>Fecha</td>
            <td>Veterinario</td>
        </tr>
        <tr>
            <td rowspan="<?=count($vacunas)?>"><img class="fotoVacunar" src="web/animales/<?=$fotoAnimal?>" alt="foto animal"></td>
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

    <br><br><br>

    <?php
    
        if (isset($_REQUEST['generar'])) {
            echo '
            <button>
                <a href="index.php?ctl=generarPDF&anim='.$_REQUEST['generar'].'">Cartilla PDF</a>
            </button>
            ';
        }
    
    ?>

</main>
<br><br><br><br>