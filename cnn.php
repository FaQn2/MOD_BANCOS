<?php

$host = 'localhost';
$db   = 'Facu_prueba';
$user = 'postgres';
$pass = '5246';

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Verificamos si se envió alguna función desde la aplicación cliente
    if (isset($_POST['funcion'])) {
        $function = $_POST['funcion'];

        switch ($function) {
            case 'getBancos':
                // Consultar los datos de la tabla Bancos
                $sql = "SELECT denom, codigo, cod_entidad FROM Bancos";
                $stmt = $pdo->query($sql);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Devolver los datos en formato JSON con atributo "status"
                $response = array(
                    "status" => 200,
                    "data" => $rows
                );
                echo json_encode($response);
                break;

                case 'insertBanco':
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        // Recibir los datos enviados por fetch con FormData
                        $nombreBanco = $_POST["denom"];
                        $codBanco = $_POST["cod_entidad"];
    
                        // Check if the cod_entidad already exists in the table
                        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM bancos WHERE cod_entidad = :cod_entidad");
                        $stmt->bindParam(':cod_entidad', $codBanco);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
                        if ($result['count'] > 0) {
                            // Return an error response if cod_entidad already exists
                            echo json_encode(array(
                                "status" => 400,
                                "message" => "Banco código repetido"
                            ));
                        } else {
                            // Insertar los datos en la tabla "bancos" usando PDO
                            try {
                                // Preparar la consulta SQL
                                $stmt = $pdo->prepare("INSERT INTO bancos (denom, cod_entidad) VALUES (:denom, :cod_entidad)");
    
                                // Asociar los valores a los parámetros de la consulta
                                $stmt->bindParam(':denom', $nombreBanco);
                                $stmt->bindParam(':cod_entidad', $codBanco);
    
                                // Ejecutar la consulta
                                $stmt->execute();
    
                                // Puedes enviar una respuesta si es necesario
                                echo json_encode(array(
                                    "status" => 200,
                                    "message" => "Datos insertados correctamente en la tabla banco"
                                ));
                            } catch (PDOException $e) {
                                echo json_encode(array(
                                    "status" => 500,
                                    "message" => "Error al insertar datos: " . $e->getMessage()
                                ));
                            }
                        }
                    }
                    break;

                case 'updateBancos':
                    // Obtener los datos enviados desde la aplicación cliente utilizando $_POST
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        // Recibir los datos enviados por fetch con FormData
                        $nombreBanco = $_POST["denom"];
                        $codBanco = $_POST["cod_entidad"];
                        $codigo = $_POST["codigo"];
                

                            

                        // Actualizar los datos en la tabla "bancos" usando PDO
                        try {
                            // Preparar la consulta SQL
                            $stmt = $pdo->prepare("UPDATE bancos SET denom = :denom, cod_entidad = :cod_entidad WHERE codigo = :codigo");
                
                            // Asociar los valores a los parámetros de la consulta
                            $stmt->bindParam(':denom', $nombreBanco);
                            $stmt->bindParam(':cod_entidad', $codBanco);
                            $stmt->bindParam(':codigo', $codigo);
                
                            // Ejecutar la consulta
                            $stmt->execute();
                
                            // Devolver los datos actualizados en formato JSON con atributo "status"
                            $response = array(
                                "status" => 200,
                                "data" => array(
                                    "codigo" => $codigo,
                                    "denom" => $nombreBanco,
                                    "cod_entidad" => $codBanco
                                )
                            );
                            echo json_encode($response);
                        } catch (PDOException $e) {
                            echo json_encode(array(
                                "status" => 500,
                                "message" => "Error al actualizar datos: " . $e->getMessage()
                            ));
                        }
                    }
                    break;
        }
    } else {
        echo json_encode(array(
            "status" => 400,
            "message" => "No se ha especificado ninguna función"
        ));
    }

} catch (PDOException $e) {
    echo json_encode(array(
        "status" => 500,
        "message" => "Error al conectar a la base de datos: " . $e->getMessage()
    ));
}
?>
