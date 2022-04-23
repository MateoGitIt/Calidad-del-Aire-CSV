<?php
    include("cn.php");
    $calidad = "SELECT * FROM calidad";

    $where = "";
    
    if(!empty($_POST))
	{
		$valor = $_POST['campo'];
		if(!empty($valor)){
			$where = "WHERE Hora LIKE '%$valor%'"; 
		}
	}
	$sql = "SELECT * FROM calidad $where";
	$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang ="es">

    <head>
        <meta charset="UTF-8">
        <title>Tabla de Datos</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        
        <script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
        <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
        <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        

    </head>
    
    <body>
        
        <nav class="navbar navbar-light bg-light shadow rounded">
            <div class="container-fluid">
                <a class="navbar-brand fs-2 fw-light" href="#">
                <img src="Leon.png" alt="" width="60" class="d-inline-block align-text-center">ﾠ
                <img src="EFQM.png" alt="" width="80" class="d-inline-block align-text-center">
                ㅤㅤㅤㅤㅤㅤCalidad de Aire del Colegio San Viatorㅤㅤㅤㅤㅤﾠㅤ
                <img src="Sanvi.png" alt="" width="45" class="d-inline-block align-text-center">ﾠ
                <img src="IB.png" alt="" width="60" class="d-inline-block align-text-center">
                </a>
            </div>
        </nav>

        <br>

        <div class="card text-dark bg-secondary mb-3 shadow" style="width: 950px; margin-left: 175px; --bs-bg-opacity: .2;">
            <div class="card-body">
                <h5 class="card-title align-center">ㅤㅤㅤㅤㅤㅤㅤㅤㅤﾠㅤㅤㅤㅤㅤㅤㅤㅤㅤBúsqueda de datos</h5>
                <p class="card-text">Para realizar su búsqueda de datos, tenga en cuenta lo siguiente: 
                    una petición de búsqueda devuelve máximo 24 conjuntos de datos por cada día, un 
                    “conjunto” siendo equivalente a 12 valores (una ponderación, 6 valores ICA, y 5 
                    valores climáticos) por cada hora, abarcando  así registros de las 24 horas del día.</p>
                <p>Si desea exportar la base de datos, presione el botón con el formato de su preferencia:</p>
                ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤﾠ<button class="btn btn-success" id="btnExportar"><i class="fas fa-file-excel"></i><img src="XLS.png"></button>
                <button class="btn btn-secondary" onclick="exportTableToCSV('Calidad Aire Colegio San Viator.csv')"><img src="CSV.png"></button>
                <br><br><p>El formato para escribir el día del que desee recibir datos en la barra de búsqueda es: 
                AAAA/MM/DD. Por ejemplo: “2022/04/11”, 4 de abril de 2022.</p>
            </div> 
        </div> 
        
        <br>

        <div class="buscar" style="margin-left: 525px">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="caja">
                    <input type="text" id="campo" name="campo" placeholder="AAAA/MM/DD"/>
                    <input type="submit" id="enviar" name="enviar" value="Buscar" class="btn btn-primary"/>
                </div>
			</form>
        </div>

        <br>
           
        <div class="container">
            <div class="row">
                <div class="col">
                <table class="table shadow table-hover table-striped table-bordered align-middle text-center" id="tabla">
                        <thead>
                            <tr>
                                <th class="Titulo table-dark">Hora</th>
                                <th class="Titulo table-dark">Calidad de Aire</th>
                                <th class="Titulo table-dark">PM2.5 (ICA)</th>
                                <th class="Titulo table-dark">PM10 (ICA)</th>
                                <th class="Titulo table-dark">O3 (ICA)</th>
                                <th class="Titulo table-dark">NO2 (ICA)</th>
                                <th class="Titulo table-dark">SO2 (ICA)</th>
                                <th class="Titulo table-dark">CO (ICA)</th>
                                <th class="Titulo table-dark">Temperatura (°C)</th>
                                <th class="Titulo table-dark">Presión (mmHg)</th>
                                <th class="Titulo table-dark">Humedad (%)</th>
                                <th class="Titulo table-dark">Viento (m/s)</th>
                                <th class="Titulo table-dark">Precipitación (%)</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                        <?php while($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
                                <tr>
                                    <td class="Item"><?php echo $row["Hora"];?></td>
                                    <td class="Item"><?php echo $row["Ponderacion"];?></td>
                                    <td class="Item"><?php echo $row["PM25"];?></td>
                                    <td class="Item"><?php echo $row["PM10"];?></td>
                                    <td class="Item"><?php echo $row["O3"];?></td>
                                    <td class="Item"><?php echo $row["NO2"];?></td>
                                    <td class="Item"><?php echo $row["SO2"];?></td>
                                    <td class="Item"><?php echo $row["CO"];?></td>
                                    <td class="Item"><?php echo $row["Temperatura"];?></td>
                                    <td class="Item"><?php echo $row["Presion"];?></td>
                                    <td class="Item"><?php echo $row["Humedad"];?></td>
                                    <td class="Item"><?php echo $row["Viento"];?></td>
                                    <td class="Item"><?php echo $row["Precipitacion"];?></td>
                                </tr>
                            </tbody>
                            
                            <?php } mysqli_free_result($resultado);?>

                    </table>
                <div>
            <div>
        <div>
                    
        <script>
            const $btnExportar = document.querySelector("#btnExportar"),
                
                $tabla = document.querySelector("#tabla");

            $btnExportar.addEventListener("click", function() {
                
                let tableExport = new TableExport($tabla, {
                    exportButtons: false, // No queremos botones
                    filename: "Calidad Aire Colegio San Viator", //Nombre del archivo de Excel
                    sheetname: "Calidad Aire Colegio San Viator", //Título de la hoja
                });
                
                let datos = tableExport.getExportData();
                
                let preferenciasDocumento = datos.tabla.xlsx;
                    tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
                });
        
        </script>

        <script>
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csvFile = new Blob([csv], {type: "text/csv"});

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide download link
            downloadLink.style.display = "none";

            // Add the link to DOM
            document.body.appendChild(downloadLink);

            // Click download link
            downloadLink.click();
        }

        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");
    
            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("td, th");
        
                for (var j = 0; j < cols.length; j++) 
                    row.push(cols[j].innerText);
        
                csv.push(row.join(","));        
            }

            // Download CSV file
            downloadCSV(csv.join("\n"), filename);
        }
        </script>

    </body>

</html>