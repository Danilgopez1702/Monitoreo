<?php
//adjuntar conexion a base de datos
require("../bd/conn/conexion.php");
//adjuntar api 
require('./routeros_api.class.php');

$API = new RouterosAPI();

$API->debug = true;

$mk = $_GET['id']; 

//conexiones a tablas de datos
        if($mk == "189.201.191.253" or $mk = "189.201.191.241" or $mk = "189.201.188.153" or $mk = "189.201.191.242"){
            $queryc = mysqli_query($conexion, "SELECT * FROM pass WHERE tipo = 0");
            $c = mysqli_fetch_assoc($queryc);
        }else{
            $queryc = mysqli_query($conexion, "SELECT * FROM pass WHERE tipo = 1");
            $c = mysqli_fetch_assoc($queryc);
        }
            
        //Guardar usuario y pass mk
            $user = $c['user'];
            $pass = $c['pass'];
            
        //Conexion al mk
            if ($API->connect($mk, $user, $pass)) {

                    //Comando mandado al mk
                    $API->write('/system/reboot',false);     
                    $API->write('y',true);
                    //Leer la respuesta del mk
                        $READ = $API->read(false);
                    //Guardar la respuesta en un array
                        $ARRAY = $API->parseResponse($READ);
                    //Imprimir array de manera mas visual
                    //sleep(350);

                
            }
        //Se desconecta del mk
            $API->disconnect();

        echo
        "<SCRIPT>
            alert('Se reinicio correctamente')
            window.location.replace('../admin/reinicio.php');
        </SCRIPT>";

?>

