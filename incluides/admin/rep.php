<?php
require("../bd/conn/conexion.php");
$queryp = mysqli_query($conexion, "SELECT * FROM `ip` ");
$p = mysqli_num_rows($queryp);
if ($p > 0) {
    while ($data = mysqli_fetch_assoc($queryp)) {
        $ip = $data['ip'];
        $ip_mk = $data['ip_mk'];
        $nombre = $data['nombre'];
        $sqli = mysqli_query($conexion,"SELECT * FROM ip");
        $pi = mysqli_fetch_assoc($sqli);
        if($ip == $pi['ip']){
            $sql_t = mysqli_query($conexion, "UPDATE `ip` SET `repetido`='$ip' WHERE ip_mk = '$ip' && `comentario` = '$nombre'");
            var_dump($sql_t);
        }
    }
}
?>
<meta http-equiv="refresh" content="1; url=ip_rep.php">