<?php
require("lib/MetricTools.class.php");

try {
    $DBHandler = new DBHandler();
} catch (Exception $e) {
    print '<p>' . $e->getMessage() . '</p>';
}
?>

<head>
    <meta charset="utf-8">
    <title>Nexo — Indicadores</title>

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/estilos.css">
    <script src="lib/jquery/jquery-3.4.1.min.js"></script>
</head>

<body style="background-color: #eff1e4;">
    <nav class="bg-dark navbar navbar-expand fixed-top navbar-dark">
        <a class="navbar-brand" href="metricas.php">
            <img src="img/icono.svg" width="30" height="30" class="d-inline-block align-top" alt="">
            Nexo
        </a>

        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="indicadores.php">Indicadores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="informacion.php">Acerca de</a>
            </li>
        </ul>
    </nav>

    <div class="card contenido">
        <div class="card-header" style="font-size: 1.2rem; font-weight: bold;">
            Indicadores
        </div>

        <div class="card-body">
            <div id="analizador-de-metricas">
                <?php if ($DBHandler->executeQuery("SELECT `id` FROM `metrics`")->num_rows > 0) { ?>

                <form action="" id="parametros-herramienta" method="POST">
                        <div class="alert alert-danger" id="error-seleccion-metricas" role="alert" style="display: none;">
                            <strong>Error:</strong> Debe seleccionar como mínimo un gráfico para generar.
                        </div>

                        <label for="uuids" style="font-weight: bold;">UUID:</label>
                        <div class="form-group" id="uuids">

                            <?php
                            $result = $DBHandler->getUUIDs();
                            
                            print '<select required class="form-control form-control-lg" name="uuid">';

                            while ($row = $result->fetch_object()) {
                                print '<option value="' . $row->uuid . '">' . $row->uuid . '</option>';
                            }
                            
                            print '</select>';
                            ?>

                        </div>

                        <label for="graficos" style="font-weight: bold;">Gráfico:</label>
                        <div class="form-group form-check" id="graficos">

                            <?php
                            $result = $DBHandler->getIndicatorTypes();

                            while ($row = $result->fetch_object()) {
                                print '<input type="radio" class="form-check-input" id="' . $row->indicator . 'ScoreGraph" name="graficos[]" value="' . $row->indicator . '">';
                                print '<label class="form-check-label" for="' . $row->indicator . 'ScoreGraph">' . $row->indicator . ' versus calificación del usuario</label><br/>';    
                            }
                            ?>

                        </div>

                        <button class="btn btn-sm btn-success" name="generar" type="submit">Generar</button>
                    </form>
                
                    <?php
                    if (isset($_POST["generar"])) {
                        $uuid = filter_input(INPUT_POST, "uuid", FILTER_DEFAULT);
                        $grafico = filter_input(INPUT_POST, "graficos", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

                        $MetricTools = new MetricTools();

                        print '<hr/>';
                        
                        switch ($grafico[0]) {
                            case Constants::INDICATOR_BATTERY:
                                $MetricTools->drawBatteryScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_BRIGHTNESS:
                                $MetricTools->drawBrightnessScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_CONNECTION_TYPE:
                                // $MetricTools->drawConnectionTypeScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_CPU_PERCENTAGE:
                                $MetricTools->drawCPUConsumptionScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_ENVIRONMENT_LIGHT:
                                $MetricTools->drawEnvironmentLightScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_IS_CHARGING:
                                // $MetricTools->drawIsChargingScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_IS_CONNECTED:
                                // $MetricTools->drawIsConnectedToNetworkScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_JITTER:
                                $MetricTools->drawJitterScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_LATENCY:
                                $MetricTools->drawLatencyScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_MEMORY_MB:
                                $MetricTools->drawMemConsumptionMBScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_MEMORY_PERCENTAGE:
                                $MetricTools->drawMemConsumptionPercentageScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_PACKET_LOSS:
                                // $MetricTools->drawPacketLossScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_PROXIMITY:
                                // $MetricTools->drawProximityScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_SIGNAL_DBM:
                                // $MetricTools->drawSignalStrengthScoreGraph($uuid);
                                
                                break;
                            case Constants::INDICATOR_USER_LATENCY:
                                $MetricTools->drawUserPerceivedLatencyScoreGraph($uuid);
                                
                                break;
                        }
                    }
                    ?>
                <?php } else { ?>

                    <div class="alert alert-info" role="alert">
                        Para utilizar la herramienta primero debe insertar registros en la base de datos.
                    </div>

                <?php } ?>
            
        </div>
    </div>
</body>

<script type="text/javascript">
    $('#parametros-herramienta').submit(function (e) {
        var hayError = false;
        
        if ($('input[name="graficos[]"][type=radio]:checked').length < 1) {
            $('#error-seleccion-metricas').css('display', 'block');

            /* Error: No se seleccionaron métricas. */
            hayError = true;
        } else {
            $('#error-seleccion-metricas').css('display', 'none');
        }
        
        if (hayError) {
            return false;
        } else {
            return true;
        }
    });
</script>

<?php $DBHandler->closeConnection(); ?>