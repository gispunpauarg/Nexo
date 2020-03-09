<?php

require 'conexionBD.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');

// Se toma la URL solicitada y se guarda en un array de datos. Por ejemplo si la URL solicitada es http://localhost/api/usuario/1
// $_SERVER['REQUEST_URI'] imprime "/api/usuario"
// La funcion explode() crea un array de la URL de la siguiente forma Array( [0]=>  [1]=>api  [2]=>usuario  [3]=>1 )
$array = explode("/", $_SERVER['REQUEST_URI']);

// Obtener el cuerpo de la solicitud HTTP. El cuerpo sera enviado en peticiones de tipo POST y PUT, en el cual enviaremos el objeto JSON a registrar o modificar
$bodyRequest = file_get_contents("php://input");

//Este ciclo recorre el array previamente creado y si hay algun valor en blanco lo elimina del array
foreach ($array as $key => $value) {
	if(empty($value)) {
		unset($array[$key]);
	}	
}

//-----------------------------------------------------------------------------------------------------------
$id=-1;
$entity=null;
$data=[];
$conn = ConexionBD::obtenerInstancia()->obtenerBD();
$metodo = strtolower($_SERVER['REQUEST_METHOD']);

if(end($array)>0) {
	// De ser el valor numerico, crea dos variables que contienen el Id solicitado y la entidad solicitada
	$id = $array[count($array)];
	$entity = $array[count($array) - 1];
} else {
	// De ser el valor de tipo string, solo crea la variable de la entidad solicitada
	$entity = $array[count($array)];
}

echo $entity;
//echo $id;

switch ($metodo) {
    case 'get': //Procesar método get
		//http://localhost/q2m/usuarios/1
		//http://localhost/q2m/usuarios
		if ($id==-1)
			$sql = 'SELECT * FROM '.$entity;
		else 	
			$sql = 'SELECT * FROM '.$entity.' WHERE Id='.$id;		
		$statement=$conn->prepare($sql);
		$statement->execute();		
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);		
		//foreach ($results as $valor) {
			//echo $results[0]['nombre'];
		//}	    
		if(count($results)==0)					
			print_json(404, "Not Found", $data);
		else 		
			print_json(200, "OK", $results);		
        break;		
	//----------------------------------------------------------------------------------		
    case 'post': //Procesar método post	(nuevo recurso)
		//http://localhost/q2m/upload     - { "metricas": " .......archivo xml pasado a string......... " }
		//Decodifica el cuerpo de la solicitud y lo guarda en un array de PHP
		
		if ($entity == 'upload') {
			$bodyRequest = file_get_contents("php://input");			
			$valores = json_decode($bodyRequest, true);	
			$metricas = $valores['metricas']; // aca recibo el string con las metricas
                        
                        echo $metricas;
                        
			// Hay que recorrer el string metricas e ir sacando los valores e insertarlos en la base
			// con las lineas siguientes haces el insert de las tuplas
			//$sql = "INSERT INTO metricas (idapp, nombre, fecha, valor) VALUES ('{$idapp}', '{$name}', '{$datetime}', '{$value}')";	
			$sql = "INSERT INTO metrics (nombre, edad, descripcion, foto) VALUES ('android', '1', '{$metricas}', '')";	
			$statement=$conn->prepare($sql);
			$statement->execute();		
			print_json(200, 'post', $statement);			
			//print_json(200, 'post', $metricas); // devuelvo ok al cliente y el string recibido para test
			break;	
		}
		else {
			print_json(200, 'post', 'null');
		}
		
		//echo print_r($_FILES['file']['name']);
		//br();		
		//if($_FILES){			
			//$file = $_FILES['file'];
			//$fileContents = file_get_contents($file['metricas3.xml']);
			//print_r($fileContents);
		//}		 
		//$bodyRequest = file_get_contents("php://input");			
		//$bodyRequest = file_get_contents("metricas1.xml");		
		//$valores = json_decode($bodyRequest, true);	
		//echo json_last_error();
		//$file = $valores['file'];		
		// recorrer el file linea por linea e insertar tupla en la base							
			//$sql = "INSERT INTO metricas (app, nombre, datetime, valor) VALUES ('{$app}', '{$nombre}', '{$datetime}', '{$valor}')";	
			//$statement=$conn->prepare($sql);
			//$statement->execute();				
		//print_json(200, 'post', $statement);
        break;
	//----------------------------------------------------------------------------------	
    case 'put': //Procesar método put
		print_json(200, 'put', 'null');
        break;
    case 'delete': //Procesar método delete
        print_json(200, 'delete', 'null');
		break;
    default:
        print_json(200, 'metodo no aceptado', 'null'); 
}

