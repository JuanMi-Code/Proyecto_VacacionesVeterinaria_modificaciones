<br><br><br><br>

    <table>
        <tr>
            <th colspan="8">
                Confirmación de Vacuna el día <?=$fechaActual?>
            </th>
        </tr>
        <tr>
            <td>Propietario</td>
            <td>Mascota</td>
            <td>Foto</td>
            <td>Vacuna</td>
            <td>Veterinario</td>
            <td>Foto</td>
            <td>Colegiado</td>
            <td>Firma</td>
        </tr>
        <tr>
            <td><?=$nombrePropietario?></td>
            <td><?=$nombreMascota?></td>
            <td>
                <?php
                    echo '<img class="fotoVacunar" src="web/animales/'.$fotoAnimal.'" alt="">';
                ?>
            </td>
            <td><?=$nombreVacuna['nombreVacuna']?></td>
            <td><?=$_SESSION['veterinario']['nombreCompleto']?></td>
            <td>
                <?php
                    echo '<img class="fotoVacunar" src="web/veterinarios/'.$_SESSION['veterinario']['fotoVet'].'" alt="foto veterinario">';
                ?>
            </td>
            <td>Nº Colegiado: <?=$_SESSION['veterinario']['numColegiado']?></td>
            <td>
                <?php
                    echo '<img class="fotoVacunar" src="web/veterinarios/'.$_SESSION['veterinario']['firmaRegistrada'].'" alt="foto firma">';
                ?>
            </td>
        </tr>
    </table>

    <br><br><br>

    <button>
        <a href="index.php?ctl=anadirVacuna">Registrar</a>
    </button>

</main>
<br><br><br><br>