<?php
/* Clases de pChart requeridas para el funcionamiento de esta clase. */
include("pChart/class/pData.class.php");
include("pChart/class/pDraw.class.php");
include("pChart/class/pImage.class.php");

include("Constants.class.php");
require("DBHandler.class.php");

class MetricTools {

    private $DBHandler;

    function __construct() {
        try {
            $this->DBHandler = new DBHandler();
        } catch (Exception $e) {
            echo "Couldn't create DBHandler instance. Exception: " . $e->getMessage();
        }
    }
    
    
    
    /**
     * Genera un gráfico de barras que muestra los porcentajes de carga de la
     * batería registrados en las distintas pruebas.
     * 
     * @param Array<String> $labels Etiquetas del gráfico (eje X).
     * @param Array<Integer> $points Puntos en el gráfico (eje Y).
     */
    private function makeBatteryGraph($labels, $points) {
        $pData = new pData();
        
        $pData->addPoints($points, "Batería");
        $pData->setAxisName(0, "% de carga");
        $pData->addPoints($labels, "Fechas");
        $pData->setSerieDescription("Fechas", "Fecha");
        $pData->setAbscissa("Fechas");
        $pData->setPalette("Batería", array("R" => 238, "G" => 144, "B" => 144));
        
        $batteryGraph = new pImage(900, 325, $pData);
        $batteryGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 6));
        $batteryGraph->setGraphArea(65, 70, 875, 225);
        $batteryGraph->drawScale(array("CycleBackground" => true, "GridR" => 200, "GridG" => 200, "GridB" => 200, "LabelRotation" => 90, "Mode" => SCALE_MODE_MANUAL, "ManualScale" => array(0 => ["Min" => 0, "Max" => 100])));
        $batteryGraph->Antialias = false;
        
        $graphSettings = array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => true, "DisplayR" => 77, "DisplayG" => 46, "DisplayB" => 46, "Gradient" => true, "InnerSurrounding" => 50, "Surrounding" => -50);
        
        $batteryGraph->drawBarChart($graphSettings);
        
        $batteryGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 9));
        $batteryGraph->drawLegend(70, 25, array("R" => 225, "G" => 225, "B" => 225, "BorderR" => 200, "BorderG" => 200, "BorderB" => 200, "FontR" => 77, "FontG" => 46, "FontB" => 46, "Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL));
        
        $batteryGraph->render("img/graph_battery.png");
    }
    
    /**
     * Genera un gráfico de barras que muestra los porcentajes de brillo
     * registrados en las distintas pruebas.
     * 
     * @param Array<String> $labels Etiquetas del gráfico (eje X).
     * @param Array<Integer> $points Puntos en el gráfico (eje Y).
     */
    private function makeBrightnessGraph($labels, $points) {
        $pData = new pData();
        
        $pData->addPoints($points, "Brillo");
        $pData->setAxisName(0, "% de brillo");
        $pData->addPoints($labels, "Fechas");
        $pData->setSerieDescription("Fechas", "Fecha");
        $pData->setAbscissa("Fechas");
        $pData->setPalette("Brillo", array("R" => 238, "G" => 144, "B" => 144));
        
        $brightnessGraph = new pImage(900, 325, $pData);
        $brightnessGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 6));
        $brightnessGraph->setGraphArea(65, 70, 875, 225);
        $brightnessGraph->drawScale(array("CycleBackground" => true, "GridR" => 200, "GridG" => 200, "GridB" => 200, "LabelRotation" => 90, "Mode" => SCALE_MODE_MANUAL, "ManualScale" => array(0 => ["Min" => 0, "Max" => 100])));
        $brightnessGraph->Antialias = false;
        
        $graphSettings = array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => true, "DisplayR" => 77, "DisplayG" => 46, "DisplayB" => 46, "Gradient" => true, "InnerSurrounding" => 50, "Surrounding" => -50);
        
        $brightnessGraph->drawBarChart($graphSettings);
        
        $brightnessGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 9));
        $brightnessGraph->drawLegend(70, 25, array("R" => 225, "G" => 225, "B" => 225, "BorderR" => 200, "BorderG" => 200, "BorderB" => 200, "FontR" => 77, "FontG" => 46, "FontB" => 46, "Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL));
        
        $brightnessGraph->render("img/graph_brightness.png");
    }
    
    /**
     * Genera un gráfico de barras que muestra la luz del entorno registrada
     * en las distintas pruebas.
     * 
     * @param Array<String> $labels Etiquetas del gráfico (eje X).
     * @param Array<Integer> $points Puntos en el gráfico (eje Y).
     */
    private function makeEnvironmentLightGraph($labels, $points) {
        $pData = new pData();
        
        $pData->addPoints($points, "Luz del entorno");
        $pData->setAxisName(0, "lx");
        $pData->addPoints($labels, "Fechas");
        $pData->setSerieDescription("Fechas", "Fecha");
        $pData->setAbscissa("Fechas");
        $pData->setPalette("Luz del entorno", array("R" => 238, "G" => 144, "B" => 144));
        
        $environmentLightGraph = new pImage(900, 325, $pData);
        $environmentLightGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 6));
        $environmentLightGraph->setGraphArea(65, 70, 875, 225);
        $environmentLightGraph->drawScale(array("CycleBackground" => true, "GridR" => 200, "GridG" => 200, "GridB" => 200, "LabelRotation" => 90, "Mode" => SCALE_MODE_MANUAL, "ManualScale" => array(0 => ["Min" => 0, "Max" => max($points)])));
        $environmentLightGraph->Antialias = false;
        
        $graphSettings = array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => true, "DisplayR" => 77, "DisplayG" => 46, "DisplayB" => 46, "Gradient" => true, "InnerSurrounding" => 50, "Surrounding" => -50);
        
        $environmentLightGraph->drawBarChart($graphSettings);
        
        $environmentLightGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 9));
        $environmentLightGraph->drawLegend(70, 25, array("R" => 225, "G" => 225, "B" => 225, "BorderR" => 200, "BorderG" => 200, "BorderB" => 200, "FontR" => 77, "FontG" => 46, "FontB" => 46, "Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL));
        
        $environmentLightGraph->render("img/graph_environment_light.png");
    }
    
    /**
     * Genera un gráfico de barras que muestra los porcentajes de uso de CPU por
     * parte de la aplicación registrados en las distintas pruebas.
     * 
     * @param Array<String> $labels Etiquetas del gráfico (eje X).
     * @param Array<Integer> $points Puntos en el gráfico (eje Y).
     */
    private function makeCPUConsumptionGraph($labels, $points) {
        $pData = new pData();
        
        $pData->addPoints($points, "Consumo de CPU");
        $pData->setAxisName(0, "% en uso");
        $pData->addPoints($labels, "Fechas");
        $pData->setSerieDescription("Fechas", "Fecha");
        $pData->setAbscissa("Fechas");
        $pData->setPalette("Consumo de CPU", array("R" => 238, "G" => 144, "B" => 144));
        
        $CPUConsumptionGraph = new pImage(900, 325, $pData);
        $CPUConsumptionGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 6));
        $CPUConsumptionGraph->setGraphArea(65, 70, 875, 225);
        $CPUConsumptionGraph->drawScale(array("CycleBackground" => true, "GridR" => 200, "GridG" => 200, "GridB" => 200, "LabelRotation" => 90, "Mode" => SCALE_MODE_MANUAL, "ManualScale" => array(0 => ["Min" => 0, "Max" => max($points)])));
        $CPUConsumptionGraph->Antialias = false;
        
        $graphSettings = array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => true, "DisplayR" => 77, "DisplayG" => 46, "DisplayB" => 46, "Gradient" => true, "InnerSurrounding" => 50, "Surrounding" => -50);
        
        $CPUConsumptionGraph->drawBarChart($graphSettings);
        
        $CPUConsumptionGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 9));
        $CPUConsumptionGraph->drawLegend(70, 25, array("R" => 225, "G" => 225, "B" => 225, "BorderR" => 200, "BorderG" => 200, "BorderB" => 200, "FontR" => 77, "FontG" => 46, "FontB" => 46, "Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL));
        
        $CPUConsumptionGraph->render("img/graph_cpu_consumption.png");
    }
    
    /**
     * Genera un gráfico de barras que muestra los cambios en el jitter
     * registrados para distintas pruebas.
     * 
     * @param Array<String> $labels Etiqu≥etas del gráfico (eje X).
     * @param Array<Integer> $points Puntos en el gráfico (eje Y).
     */
    private function makeJitterGraph($labels, $points) {
        $pData = new pData();
        
        $pData->addPoints($points, "Jitter");
        $pData->setAxisName(0, "Jitter");
        $pData->addPoints($labels, "Fechas");
        $pData->setSerieDescription("Fechas", "Fecha");
        $pData->setAbscissa("Fechas");
        $pData->setPalette("Jitter", array("R" => 238, "G" => 144, "B" => 144));
        
        $jitterGraph = new pImage(900, 325, $pData);
        $jitterGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 6));
        $jitterGraph->setGraphArea(65, 70, 875, 225);
        $jitterGraph->drawScale(array("CycleBackground" => true, "GridR" => 200, "GridG" => 200, "GridB" => 200, "LabelRotation" => 90));
        $jitterGraph->Antialias = false;
        
        $graphSettings = array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => true, "DisplayR" => 77, "DisplayG" => 46, "DisplayB" => 46, "Gradient" => true, "InnerSurrounding" => 50, "Surrounding" => -50);
        
        $jitterGraph->drawBarChart($graphSettings);
        
        $jitterGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 9));
        $jitterGraph->drawLegend(70, 25, array("R" => 225, "G" => 225, "B" => 225, "BorderR" => 200, "BorderG" => 200, "BorderB" => 200, "FontR" => 77, "FontG" => 46, "FontB" => 46, "Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL));
        
        $jitterGraph->render("img/graph_jitter.png");
    }
    
    /**
     * Genera un gráfico de barras que muestra los cambios en la latencia
     * registrados para distintas pruebas.
     * 
     * @param Array<String> $labels Etiqu≥etas del gráfico (eje X).
     * @param Array<Integer> $points Puntos en el gráfico (eje Y).
     */
    private function makeLatencyGraph($labels, $points) {
        $pData = new pData();
        
        $pData->addPoints($points, "Latencia");
        $pData->setAxisName(0, "Milisegundos (MS)");
        $pData->addPoints($labels, "Fechas");
        $pData->setSerieDescription("Fechas", "Fecha");
        $pData->setAbscissa("Fechas");
        $pData->setPalette("Latencia", array("R" => 238, "G" => 144, "B" => 144));
        
        $latencyGraph = new pImage(900, 325, $pData);
        $latencyGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 6));
        $latencyGraph->setGraphArea(65, 70, 875, 225);
        $latencyGraph->drawScale(array("CycleBackground" => true, "GridR" => 200, "GridG" => 200, "GridB" => 200, "LabelRotation" => 90));
        $latencyGraph->Antialias = false;
        
        $graphSettings = array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => true, "DisplayR" => 77, "DisplayG" => 46, "DisplayB" => 46, "Gradient" => true, "InnerSurrounding" => 50, "Surrounding" => -50);
        
        $latencyGraph->drawBarChart($graphSettings);
        
        $latencyGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 9));
        $latencyGraph->drawLegend(70, 25, array("R" => 225, "G" => 225, "B" => 225, "BorderR" => 200, "BorderG" => 200, "BorderB" => 200, "FontR" => 77, "FontG" => 46, "FontB" => 46, "Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL));
        
        $latencyGraph->render("img/graph_latency.png");
    }
    
    /**
     * Genera un gráfico de barras que muestra la cantidad de memoria usada en
     * las distintas pruebas registradas.
     * 
     * @param Array<String> $labels Etiquetas del gráfico (eje X).
     * @param Array<Integer> $points Puntos en el gráfico (eje Y).
     */
    private function makeMemConsumptionMBGraph($labels, $points) {
        $pData = new pData();
        
        $pData->addPoints($points, "Uso de memoria");
        $pData->setAxisName(0, "Memoria usada (MB)");
        $pData->addPoints($labels, "Fechas");
        $pData->setSerieDescription("Fechas", "Fecha");
        $pData->setAbscissa("Fechas");
        $pData->setPalette("Uso de memoria", array("R" => 238, "G" => 144, "B" => 144));
        
        $userPerceivedLatencyGraph = new pImage(900, 325, $pData);
        $userPerceivedLatencyGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 6));
        $userPerceivedLatencyGraph->setGraphArea(65, 70, 875, 225);
        $userPerceivedLatencyGraph->drawScale(array("CycleBackground" => true, "GridR" => 200, "GridG" => 200, "GridB" => 200, "LabelRotation" => 90, "Mode" => SCALE_MODE_MANUAL, "ManualScale" => array(0 => ["Min" => 0, "Max" => max($points)])));
        $userPerceivedLatencyGraph->Antialias = false;
        
        $graphSettings = array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => true, "DisplayR" => 77, "DisplayG" => 46, "DisplayB" => 46, "Gradient" => true, "InnerSurrounding" => 50, "Surrounding" => -50);
        
        $userPerceivedLatencyGraph->drawBarChart($graphSettings);
        
        $userPerceivedLatencyGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 9));
        $userPerceivedLatencyGraph->drawLegend(70, 25, array("R" => 225, "G" => 225, "B" => 225, "BorderR" => 200, "BorderG" => 200, "BorderB" => 200, "FontR" => 77, "FontG" => 46, "FontB" => 46, "Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL));
        
        $userPerceivedLatencyGraph->render("img/graph_mem_consumption_mb.png");
    }
    
    /**
     * Genera un gráfico de barras que muestra los porcentajes de uso de memoria
     * registrados en las distintas pruebas.
     * 
     * @param Array<String> $labels Etiquetas del gráfico (eje X).
     * @param Array<Integer> $points Puntos en el gráfico (eje Y).
     */
    private function makeMemConsumptionPercentageGraph($labels, $points) {
        $pData = new pData();
        
        $pData->addPoints($points, "Uso de memoria");
        $pData->setAxisName(0, "% usado");
        $pData->addPoints($labels, "Fechas");
        $pData->setSerieDescription("Fechas", "Fecha");
        $pData->setAbscissa("Fechas");
        $pData->setPalette("Uso de memoria", array("R" => 238, "G" => 144, "B" => 144));
        
        $batteryGraph = new pImage(900, 325, $pData);
        $batteryGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 6));
        $batteryGraph->setGraphArea(65, 70, 875, 225);
        $batteryGraph->drawScale(array("CycleBackground" => true, "GridR" => 200, "GridG" => 200, "GridB" => 200, "LabelRotation" => 90, "Mode" => SCALE_MODE_MANUAL, "ManualScale" => array(0 => ["Min" => 0, "Max" => 100])));
        $batteryGraph->Antialias = false;
        
        $graphSettings = array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => true, "DisplayR" => 77, "DisplayG" => 46, "DisplayB" => 46, "Gradient" => true, "InnerSurrounding" => 50, "Surrounding" => -50);
        
        $batteryGraph->drawBarChart($graphSettings);
        
        $batteryGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 9));
        $batteryGraph->drawLegend(70, 25, array("R" => 225, "G" => 225, "B" => 225, "BorderR" => 200, "BorderG" => 200, "BorderB" => 200, "FontR" => 77, "FontG" => 46, "FontB" => 46, "Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL));
        
        $batteryGraph->render("img/graph_mem_consumption_percentage.png");
    }
    
    /**
     * Genera un gráfico de barras que muestra la latencia percibida por el
     * usuario (en segundos) en las distintas pruebas.
     * 
     * @param Array<String> $labels Etiquetas del gráfico (eje X).
     * @param Array<Integer> $points Puntos en el gráfico (eje Y).
     */
    private function makeUserPerceivedLatencyGraph($labels, $points) {
        $pData = new pData();
        
        $pData->addPoints($points, "Latencia percibida por el usuario");
        $pData->setAxisName(0, "Segundos");
        $pData->addPoints($labels, "Fechas");
        $pData->setSerieDescription("Fechas", "Fecha");
        $pData->setAbscissa("Fechas");
        $pData->setPalette("Latencia percibida por el usuario", array("R" => 238, "G" => 144, "B" => 144));
        
        $userPerceivedLatencyGraph = new pImage(900, 325, $pData);
        $userPerceivedLatencyGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 6));
        $userPerceivedLatencyGraph->setGraphArea(65, 70, 875, 225);
        $userPerceivedLatencyGraph->drawScale(array("CycleBackground" => true, "GridR" => 200, "GridG" => 200, "GridB" => 200, "LabelRotation" => 90, "Mode" => SCALE_MODE_MANUAL, "ManualScale" => array(0 => ["Min" => 0, "Max" => max($points)])));
        $userPerceivedLatencyGraph->Antialias = false;
        
        $graphSettings = array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => true, "DisplayR" => 77, "DisplayG" => 46, "DisplayB" => 46, "Gradient" => true, "InnerSurrounding" => 50, "Surrounding" => -50);
        
        $userPerceivedLatencyGraph->drawBarChart($graphSettings);
        
        $userPerceivedLatencyGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 9));
        $userPerceivedLatencyGraph->drawLegend(70, 25, array("R" => 225, "G" => 225, "B" => 225, "BorderR" => 200, "BorderG" => 200, "BorderB" => 200, "FontR" => 77, "FontG" => 46, "FontB" => 46, "Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL));
        
        $userPerceivedLatencyGraph->render("img/graph_user_latency.png");
    }
    
    /**
     * Genera un gráfico de barras que muestra las calificaciones que el usuario
     * seleccionó para distintas pruebas.
     * 
     * @param Array<String> $labels Etiquetas del gráfico (eje X).
     * @param Array<Integer> $points Puntos en el gráfico (eje Y).
     */
    private function makeUserScoreGraph($labels, $points) {
        $pData = new pData();
        
        $pData->addPoints($points, "Calificación del usuario");
        $pData->setAxisName(0, "Calificación (del 1 al 3)");
        $pData->addPoints($labels, "Fechas");
        $pData->setSerieDescription("Fechas", "Fecha");
        $pData->setAbscissa("Fechas");
        $pData->setPalette("Calificación del usuario", array("R" => 50, "G" => 175, "B" => 50));
        
        $userScoreGraph = new pImage(900, 325, $pData);
        $userScoreGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 6));
        $userScoreGraph->setGraphArea(65, 70, 875, 225);
        $userScoreGraph->drawScale(array("CycleBackground" => true, "GridR" => 200, "GridG" => 200, "GridB" => 200, "MinDivHeight" => 40, "LabelRotation" => 90, "Mode" => SCALE_MODE_MANUAL, "ManualScale" => array(0 => ["Min" => 0, "Max" => 3])));
        $userScoreGraph->Antialias = false;
        
        $graphSettings = array("Gradient" => true, "InnerSurrounding" => 30, "Surrounding" => -30);
        
        $userScoreGraph->drawBarChart($graphSettings);
        
        $userScoreGraph->setFontProperties(array("FontName" => getcwd() . "/lib/pChart/fonts/verdana.ttf", "FontSize" => 9));
        $userScoreGraph->drawLegend(70, 25, array("R" => 225, "G" => 225, "B" => 225, "BorderR" => 200, "BorderG" => 200, "BorderB" => 200, "FontR" => 22, "FontG" => 77, "FontB" => 22, "Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL));
        
        $userScoreGraph->render("img/graph_user_score.png");
    }
    
    /**
     * Genera el siguiente conjunto de gráficos:
     * • Porcentaje de batería.
     * • Calificación del usuario.
     * 
     * @param String $uuid UUID del usuario para el cual se generarán los
     * gráficos.
     */
    function drawBatteryScoreGraph($uuid) {
        $result = $this->DBHandler->fetchIndicatorByUUID($uuid, Constants::INDICATOR_BATTERY);
        
        if ($result->num_rows > 0) {
            /* Variables para los gráficos: */
            $pointsForBattery = array();
            $pointsForScore = array();
            $labelsForPoints = array();
            $quantityOfTests = 0;

            while ($row = $result->fetch_object()) {
                array_push($pointsForBattery, $row->value);

                switch ($row->score) {
                    case Constants::SCORE_0:
                        array_push($pointsForScore, 1);
                        
                        if (!isset ($promedio_0)) {
                            $promedio_0 = 0;
                            $cantidad_0 = 0;
                        }
                        
                        $promedio_0 = $promedio_0 + $row->value;
                        $cantidad_0++;

                        break;
                    case Constants::SCORE_1:
                        array_push($pointsForScore, 2);
                        
                        if (!isset ($promedio_1)) {
                            $promedio_1 = 0;
                            $cantidad_1 = 0;
                        }
                        
                        $promedio_1 = $promedio_1 + $row->value;
                        $cantidad_1++;

                        break;
                    case Constants::SCORE_2:
                        array_push($pointsForScore, 3);
                        
                        if (!isset ($promedio_2)) {
                            $promedio_2 = 0;
                            $cantidad_2 = 0;
                        }
                        
                        $promedio_2 = $promedio_2 + $row->value;
                        $cantidad_2++;

                        break;
                }

                array_push($labelsForPoints, date_format(date_create($row->dateTime), "d/m/y H:i"));
                $quantityOfTests++;
            }

            /* Se arma el gráfico para los porcentajes de de carga de la batería (QoE): */
            $this->makeBatteryGraph($labelsForPoints, $pointsForBattery);

            /* Se arma el gráfico para la calificación del usuario (QoE): */
            $this->makeUserScoreGraph($labelsForPoints, $pointsForScore);

            print '<div class="contenedor-graficos">';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Porcentaje de batería; con ' . $quantityOfTests . ' pruebas)" class="grafico" src="img/graph_battery.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Porcentaje de batería; con ' . $quantityOfTests . ' pruebas)">';
            print '<div class="versus">VS</div>';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de porcentaje de batería)" class="grafico" src="img/graph_user_score.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de porcentaje de batería)">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>1</strong>: La experiencia fue <strong>' . Constants::SCORE_0 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>2</strong>: La experiencia fue <strong>' . Constants::SCORE_1 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>3</strong>: La experiencia fue <strong>' . Constants::SCORE_2 . '</strong>.';
            print '</p>';
            print '<p class="referencia">';
            print '<strong>Información sobre estos gráficos:</strong>';
            
            if (isset ($promedio_0)) {
                $promedio_0 = round($promedio_0 / $cantidad_0, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), el porcentaje de batería promedio fue de <strong>' . $promedio_0 . '%</strong>.';
            }
            
            if (isset ($promedio_1)) {
                $promedio_1 = round($promedio_1 / $cantidad_1, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), el porcentaje de batería promedio fue de <strong>' . $promedio_1 . '%</strong>.';
            }
            
            if (isset ($promedio_2)) {
                $promedio_2 = round($promedio_2 / $cantidad_2, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), el porcentaje de batería promedio fue de <strong>' . $promedio_2 . '%</strong>.';
            }
            
            print '</p>';
            print '</div>';
        } else {
            print '<div class="alert alert-warning" role="alert">';
            print 'No hay registros de la métrica <strong>' . Constants::INDICATOR_BATTERY . '</strong> para el usuario ' . substr($uuid, 8) . ' en la base de datos.';
            print '</div>';
        }
    }
    
    /**
     * Genera el siguiente conjunto de gráficos:
     * • Brillo.
     * • Calificación del usuario.
     * 
     * @param String $uuid UUID del usuario para el cual se generarán los
     * gráficos.
     */
    function drawBrightnessScoreGraph($uuid) {
        $result = $this->DBHandler->fetchIndicatorByUUID($uuid, Constants::INDICATOR_BRIGHTNESS);
        
        
        if ($result->num_rows > 0) {
            /* Variables para los gráficos: */
            $pointsForBrightness = array();
            $pointsForScore = array();
            $labelsForPoints = array();
            $quantityOfTests = 0;

            while ($row = $result->fetch_object()) {
                array_push($pointsForBrightness, $row->value);

                switch ($row->score) {
                    case Constants::SCORE_0:
                        array_push($pointsForScore, 1);
                        
                        if (!isset ($promedio_0)) {
                            $promedio_0 = 0;
                            $cantidad_0 = 0;
                        }
                        
                        $promedio_0 = $promedio_0 + $row->value;
                        $cantidad_0++;

                        break;
                    case Constants::SCORE_1:
                        array_push($pointsForScore, 2);
                        
                        if (!isset ($promedio_1)) {
                            $promedio_1 = 0;
                            $cantidad_1 = 0;
                        }
                        
                        $promedio_1 = $promedio_1 + $row->value;
                        $cantidad_1++;

                        break;
                    case Constants::SCORE_2:
                        array_push($pointsForScore, 3);
                        
                        if (!isset ($promedio_2)) {
                            $promedio_2 = 0;
                            $cantidad_2 = 0;
                        }
                        
                        $promedio_2 = $promedio_2 + $row->value;
                        $cantidad_2++;

                        break;
                }

                array_push($labelsForPoints, date_format(date_create($row->dateTime), "d/m/y H:i"));
                $quantityOfTests++;
            }

            /* Se arma el gráfico para los porcentajes brillo (QoE): */
            $this->makeBrightnessGraph($labelsForPoints, $pointsForBrightness);

            /* Se arma el gráfico para la calificación del usuario (QoE): */
            $this->makeUserScoreGraph($labelsForPoints, $pointsForScore);

            print '<div class="contenedor-graficos">';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Brillo; con ' . $quantityOfTests . ' pruebas)" class="grafico" src="img/graph_brightness.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Brillo; con ' . $quantityOfTests . ' pruebas)">';
            print '<div class="versus">VS</div>';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de brillo)" class="grafico" src="img/graph_user_score.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de brillo)">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>1</strong>: La experiencia fue <strong>' . Constants::SCORE_0 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>2</strong>: La experiencia fue <strong>' . Constants::SCORE_1 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>3</strong>: La experiencia fue <strong>' . Constants::SCORE_2 . '</strong>.';
            print '</p>';
            print '<p class="referencia">';
            print '<strong>Información sobre estos gráficos:</strong>';
            
            if (isset ($promedio_0)) {
                $promedio_0 = round($promedio_0 / $cantidad_0, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), el porcentaje de brillo promedio fue de <strong>' . $promedio_0 . '%</strong>.';
            }
            
            if (isset ($promedio_1)) {
                $promedio_1 = round($promedio_1 / $cantidad_1, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), el porcentaje de brillo promedio fue de <strong>' . $promedio_1 . '%</strong>.';
            }
            
            if (isset ($promedio_2)) {
                $promedio_2 = round($promedio_2 / $cantidad_2, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), el porcentaje de brillo promedio fue de <strong>' . $promedio_2 . '%</strong>.';
            }
            
            print '</p>';
            print '</div>';
        } else {
            print '<div class="alert alert-warning" role="alert">';
            print 'No hay registros de la métrica <strong>' . Constants::INDICATOR_BRIGHTNESS . '</strong> para el usuario ' . substr($uuid, 8) . ' en la base de datos.';
            print '</div>';
        }
    }
    
    /**
     * Genera el siguiente conjunto de gráficos:
     * • Consumo de CPU.
     * • Calificación del usuario.
     * 
     * @param String $uuid UUID del usuario para el cual se generarán los
     * gráficos.
     */
    function drawCPUConsumptionScoreGraph($uuid) {
        $result = $this->DBHandler->fetchIndicatorByUUID($uuid, Constants::INDICATOR_CPU_PERCENTAGE);
        
        if ($result->num_rows > 0) {
            /* Variables para los gráficos: */
            $pointsForCPUConsumption = array();
            $pointsForScore = array();
            $labelsForPoints = array();
            $quantityOfTests = 0;

            while ($row = $result->fetch_object()) {
                array_push($pointsForCPUConsumption, $row->value);

                switch ($row->score) {
                    case Constants::SCORE_0:
                        array_push($pointsForScore, 1);
                        
                        if (!isset ($promedio_0)) {
                            $promedio_0 = 0;
                            $cantidad_0 = 0;
                        }
                        
                        $promedio_0 = $promedio_0 + $row->value;
                        $cantidad_0++;

                        break;
                    case Constants::SCORE_1:
                        array_push($pointsForScore, 2);
                        
                        if (!isset ($promedio_1)) {
                            $promedio_1 = 0;
                            $cantidad_1 = 0;
                        }
                        
                        $promedio_1 = $promedio_1 + $row->value;
                        $cantidad_1++;

                        break;
                    case Constants::SCORE_2:
                        array_push($pointsForScore, 3);
                        
                        if (!isset ($promedio_2)) {
                            $promedio_2 = 0;
                            $cantidad_2 = 0;
                        }
                        
                        $promedio_2 = $promedio_2 + $row->value;
                        $cantidad_2++;

                        break;
                }

                array_push($labelsForPoints, date_format(date_create($row->dateTime), "d/m/y H:i"));
                $quantityOfTests++;
            }

            /* Se arma el gráfico para los porcentajes de uso de CPU (QoE): */
            $this->makeCPUConsumptionGraph($labelsForPoints, $pointsForCPUConsumption);

            /* Se arma el gráfico para la calificación del usuario (QoE): */
            $this->makeUserScoreGraph($labelsForPoints, $pointsForScore);

            print '<div class="contenedor-graficos">';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Consumo de CPU; con ' . $quantityOfTests . ' pruebas)" class="grafico" src="img/graph_cpu_consumption.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Consumo de CPU; con ' . $quantityOfTests . ' pruebas)">';
            print '<div class="versus">VS</div>';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de consumo de CPU)" class="grafico" src="img/graph_user_score.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de consumo de CPU)">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>1</strong>: La experiencia fue <strong>' . Constants::SCORE_0 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>2</strong>: La experiencia fue <strong>' . Constants::SCORE_1 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>3</strong>: La experiencia fue <strong>' . Constants::SCORE_2 . '</strong>.';
            print '</p>';
            print '<p class="referencia">';
            print '<strong>Información sobre estos gráficos:</strong>';
            
            if (isset ($promedio_0)) {
                $promedio_0 = round($promedio_0 / $cantidad_0, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), el consumo de CPU promedio fue de <strong>' . $promedio_0 . '%</strong>.';
            }
            
            if (isset ($promedio_1)) {
                $promedio_1 = round($promedio_1 / $cantidad_1, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), el consumo de CPU promedio fue de <strong>' . $promedio_1 . '%</strong>.';
            }
            
            if (isset ($promedio_2)) {
                $promedio_2 = round($promedio_2 / $cantidad_2, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), el consumo de CPU promedio fue de <strong>' . $promedio_2 . '%</strong>.';
            }
            
            print '</p>';
            print '</div>';
        } else {
            print '<div class="alert alert-warning" role="alert">';
            print 'No hay registros de la métrica <strong>' . Constants::INDICATOR_CPU_PERCENTAGE . '</strong> para el usuario ' . substr($uuid, 8) . ' en la base de datos.';
            print '</div>';
        }
    }
    
    /**
     * Genera el siguiente conjunto de gráficos:
     * • Luz del entorno (lux).
     * • Calificación del usuario.
     * 
     * @param String $uuid UUID del usuario para el cual se generarán los
     * gráficos.
     */
    function drawEnvironmentLightScoreGraph($uuid) {
        $result = $this->DBHandler->fetchIndicatorByUUID($uuid, Constants::INDICATOR_ENVIRONMENT_LIGHT);
        
        if ($result->num_rows > 0) {
            /* Variables para los gráficos: */
            $pointsForEnvironmentLight = array();
            $pointsForScore = array();
            $labelsForPoints = array();
            $quantityOfTests = 0;

            while ($row = $result->fetch_object()) {
                array_push($pointsForEnvironmentLight, $row->value);

                switch ($row->score) {
                    case Constants::SCORE_0:
                        array_push($pointsForScore, 1);
                        
                        if (!isset ($promedio_0)) {
                            $promedio_0 = 0;
                            $cantidad_0 = 0;
                        }
                        
                        $promedio_0 = $promedio_0 + $row->value;
                        $cantidad_0++;

                        break;
                    case Constants::SCORE_1:
                        array_push($pointsForScore, 2);
                        
                        if (!isset ($promedio_1)) {
                            $promedio_1 = 0;
                            $cantidad_1 = 0;
                        }
                        
                        $promedio_1 = $promedio_1 + $row->value;
                        $cantidad_1++;

                        break;
                    case Constants::SCORE_2:
                        array_push($pointsForScore, 3);
                        
                        if (!isset ($promedio_2)) {
                            $promedio_2 = 0;
                            $cantidad_2 = 0;
                        }
                        
                        $promedio_2 = $promedio_2 + $row->value;
                        $cantidad_2++;

                        break;
                }

                array_push($labelsForPoints, date_format(date_create($row->dateTime), "d/m/y H:i"));
                $quantityOfTests++;
            }

            /* Se arma el gráfico para la luz del entorno (QoE): */
            $this->makeEnvironmentLightGraph($labelsForPoints, $pointsForEnvironmentLight);

            /* Se arma el gráfico para la calificación del usuario (QoE): */
            $this->makeUserScoreGraph($labelsForPoints, $pointsForScore);

            print '<div class="contenedor-graficos">';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Luz del entorno; con ' . $quantityOfTests . ' pruebas)" class="grafico" src="img/graph_environment_light.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Luz del entorno; con ' . $quantityOfTests . ' pruebas)">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #ee9090">LUZ DEL ENTORNO</strong> < <strong>3 lx</strong>: Luz del entorno como la del cielo nocturno.<br/>';
            print '• <strong>3 lx</strong> ≤ <strong class="metrica" style="color: #ee9090">LUZ DEL ENTORNO</strong> < <strong>100 lx</strong>: Luz del entorno como la de un crepúsculo con cielo despejado.<br/>';
            print '• <strong>100 lx</strong> ≤ <strong class="metrica" style="color: #ee9090">LUZ DEL ENTORNO</strong> < <strong>300 lx</strong>: Luz del entorno como la de un pasillo en una zona de paso.<br/>';
            print '• <strong>300 lx</strong> ≤ <strong class="metrica" style="color: #ee9090">LUZ DEL ENTORNO</strong> < <strong>500 lx</strong>: Luz del entorno como la de una sala de reuniones.<br/>';
            print '• <strong>500 lx</strong> ≤ <strong class="metrica" style="color: #ee9090">LUZ DEL ENTORNO</strong> < <strong>600 lx</strong>: Luz del entorno como la de una oficina bien iluminada.<br/>';
            print '• <strong>600 lx</strong> ≤ <strong class="metrica" style="color: #ee9090">LUZ DEL ENTORNO</strong> < <strong>1000 lx</strong>: Luz del entorno como la de un amanecer/puesta de sol con cielo despejado.<br/>';
            print '• <strong>1000 lx</strong> ≤ <strong class="metrica" style="color: #ee9090">LUZ DEL ENTORNO</strong> < <strong>32000 lx</strong>: Luz del entorno como la habitual en un estudio de televisión.<br/>';
            print '• <strong>32000 lx</strong> ≤ <strong class="metrica" style="color: #ee9090">LUZ DEL ENTORNO</strong> ≤ <strong>100000 lx</strong>: Luz del entorno como la de un día soleado.';
            print '</p>';
            print '<div class="versus">VS</div>';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de luz del entorno)" class="grafico" src="img/graph_user_score.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de luz del entorno)">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>1</strong>: La experiencia fue <strong>' . Constants::SCORE_0 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>2</strong>: La experiencia fue <strong>' . Constants::SCORE_1 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>3</strong>: La experiencia fue <strong>' . Constants::SCORE_2 . '</strong>.';
            print '</p>';
            print '<p class="referencia">';
            print '<strong>Información sobre estos gráficos:</strong>';
            
            if (isset ($promedio_0)) {
                $promedio_0 = round($promedio_0 / $cantidad_0, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), la iluminación del entorno promedio fue de <strong>' . $promedio_0 . ' lux</strong>.';
            }
            
            if (isset ($promedio_1)) {
                $promedio_1 = round($promedio_1 / $cantidad_1, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), la iluminación del entorno promedio fue de <strong>' . $promedio_1 . ' lux</strong>.';
            }
            
            if (isset ($promedio_2)) {
                $promedio_2 = round($promedio_2 / $cantidad_2, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), la iluminación del entorno promedio fue de <strong>' . $promedio_2 . ' lux</strong>.';
            }
            
            print '</p>';
            print '</div>';
        } else {
            print '<div class="alert alert-warning" role="alert">';
            print 'No hay registros de la métrica <strong>' . Constants::INDICATOR_ENVIRONMENT_LIGHT . '</strong> para el usuario ' . substr($uuid, 8) . ' en la base de datos.';
            print '</div>';
        }
    }
    
    /**
     * Genera el siguiente conjunto de gráficos:
     * • Latencia.
     * • Calificación del usuario.
     * 
     * @param String $uuid UUID del usuario para el cual se generarán los
     * gráficos.
     */
    function drawLatencyScoreGraph($uuid) {
        $result = $this->DBHandler->fetchIndicatorByUUID($uuid, Constants::INDICATOR_LATENCY);
        
        if ($result->num_rows > 0) {
            /* Variables para los gráficos: */
            $pointsForLatency = array();
            $pointsForScore = array();
            $labelsForPoints = array();
            $quantityOfTests = 0;

            while ($row = $result->fetch_object()) {
                array_push($pointsForLatency, $row->value);

                switch ($row->score) {
                    case Constants::SCORE_0:
                        array_push($pointsForScore, 1);
                        
                        if ($row->value != -1) {
                            if (!isset ($promedio_0)) {
                                $promedio_0 = 0;
                                $cantidad_0 = 0;
                            }

                            $promedio_0 = $promedio_0 + $row->value;
                            $cantidad_0++;
                        } else {
                            if (!isset ($cantidad_0_sin_respuesta)) {
                                $cantidad_0_sin_respuesta = 0;
                            }
                            
                            $cantidad_0_sin_respuesta++;
                        }

                        break;
                    case Constants::SCORE_1:
                        array_push($pointsForScore, 2);
                        
                        if ($row->value != -1) {
                            if (!isset ($promedio_1)) {
                                $promedio_1 = 0;
                                $cantidad_1 = 0;
                            }

                            $promedio_1 = $promedio_1 + $row->value;
                            $cantidad_1++;
                        } else {
                            if (!isset ($cantidad_1_sin_respuesta)) {
                                $cantidad_1_sin_respuesta = 0;
                            }
                            
                            $cantidad_1_sin_respuesta++;
                        }

                        break;
                    case Constants::SCORE_2:
                        array_push($pointsForScore, 3);
                        
                        if ($row->value != -1) {
                            if (!isset ($promedio_2)) {
                                $promedio_2 = 0;
                                $cantidad_2 = 0;
                            }

                            $promedio_2 = $promedio_2 + $row->value;
                            $cantidad_2++;
                        } else {
                            if (!isset ($cantidad_2_sin_respuesta)) {
                                $cantidad_2_sin_respuesta = 0;
                            }
                            
                            $cantidad_2_sin_respuesta++;
                        }

                        break;
                }

                array_push($labelsForPoints, date_format(date_create($row->dateTime), "d/m/y H:i"));
                $quantityOfTests++;
            }

            /* Se arma el gráfico para la latencia (QoS): */
            $this->makeLatencyGraph($labelsForPoints, $pointsForLatency);

            /* Se arma el gráfico para la calificación del usuario (QoE): */
            $this->makeUserScoreGraph($labelsForPoints, $pointsForScore);

            print '<div class="contenedor-graficos">';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Latencia; con ' . $quantityOfTests . ' pruebas)" class="grafico" src="img/graph_latency.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Latencia; con ' . $quantityOfTests . ' pruebas)">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #ee9090">LATENCIA</strong> igual a <strong>-1</strong>: No se obtuvo respuesta del host.<br/>';
            print '• <strong class="metrica" style="color: #ee9090">LATENCIA</strong> < <strong>100 ms</strong>: Es considerada <strong>buena</strong>.<br/>';
            print '• <strong>100 ms</strong> ≤ <strong class="metrica" style="color: #ee9090">LATENCIA</strong> ≤ <strong>200 ms</strong>: Es considerada <strong>regular</strong>.<br/>';
            print '• <strong class="metrica" style="color: #ee9090">LATENCIA</strong> > <strong>200 ms</strong>: Es considerada <strong>mala</strong>.';
            print '</p>';
            print '<div class="versus">VS</div>';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de latencia)" class="grafico" src="img/graph_user_score.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de latencia)">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>1</strong>: La experiencia fue <strong>' . Constants::SCORE_0 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>2</strong>: La experiencia fue <strong>' . Constants::SCORE_1 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>3</strong>: La experiencia fue <strong>' . Constants::SCORE_2 . '</strong>.';
            print '</p>';
            print '<p class="referencia">';
            print '<strong>Información sobre estos gráficos:</strong>';
            
            if (isset ($cantidad_0_sin_respuesta) || isset ($promedio_0)) {
                if (isset ($cantidad_0_sin_respuesta) && !isset ($promedio_0)) { // No se obtuvo respuesta del host en ninguna de las pruebas.
                    print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), no se obtuvo respuesta del host en ninguna de las pruebas que se realizaron (' . $cantidad_0_sin_respuesta . ' en total).';
                } else if (isset ($cantidad_0_sin_respuesta) && isset ($promedio_0)) { // No se obtuvo respuesta del host en algunas pruebas.
                    $promedio_0 = round($promedio_0 / $cantidad_0, 2);

                    print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), la latencia promedio fue de <strong>' . $promedio_0 . ' MS</strong> y hubieron <strong>' . $cantidad_0_sin_respuesta . ' casos</strong> en los que no se obtuvo respuesta del host.';
                } else { // Se obtuvo respuesta del host en todas las pruebas.
                    $promedio_0 = round($promedio_0 / $cantidad_0, 2);

                    print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), la latencia promedio fue de <strong>' . $promedio_0 . ' MS</strong>.';
                }
            }
            
            
            if (isset ($cantidad_1_sin_respuesta) || isset ($promedio_1)) {
                if (isset ($cantidad_1_sin_respuesta) && !isset ($promedio_1)) { // No se obtuvo respuesta del host en ninguna de las pruebas.
                    print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), no se obtuvo respuesta del host en ninguna de las pruebas que se realizaron (' . $cantidad_1_sin_respuesta . ' en total).';
                } else if (isset ($cantidad_1_sin_respuesta) && isset ($promedio_1)) { // No se obtuvo respuesta del host en algunas pruebas.
                    $promedio_1 = round($promedio_1 / $cantidad_1, 2);

                    print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), la latencia promedio fue de <strong>' . $promedio_1 . ' MS</strong> y hubieron <strong>' . $cantidad_1_sin_respuesta . ' casos</strong> en los que no se obtuvo respuesta del host.';
                } else { // Se obtuvo respuesta del host en todas las pruebas.
                    $promedio_1 = round($promedio_1 / $cantidad_1, 2);

                    print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), la latencia promedio fue de <strong>' . $promedio_1 . ' MS</strong>.';
                }
            }
            
            if (isset ($cantidad_1_sin_respuesta) || isset ($promedio_1)) {
                if (isset ($cantidad_2_sin_respuesta) && !isset ($promedio_2)) { // No se obtuvo respuesta del host en ninguna de las pruebas.
                    print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), no se obtuvo respuesta del host en ninguna de las pruebas que se realizaron (' . $cantidad_2_sin_respuesta . ' en total).';
                } else if (isset ($cantidad_2_sin_respuesta) && isset ($promedio_2)) { // No se obtuvo respuesta del host en algunas pruebas.
                    $promedio_2 = round($promedio_2 / $cantidad_2, 2);

                    print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), la latencia promedio fue de <strong>' . $promedio_2 . ' MS</strong> y hubieron <strong>' . $cantidad_2_sin_respuesta . ' casos</strong> en los que no se obtuvo respuesta del host.';
                } else { // Se obtuvo respuesta del host en todas las pruebas.
                    $promedio_2 = round($promedio_2 / $cantidad_2, 2);

                    print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), la latencia promedio fue de <strong>' . $promedio_2 . ' MS</strong>.';
                }
            }
            
            print '</p>';
            print '</div>';
        } else {
            print '<div class="alert alert-warning" role="alert">';
            print 'No hay registros de la métrica <strong>' . Constants::INDICATOR_LATENCY . '</strong> para el usuario ' . substr($uuid, 8) . ' en la base de datos.';
            print '</div>';
        }
    }
    
    /**
     * Genera el siguiente conjunto de gráficos:
     * • Consumo de memoria (MB).
     * • Calificación del usuario.
     * 
     * @param String $uuid UUID del usuario para el cual se generarán los
     * gráficos.
     */
    function drawMemConsumptionMBScoreGraph($uuid) {
        $result = $this->DBHandler->fetchIndicatorByUUID($uuid, Constants::INDICATOR_MEMORY_MB);
        
        if ($result->num_rows > 0) {
            /* Variables para los gráficos: */
            $pointsForMemConsumption = array();
            $pointsForScore = array();
            $labelsForPoints = array();
            $quantityOfTests = 0;

            while ($row = $result->fetch_object()) {
                array_push($pointsForMemConsumption, $row->value);

                switch ($row->score) {
                    case Constants::SCORE_0:
                        array_push($pointsForScore, 1);
                        
                        if (!isset ($promedio_0)) {
                            $promedio_0 = 0;
                            $cantidad_0 = 0;
                        }
                        
                        $promedio_0 = $promedio_0 + $row->value;
                        $cantidad_0++;

                        break;
                    case Constants::SCORE_1:
                        array_push($pointsForScore, 2);
                        
                        if (!isset ($promedio_1)) {
                            $promedio_1 = 0;
                            $cantidad_1 = 0;
                        }
                        
                        $promedio_1 = $promedio_1 + $row->value;
                        $cantidad_1++;

                        break;
                    case Constants::SCORE_2:
                        array_push($pointsForScore, 3);
                        
                        if (!isset ($promedio_2)) {
                            $promedio_2 = 0;
                            $cantidad_2 = 0;
                        }
                        
                        $promedio_2 = $promedio_2 + $row->value;
                        $cantidad_2++;

                        break;
                }

                array_push($labelsForPoints, date_format(date_create($row->dateTime), "d/m/y H:i"));
                $quantityOfTests++;
            }

            /* Se arma el gráfico para el consumo de memoria expresado en porcentajes (QoE): */
            $this->makeMemConsumptionMBGraph($labelsForPoints, $pointsForMemConsumption);

            /* Se arma el gráfico para la calificación del usuario (QoE): */
            $this->makeUserScoreGraph($labelsForPoints, $pointsForScore);

            print '<div class="contenedor-graficos">';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Uso de memoria [MB]; con ' . $quantityOfTests . ' pruebas)" class="grafico" src="img/graph_mem_consumption_mb.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Uso de memoria [MB]; con ' . $quantityOfTests . ' pruebas)">';
            print '<div class="versus">VS</div>';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de uso de memoria [MB])" class="grafico" src="img/graph_user_score.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de uso de memoria [MB])">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>1</strong>: La experiencia fue <strong>' . Constants::SCORE_0 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>2</strong>: La experiencia fue <strong>' . Constants::SCORE_1 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>3</strong>: La experiencia fue <strong>' . Constants::SCORE_2 . '</strong>.';
            print '</p>';
            print '<p class="referencia">';
            print '<strong>Información sobre estos gráficos:</strong>';
            
            if (isset ($promedio_0)) {
                $promedio_0 = round($promedio_0 / $cantidad_0, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), el consumo de memoria promedio fue de <strong>' . $promedio_0 . ' MB</strong>.';
            }
            
            if (isset ($promedio_1)) {
                $promedio_1 = round($promedio_1 / $cantidad_1, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), el consumo de memoria promedio fue de <strong>' . $promedio_1 . ' MB</strong>.';
            }
            
            if (isset ($promedio_2)) {
                $promedio_2 = round($promedio_2 / $cantidad_2, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), el consumo de memoria promedio fue de <strong>' . $promedio_2 . ' MB</strong>.';
            }
            
            print '</p>';
            print '</div>';
        } else {
            print '<div class="alert alert-warning" role="alert">';
            print 'No hay registros de la métrica <strong>' . Constants::INDICATOR_MEMORY_MB . '</strong> para el usuario ' . substr($uuid, 8) . ' en la base de datos.';
            print '</div>';
        }
    }
    
    /**
     * Genera el siguiente conjunto de gráficos:
     * • Consumo de memoria (%).
     * • Calificación del usuario.
     * 
     * @param String $uuid UUID del usuario para el cual se generarán los
     * gráficos.
     */
    function drawMemConsumptionPercentageScoreGraph($uuid) {
        $result = $this->DBHandler->fetchIndicatorByUUID($uuid, Constants::INDICATOR_MEMORY_PERCENTAGE);
        
        if ($result->num_rows > 0) {
            /* Variables para los gráficos: */
            $pointsForMemConsumption = array();
            $pointsForScore = array();
            $labelsForPoints = array();
            $quantityOfTests = 0;

            while ($row = $result->fetch_object()) {
                array_push($pointsForMemConsumption, round($row->value, 2));

                switch ($row->score) {
                    case Constants::SCORE_0:
                        array_push($pointsForScore, 1);
                        
                        if (!isset ($promedio_0)) {
                            $promedio_0 = 0;
                            $cantidad_0 = 0;
                        }
                        
                        $promedio_0 = $promedio_0 + $row->value;
                        $cantidad_0++;

                        break;
                    case Constants::SCORE_1:
                        array_push($pointsForScore, 2);
                        
                        if (!isset ($promedio_1)) {
                            $promedio_1 = 0;
                            $cantidad_1 = 0;
                        }
                        
                        $promedio_1 = $promedio_1 + $row->value;
                        $cantidad_1++;

                        break;
                    case Constants::SCORE_2:
                        array_push($pointsForScore, 3);
                        
                        if (!isset ($promedio_2)) {
                            $promedio_2 = 0;
                            $cantidad_2 = 0;
                        }
                        
                        $promedio_2 = $promedio_2 + $row->value;
                        $cantidad_2++;

                        break;
                }

                array_push($labelsForPoints, date_format(date_create($row->dateTime), "d/m/y H:i"));
                $quantityOfTests++;
            }

            /* Se arma el gráfico para el consumo de memoria expresado en porcentajes (QoE): */
            $this->makeMemConsumptionPercentageGraph($labelsForPoints, $pointsForMemConsumption);

            /* Se arma el gráfico para la calificación del usuario (QoE): */
            $this->makeUserScoreGraph($labelsForPoints, $pointsForScore);

            print '<div class="contenedor-graficos">';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Uso de memoria [%]; con ' . $quantityOfTests . ' pruebas)" class="grafico" src="img/graph_mem_consumption_percentage.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Uso de memoria [%]; con ' . $quantityOfTests . ' pruebas)">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '<u>NOTA >> VER CONSUMO DE MEMORIA PORQUE CAPAZ ESTO NO REFLEJA BIEN SI ES BUENO/REG/MALO, DOCUMENTACION DEL CODIGO LIB ANDROID<BR/></U>';
            print '• <strong class="metrica" style="color: #ee9090">USO DE MEMORIA</strong> < <strong>30%</strong>: Es considerado <strong>bueno</strong>.<br/>';
            print '• <strong>30%</strong> ≤ <strong class="metrica" style="color: #ee9090">USO DE MEMORIA</strong> ≤ <strong>70%</strong>: Es considerado <strong>regular</strong>.<br/>';
            print '• <strong class="metrica" style="color: #ee9090">USO DE MEMORIA</strong> > <strong>70%</strong>: Es considerado <strong>malo</strong>.';
            print '</p>';
            print '<div class="versus">VS</div>';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de uso de memoria [%])" class="grafico" src="img/graph_user_score.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de uso de memoria [%])">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>1</strong>: La experiencia fue <strong>' . Constants::SCORE_0 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>2</strong>: La experiencia fue <strong>' . Constants::SCORE_1 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>3</strong>: La experiencia fue <strong>' . Constants::SCORE_2 . '</strong>.';
            print '</p>';
            print '<p class="referencia">';
            print '<strong>Información sobre estos gráficos:</strong>';
            
            if (isset ($promedio_0)) {
                $promedio_0 = round($promedio_0 / $cantidad_0, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), el consumo de memoria promedio fue de <strong>' . $promedio_0 . '%</strong>.';
            }
            
            if (isset ($promedio_1)) {
                $promedio_1 = round($promedio_1 / $cantidad_1, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), el consumo de memoria promedio fue de <strong>' . $promedio_1 . '%</strong>.';
            }
            
            if (isset ($promedio_2)) {
                $promedio_2 = round($promedio_2 / $cantidad_2, 2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), el consumo de memoria promedio fue de <strong>' . $promedio_2 . '%</strong>.';
            }
            
            print '</p>';
            print '</div>';
        } else {
            print '<div class="alert alert-warning" role="alert">';
            print 'No hay registros de la métrica <strong>' . Constants::INDICATOR_MEMORY_PERCENTAGE . '</strong> para el usuario ' . substr($uuid, 8) . ' en la base de datos.';
            print '</div>';
        }
    }
    
    /**
     * Genera el siguiente conjunto de gráficos:
     * • Latencia percibida por el usuario.
     * • Calificación del usuario.
     * 
     * @param String $uuid UUID del usuario para el cual se generarán los
     * gráficos.
     */
    function drawUserPerceivedLatencyScoreGraph($uuid) {
        $result = $this->DBHandler->fetchIndicatorByUUID($uuid, Constants::INDICATOR_USER_LATENCY);
        
        if ($result->num_rows > 0) {
            /* Variables para los gráficos: */
            $pointsForUserPerceivedLatency = array();
            $pointsForScore = array();
            $labelsForPoints = array();
            $quantityOfTests = 0;

            while ($row = $result->fetch_object()) {
                array_push($pointsForUserPerceivedLatency, $row->value);

                switch ($row->score) {
                    case Constants::SCORE_0:
                        array_push($pointsForScore, 1);
                        
                        if (!isset ($promedio_0)) {
                            $promedio_0 = 0;
                            $cantidad_0 = 0;
                        }
                        
                        $promedio_0 = $promedio_0 + $row->value;
                        $cantidad_0++;

                        break;
                    case Constants::SCORE_1:
                        array_push($pointsForScore, 2);
                        
                        if (!isset ($promedio_1)) {
                            $promedio_1 = 0;
                            $cantidad_1 = 0;
                        }
                        
                        $promedio_1 = $promedio_1 + $row->value;
                        $cantidad_1++;

                        break;
                    case Constants::SCORE_2:
                        array_push($pointsForScore, 3);
                        
                        if (!isset ($promedio_2)) {
                            $promedio_2 = 0;
                            $cantidad_2 = 0;
                        }
                        
                        $promedio_2 = $promedio_2 + $row->value;
                        $cantidad_2++;

                        break;
                }

                array_push($labelsForPoints, date_format(date_create($row->dateTime), "d/m/y H:i"));
                $quantityOfTests++;
            }

            /* Se arma el gráfico para la latencia percibida por el usuario (QoE): */
            $this->makeUserPerceivedLatencyGraph($labelsForPoints, $pointsForUserPerceivedLatency);

            /* Se arma el gráfico para la calificación del usuario (QoE): */
            // $this->makeUserScoreGraph($labelsForPoints, $pointsForScore);

            print '<div class="contenedor-graficos">';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Latencia percibida por el usuario; con ' . $quantityOfTests . ' pruebas)" class="grafico" src="img/graph_user_latency.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Latencia percibida por el usuario; con ' . $quantityOfTests . ' pruebas)">';
            print '<div class="versus">VS</div>';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de latencia percibida por el usuario)" class="grafico" src="img/graph_user_score.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de latencia percibida por el usuario)">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>1</strong>: La experiencia fue <strong>' . Constants::SCORE_0 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>2</strong>: La experiencia fue <strong>' . Constants::SCORE_1 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>3</strong>: La experiencia fue <strong>' . Constants::SCORE_2 . '</strong>.';
            print '</p>';
            print '<p class="referencia">';
            print '<strong>Información sobre estos gráficos:</strong>';
            
            if (isset ($promedio_0)) {
                $promedio_0 = round($promedio_0 / $cantidad_0);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), la latencia percibida por el usuario promedio fue de <strong>' . $promedio_0 . ' segundos</strong>.';
            }
            
            if (isset ($promedio_1)) {
                $promedio_1 = round($promedio_1 / $cantidad_1);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), la latencia percibida por el usuario promedio fue de <strong>' . $promedio_1 . ' segundos</strong>.';
            }
            
            if (isset ($promedio_2)) {
                $promedio_2 = round($promedio_2 / $cantidad_2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), la latencia percibida por el usuario promedio fue de <strong>' . $promedio_2 . ' segundos</strong>.';
            }
            
            print '</p>';
            print '</div>';
        } else {
            print '<div class="alert alert-warning" role="alert">';
            print 'No hay registros de la métrica <strong>' . Constants::INDICATOR_USER_LATENCY . '</strong> para el usuario ' . substr($uuid, 8) . ' en la base de datos.';
            print '</div>';
        }
    }
    
    /**
     * Genera el siguiente conjunto de gráficos:
     * • Jitter.
     * • Calificación del usuario.
     * 
     * @param String $uuid UUID del usuario para el cual se generarán los
     * gráficos.
     */
    function drawJitterScoreGraph($uuid) {
        $result = $this->DBHandler->fetchIndicatorByUUID($uuid, Constants::INDICATOR_JITTER);
        
        if ($result->num_rows > 0) {
            /* Variables para los gráficos: */
            $pointsForJitter = array();
            $pointsForScore = array();
            $labelsForPoints = array();
            $quantityOfTests = 0;

            while ($row = $result->fetch_object()) {
                array_push($pointsForJitter, $row->value);

                switch ($row->score) {
                    case Constants::SCORE_0:
                        array_push($pointsForScore, 1);
                        
                        if (!isset ($promedio_0)) {
                            $promedio_0 = 0;
                            $cantidad_0 = 0;
                        }
                        
                        $promedio_0 = $promedio_0 + $row->value;
                        $cantidad_0++;

                        break;
                    case Constants::SCORE_1:
                        array_push($pointsForScore, 2);
                        
                        if (!isset ($promedio_1)) {
                            $promedio_1 = 0;
                            $cantidad_1 = 0;
                        }
                        
                        $promedio_1 = $promedio_1 + $row->value;
                        $cantidad_1++;

                        break;
                    case Constants::SCORE_2:
                        array_push($pointsForScore, 3);
                        
                        if (!isset ($promedio_2)) {
                            $promedio_2 = 0;
                            $cantidad_2 = 0;
                        }
                        
                        $promedio_2 = $promedio_2 + $row->value;
                        $cantidad_2++;

                        break;
                }

                array_push($labelsForPoints, date_format(date_create($row->dateTime), "d/m/y H:i"));
                $quantityOfTests++;
            }

            /* Se arma el gráfico para el jitter (QoS): */
            $this->makeJitterGraph($labelsForPoints, $pointsForJitter);

            /* Se arma el gráfico para la calificación del usuario (QoE): */
            $this->makeUserScoreGraph($labelsForPoints, $pointsForScore);

            print '<div class="contenedor-graficos">';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Jitter; con ' . $quantityOfTests . ' pruebas)" class="grafico" src="img/graph_jitter.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Jitter; con ' . $quantityOfTests . ' pruebas)">';
            print '<div class="versus">VS</div>';
            print '<img alt="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de jitter)" class="grafico" src="img/graph_user_score.png" title="Gráfico generado para el usuario ' . substr($uuid, 8) . ' (Calificación del usuario; contrastado con ' . $quantityOfTests . ' pruebas de jitter)">';
            print '<p class="referencia">';
            print '<strong>Referencias para este gráfico:</strong><br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>1</strong>: La experiencia fue <strong>' . Constants::SCORE_0 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>2</strong>: La experiencia fue <strong>' . Constants::SCORE_1 . '</strong>.<br/>';
            print '• <strong class="metrica" style="color: #32af32">CALIFICACIÓN DEL USUARIO</strong> igual a <strong>3</strong>: La experiencia fue <strong>' . Constants::SCORE_2 . '</strong>.';
            print '</p>';
            print '<p class="referencia">';
            print '<strong>Información sobre estos gráficos:</strong>';
            
            if (isset ($promedio_0)) {
                $promedio_0 = round($promedio_0 / $cantidad_0);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_0 . '</strong> (1), el jitter promedio fue de <strong>' . $promedio_0 . '</strong>.';
            }
            
            if (isset ($promedio_1)) {
                $promedio_1 = round($promedio_1 / $cantidad_1);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_1 . '</strong> (2), el jitter promedio fue de <strong>' . $promedio_1 . '</strong>.';
            }
            
            if (isset ($promedio_2)) {
                $promedio_2 = round($promedio_2 / $cantidad_2);
                
                print '<br/>• Cuando la experiencia del usuario fue <strong>' . Constants::SCORE_2 . '</strong> (3), el jitter promedio fue de <strong>' . $promedio_2 . '</strong>.';
            }
            
            print '</p>';
            print '</div>';
        } else {
            print '<div class="alert alert-warning" role="alert">';
            print 'No hay registros de la métrica <strong>' . Constants::INDICATOR_JITTER. '</strong> para el usuario ' . substr($uuid, 8) . ' en la base de datos.';
            print '</div>';
        }
    }
    
}