//-----------------------------------------------------------------------------------------------------------

//Esta funcion imprime las respuesta en estilo JSON y establece los estatus de la cebeceras HTTP
function print_json($status, $mensaje, $data) {
	header("HTTP/1.1 $status $mensaje");
	header("Content-Type: application/json; charset=UTF-8");
	$response['statusCode'] = $status;
	$response['statusMessage'] = $mensaje;	
	$response['data'] = $data;
	
	//echo $response['data'];		
	echo json_encode($response, JSON_PRETTY_PRINT);
}

//Esta funcion renderiza la informacion que sera enviada a la base de datos
//Renderiza la informacion obtenida que luego sera guardada en la Base de dato
//$data = renderizeData(array_keys($array), array_values($array));
function renderizeData($keys, $values) {
	switch ($_SERVER['REQUEST_METHOD']) {
		case 'POST':
			# code...
			foreach ($keys as $key => $value) {
				if($key == count($keys) - 1) {
					$str = $str . $value . ") VALUES (";
					foreach ($values as $key => $value) {
						if($key == count($values) - 1) {
							$str = $str . "'" . $value . "')";
						} else {
							$str = $str . "'" . $value . "',";
						}
					}
				} else {
					if($key == 0) {
						$str = $str . "(" . $value . ",";
					} else {
						$str = $str . $value . ",";
					}
				}
			}
			return $str;
			break;
		case 'PUT':
			foreach ($keys as $key => $value) {
				if($key == count($keys) - 1) {
					$str = $str . $value . "='" . $values[$key] . "'"; 
				} else {
					$str = $str . $value . "='" . $values[$key] . "',"; 
				}
			}
			return $str;
			break;
	}
}


// Esta funcion valida la consulta a los métodos de nuestro API como una forma de seguridad
function authenticate() {
	// Getting request headers
	$headers = apache_request_headers();
	$response = array();
	
	// Verifying Authorization Header
	if (isset($headers['Authorization'])) {
		//$db = new DbHandler(); //utilizar para manejar autenticacion contra base de datos
		// get the api key
		$token = $headers['Authorization'];
		// validating api key
		if (!($token == API_KEY)) { //API_KEY declarada en Config.php
			// api key is not present in users table
			$response["error"] = true;
			$response["message"] = "Acceso denegado. Token inválido";
			print_json(401, $response, null);
		} else {
			//procede utilizar el recurso o metodo del llamado
		}
	} else {
		// api key is missing in header
		$response["error"] = true;
		$response["message"] = "Falta token de autorización";
		print_json(400, $response, null);
	}
	
}

// Esta funcion valida todo lo que entra a nuestro API 
function verifyRequiredParams($required_fields) {
	$error = false;
	$error_fields = "";
	$request_params = array();
	$request_params = $_REQUEST;
	// Handling PUT request params
	if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
		parse_str($app->request()->getBody(), $request_params);
	}
	foreach ($required_fields as $field) {
		if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
			$error = true;
			$error_fields .= $field . ', ';
		}
	}
	if ($error) {
		// Required field(s) are missing or empty
		// echo error json and stop the app
		$response = array();
		$response["error"] = true;
		$response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
		print_json(400, $response, null);
	}
}
	
?>

