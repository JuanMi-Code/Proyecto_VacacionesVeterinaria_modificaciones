<br><br><br><br>
<main id="main1">
    <div>
        <?php
        echo '<a href="index.php?ctl=paginaAnularCitaLogged&anularCita&pagina=anterior" class="pedirCitaPaginacion"> Anterior </a>';
        echo '<span>Semana del ' . date("Y-m-d", $d) . ' al ' . date("Y-m-d", $d + 518400) . '</span>';
        echo '<a href="index.php?ctl=paginaAnularCitaLogged&anularCita&pagina=siguiente" class="pedirCitaPaginacion"> Siguiente </a>';
        ?>
    </div>
    <br>
    <br>
    <br>
    <br>
    <table id="tablaCitas">
        <tr>
            <td class="tablaCitashead">Hora</td>
            <?php
            $fecha = [];
            for ($i = 0; $i < 7; $i++) {
                echo '<td class="tablaCitashead">';
                $nomDia = date("l", $d);
                $dias_espanol = array('Monday'=>"Lunes",'Tuesday'=>"Martes",'Wednesday'=>"Miercoles",'Thursday'=>"Jueves",'Friday'=>"Viernes",'Saturday'=>"Sábado",'Sunday'=>"Domingo");
                $nomDia = $dias_espanol[$nomDia];
                echo $nomDia;
                echo '<br>';
                echo date("Y-m-d", $d);
                array_push($fecha, date("Y-m-d", $d));
                $d += 86400;
                echo '</td>';
            }
            ?>
        </tr>
        <tr>
            <?php
            $contador = 0;
            // PINTAMOS INTERVALO
            for ($i = 0; $i < count($intervalos); $i++) {
                echo '<td class="intervalo">' . $intervalos[$i]['texto'] . '</td>';
                // PINTAMOS LOS 7 DÍAS DE RESERVA
                for ($j = 0; $j < 7; $j++) {
                    // SI ES SÁBADO O DOMINGO NO SE PUEDE RESERVAR
                    if (date("l", strtotime($fecha[$j])) == 'Saturday' || date("l", strtotime($fecha[$j])) == 'Sunday') {
                        echo '<td class="celda_gris"></td>';
                    } else {
                        $reservado = false;
                        // VEMOS SI ESTÁ RESERVADO EL DÍA CON EL INTERVALO
                        for ($x = 0; $x < count($citas); $x++) {
                            if ($fecha[$j] == $citas[$x]['fecha'] && $intervalos[$i]['texto'] == $citas[$x]['intervalo']) {
                                // SI ES EL ANIMAL SELECCIONADO LO MARCAMOS
                                if ($citas[$x]['nombreAnimal'] == $_SESSION['anularCitaAnimal']) {
                                    // Las fechas anteriores a la actual no están activas
                                    if (date("Y-m-d", strtotime($fecha[$j])) <= date("Y-m-d", strtotime("now"))) {
                                        echo '<td class="celda_naranja">' . $citas[$x]['nombreAnimal'] . '</td>';
                                        // Para borrar citas posteriores a la fecha actual:
                                    } else {
                                        echo '<td class="celda_naranja"><a href="index.php?ctl=paginaAnularCitaLogged&anularCita&'
                                            . 'anular=' . $_SESSION['anularCitaAnimal'] .
                                            '&fecha=' . $fecha[$j] .
                                            '&intervalo=' . $intervalos[$i]['idIntervalo'] .
                                            '">' . $citas[$x]['nombreAnimal'] . '</a></td>';
                                    }
                                } else {
                                    echo '<td class="celda_rojo_intenso">' . $citas[$x]['nombreAnimal'] . '</td>';
                                }
                                $reservado = true;
                            }
                        }
                        // SI EL DÍA NO HA SIDO RESERVADO PINTAMOS GRIS
                        if (!$reservado) {
                            echo '<td class="celda_gris"></td>';
                        }
                    }
                }
                echo '</tr><tr>';
                $contador++;
            }
            ?>
        </tr>
    </table>
</main>
<br><br><br><br>