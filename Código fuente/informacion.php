<head>
    <meta charset="utf-8">
    <title>Nexo — Acerca de</title>

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/estilos.css">
</head>

<body style="background-color: #eff1e4;">
    <nav class="bg-dark navbar navbar-expand fixed-top navbar-dark">
        <a class="navbar-brand" href="metricas.php">
            <img src="img/icono.svg" width="30" height="30" class="d-inline-block align-top" alt="">
            Nexo
        </a>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="indicadores.php">Indicadores</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="informacion.php">Acerca de</a>
            </li>
        </ul>
    </nav>

    <div class="card contenido">
        <div class="card-header" style="font-size: 1.2rem; font-weight: bold;">
            Acerca de
        </div>

        <div class="card-body">
            <p class="card-text">
                <strong>Nexo</strong> es una herramienta que permite recolectar indicadores de calidad (tanto QoS como QoE) en aplicaciones móviles, y también permite clasificarlos y visualizarlos de manera gráfica con la finalidad de facilitar el descubrimiento de vínculos entre estos. Nexo funciona en conjunto con la <a href="https://github.com/gispunpauarg/Q2M" target="_blank">librería Q2M</a>.<br/>
                Esta herramienta fue desarrollada dentro del marco de un proyecto de investigación (en la <a href="https://www.unpa.edu.ar" target="_blank">Universidad Nacional de la Patagonia Austral</a>; <a href="https://www.uarg.unpa.edu.ar" target="_blank">Unidad Académica de Río Gallegos</a>) durante el transcurso del año 2019.
            </p>
            <a class="btn btn btn-secondary" href="https://github.com/gispunpauarg" target="_blank">Ver repositorio (en GitHub)</a>
        </div>
    </div>
</body>