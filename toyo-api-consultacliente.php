<?php


	$request_method=$_SERVER["REQUEST_METHOD"];

	switch ($request_method) {

		case 'GET':

			$tipo = $_GET['tipo'];

			//$xml = simplexml_load_file("xml/toyousrXML.xml");
			//$userDef = (string)$xml->usuarios[0]->usuario;
			//$passDef = (string)$xml->usuarios[0]->pass;

			$serverName = "ulacit-personal-db1.database.windows.net";
			$connectionInfo = array( "Database"=>"personal-db", "UID"=>"itadmin", "PWD"=>"/-/3|_pd3sk1024");
			$conn = sqlsrv_connect( $serverName, $connectionInfo );

			if( $conn === true ) {
			    get_clie();
			} else {
					die( print_r( sqlsrv_errors(), true));
			}

			break;

		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;

	}

	function get_clie($tipo)
	{
		global $conn;

		// BUSCA LA OS SI ESTA CREADA
		if ($tipo == 'CCL') {

			$query="SELECT * FROM info";

			$response=array();
			$result=sqlsrv_query($conn, $query);

			if( $result === true) {

				while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
						$response[]=$row;
				}

			} else {
				die( print_r( sqlsrv_errors(), true) );
			}


		} // FIN DEL IF

		// -------------------------------------
		header('Content-Type: application/json');
		echo json_encode($response);
		//echo "Si entra";

	}


	// Close database connection
	sqlsrv_free_stmt( $result);

?>
