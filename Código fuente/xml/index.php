<?php
require("../lib/DBHandler.class.php");

try {
    $DBHandler = new DBHandler();
} catch (Exception $e) {
    echo "Couldn't create DBHandler instance. Exception: " . $e->getMessage();
}

$archivo = "metrics.xml";
$metrics = simplexml_load_file($archivo);
$uuid = uniqid("Usuario_");

/*
 * En caso de que la apertura de metrics.xml resulte en FALSE porque el
 * documento es inválido, se intenta arreglarlo...
 */
if ($metrics == FALSE) {
    $contenido = file($archivo);
    
    if ($contenido[0] != "<indicators>") {
        /* Se agrega el tag de apertura <indicators>: */
        $contenido[0] = "<indicators>\n" . $contenido[0];

        file_put_contents($archivo, implode("", $contenido));
    }
    
    $contenido = file_get_contents($archivo);
    
    if (substr($contenido, strlen($contenido) - 13) != "</indicators>") {
        /* Se agrega el tag de cierre </indicators>: */
        $contenido .= "\n</indicators>";
        
        file_put_contents($archivo, $contenido);
    }
    
    $metrics = simplexml_load_file($archivo);
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Procesar archivo «<?= $archivo; ?>»</title>
    </head>
    <body>
        <?php if ($metrics != FALSE) { ?>
            <h2>INSERCIONES EJECUTADAS</h2>
            <?php
            foreach($metrics as $indicator) {
                $indicatorAttributes = $indicator->attributes();

                $query = "INSERT INTO metrics(`uuid`, `dateTime`, `indicator`, `value`, `score`) " .
                        "VALUES ('" . $uuid . "', '".$indicatorAttributes['date']."', '".$indicatorAttributes['name']."', '".$indicator."', '".$indicatorAttributes['score']."')";

                echo "<hr/><p><strong>CÓDIGO SQL:</strong><br/>" . $query . "</p><p><strong>RESULTADO:</strong><br/>";

                try {
                    $DBHandler->executeQuery($query);
                    
                    echo "<span style=\"color: green;\">¡Éxito!</span></p>";
                } catch (Exception $e) {
                    echo "<span style=\"color: red;\">Error</span> (<strong>Información:</strong> «<i>" . $e->getMessage() . "</i>»)</p>";
                }
            }

            $DBHandler->closeConnection();
            ?>
        <?php } else { ?>
            <p><strong>Aviso:</strong> No se encontró un documento XML válido (con el nombre <i>metrics.xml</i>) en el directorio para procesarlo.</p>
        <?php } ?>
    </body>
</html>
