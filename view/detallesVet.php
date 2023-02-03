<main id="homeMainVet">
    
    <br><br><br>
    <table id="tablaVet">
        <tr>
            <th colspan="3">Datos de veterinario</th>
        </tr>
        <tr>
            <td>Nombre</td>
            <td>Foto</td>
            <td>Número de Colegiado</td>
        </tr>
        <tr>
            <td><?=$_SESSION['veterinario']['nombreCompleto']?></td>
            <td><img id="fotoVeterinario" src="web/veterinarios/<?=$_SESSION['veterinario']['fotoVet']?>" alt="foto veterinario"></td>
            <td><?=$_SESSION['veterinario']['numColegiado']?></td>
        </tr>
    </table>
    <br><br><br>

</main>