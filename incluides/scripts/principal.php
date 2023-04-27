<?php

require("../bd/conn/conexion.php");

$query = mysqli_query($conexion, "SELECT * FROM `equipos`");
$result = mysqli_num_rows($query);
if ($result > 0) {
    while ($data = mysqli_fetch_assoc($query)) { 
        $nombre = $data['nombre'];
        $ip = $data['ip'];
        $tipo = $data['tipo'];

        if($tipo == 1){
            $type = 0;
        }else if($tipo == 2){
            $type = 1;
        }else if($tipo == 3){
            $type = 2;
        }elseif($tipo == 4){
            $type = 2;
        }

    $sql3 = mysqli_query($conexion, "INSERT INTO `principal`(`nombre`, `ip_mk`,`tipo`)
     VALUES ('$nombre','$ip','$type')");
     var_dump($sql3);
    }
}