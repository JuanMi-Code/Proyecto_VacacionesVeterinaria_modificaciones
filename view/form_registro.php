<?php
ob_start();
?>
<!-- <form method='post' action="index.php?ctl=registrar" enctype="multipart/form-data" autocomplete="off"> -->
<form method='post' action="index.php?ctl=paginaRegistro" enctype="multipart/form-data" autocomplete="off">
    <section class="form-register">
        <h4>Formulario Registro</h4>
        <input class="controls" type="text" name="nombre" id="nombre" 
        placeholder="Introduzca Nombre" maxlenght=50 value="<?php echo $registro['nombre']; ?>" 
        onclick=" this.value=''">

        <input class="controls" type="text" name="apellidos" id="apellidos" 
        placeholder="Introduzca Apellidos" maxlenght=50 value="<?= $registro['apellidos'] ?>" 
        onclick=" this.value=''">

        <input class="controls" type="text" name="nif" id="nif" 
        placeholder="Introduzca NIF" maxlenght=9 value="<?= $registro['nif'] ?>" 
        onclick=" this.value=''">

        <input class="controls" type="text" name="alias" id="alias" 
        placeholder="Introduzca un alias" maxlenght=50 value="<?= $registro['alias'] ?>" 
        onclick=" this.value=''">

        <input class="controls" type="text" name="correo" id="correo" 
        placeholder="Introduzca el Correo" maxlenght=9 value="<?= $registro['correo'] ?>" 
        onclick=" this.value=''">

        <input class="controls" type="password" name="clave1" id="clave" 
        placeholder="Introduzca su Contraseña (Mínimo 6 caracteres)" value="<?= $registro['clave1'] ?>" 
        onclick=" this.type='text'" onmouseout=" this.type='password'">

        <input class="controls" type="password" name="clave2" id="clave" 
        placeholder="Repita la Contraseña" value="<?= $registro['clave2'] ?>" 
        onclick=" this.type='text'" onmouseout=" this.type='password'">

        <input class="controls" type="file" name="imagenPersona" id="foto1" 
        onclick=" this.value=''">

        <input class="controls" type="text" name="nombreAnimal" id="clave" 
        placeholder="Introduzca el nombre de su mascota" value="<?= $registro['nombreAnimal'] ?>" 
        onclick=" this.value=''">

        <input class="controls" type="file" name="imagenAnimal" id="foto2">
        <select class="controls" name="tipoAnimal" id="tipo" required>
           
            <option disabled <?= $defecto ?>>Seleccione un tipo de animal</option>
            <?php
            
                for ($i=0; $i < count($tiposAnimales); $i++) {
                    echo '<option>'.$tiposAnimales[$i]['NombreTipo'].'</option>';
                }
            
            ?>
        </select>
        <input class="botons" type="submit" value="Registrar" name="registrar">
    </section>
</form>


<?php
$datos = ob_get_clean() 
?>