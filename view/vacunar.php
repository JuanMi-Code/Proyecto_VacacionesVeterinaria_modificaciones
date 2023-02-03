<main id="homeMain">
    <br><br><br>

    <form action="index.php?ctl=paginaVacunar" method="post">
        <select name="cliente" id="">
            <?php
            // echo '<option value="" '.$selected.'></option>Selecciona un Cliente</option>';
            foreach ($todosClientes as $key => $value) {
                // var_dump($value);
                if (isset($_SESSION['vacunar']['idCliente'])&&$_SESSION['vacunar']['idCliente']==$value['idCliente']) {
                    echo '<option value="' . $value['idCliente'] . '"selected>' . $value['NomCliente'] . ' ' . $value['apellidos'] . ' ' . $value['NIF'] . '</option>';
                } else {
                    echo '<option value="' . $value['idCliente'] . '">' . $value['NomCliente'] . ' ' . $value['apellidos'] . ' ' . $value['NIF'] . '</option>';
                }
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Elegir" name="elegirCliente">
    </form>

    
    <form action="index.php?ctl=paginaVacunar" method="post">
        <select name="animal" id="">
            <?php
            foreach ($animales as $key => $value) {
                var_dump($value);
                if (isset($_SESSION['vacunar']['numHistorial'])&&$_SESSION['vacunar']['numHistorial']==$value['NumHistorial']) {
                    echo '<option value="' . $value['NumHistorial'] . '"selected>' . $value['NomAnimal']. '</option>';
                } else {
                    echo '<option value="' . $value['NumHistorial'] . '">' . $value['NomAnimal']. '</option>';
                }
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Elegir" name="elegirAnimal">
    </form>

    <form action="index.php?ctl=paginaVacunar" method="post">
        <select name="vacuna" id="">
            <?php
            foreach ($vacunas as $key => $value) {
                var_dump($value);
                if (isset($_SESSION['vacunar']['idVacuna'])&&$_SESSION['vacunar']['idVacuna']==$value['idVacuna']) {
                    echo '<option value="' . $value['idVacuna'] . '"selected>' . $value['nombreVacuna']. '</option>';
                } else {
                    echo '<option value="' . $value['idVacuna'] . '">' . $value['nombreVacuna']. '</option>';
                }
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Elegir" name="elegirVacuna">
    </form>

    <br><br><br>