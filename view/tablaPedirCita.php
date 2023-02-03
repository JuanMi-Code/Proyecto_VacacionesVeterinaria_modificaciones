<br><br><br><br>
<main id="main1">
    <div>
        <?php
        echo '<a href="index.php?ctl=paginaPedirCitaLogged&solicitarCita&pagina=anterior" class="pedirCitaPaginacion"> <strong>Anterior</strong> </a>';
        echo '<span>Semana del ' . date("Y-m-d", $d) . ' al ' . date("Y-m-d", $d + 518400) . '</span>';
        echo '<a href="index.php?ctl=paginaPedirCitaLogged&solicitarCita&pagina=siguiente" class="pedirCitaPaginacion"> <strong>Siguiente</strong> </a>';
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
                        // VEMOS SI ESTA RESERVADO EL DÍA CON EL INTERVALO
                        for ($x = 0; $x < count($citas); $x++) {
                            if ($fecha[$j] == $citas[$x]['fecha'] && $intervalos[$i]['texto'] == $citas[$x]['intervalo']) {
                                // SI ES NUESTRO ANIMAL LO PINTAMOS DE NARANJA, SINO DE ROJO
                                if ($citas[$x]['nombreAnimal'] == $_SESSION['solicitarCitaAnimal']) {
                                    echo '<td class="celda_naranja">' . $citas[$x]['nombreAnimal'] . '</td>';
                                } else {
                                    echo '<td class="celda_rojo">' . $citas[$x]['nombreAnimal'] . '</td>';
                                }
                                $reservado = true;
                            }
                        }
                        // SI EL DÍA NO HA SIDO RESERVADO PINTAMOS NORMAL
                        if (!$reservado) {
                            // Las fechas anteriores a la actual, no están activas
                            if (date("Y-m-d", strtotime($fecha[$j])) <= date("Y-m-d", strtotime("now"))) {

                                echo '<td class="celda_gris"></td>';
                            } else {
                                echo '<td><a href="index.php?ctl=paginaPedirCitaLogged&solicitarCita&'
                                    . 'reservar=' . $_SESSION['solicitarCitaAnimal'] .
                                    '&fecha=' . $fecha[$j] .
                                    '&intervalo=' . $intervalos[$i]['idIntervalo'] .
                                    '">Reservar</a></td>';
                            }
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