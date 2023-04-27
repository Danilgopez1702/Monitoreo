<?php
//adjuntar conexion a base de datos
require("../../bd/conn/conexion.php");

    //conexiones a tablas de datos
        $delete = mysqli_query($conexion, "DELETE FROM `cotejo_sfp`");
        $queryp = mysqli_query($conexion, "SELECT * FROM `puerto` WHERE `puerto` like '%sfp%' ");
        $p = mysqli_num_rows($queryp); 

        if ($p > 0) {
            while ($data = mysqli_fetch_assoc($queryp)) {
                $ip_mk = $data['ip_mk'];
                $nombre = $data['nombre_mk'];
                $tx = $data['tx_sfp'];
                $rx = $data['rx_sfp'];
                $nm = $data['nm'];
                $com = $data['comentario'];
                $link = $data['link'];
                echo $tx;
                echo $rx;
                if($data['link'] == "habilitado"){
                    if(stristr($tx, '-')){
                        if(stristr($rx, '-')){                   
                            $rest = substr($tx, 1);
                            $res = substr($rx, 1);
                            $dif = abs ($rest - $res);
                            var_dump($dif);
                            echo "los dos ";
                        }else{
                            $rest = substr($tx, 1);
                            $dif = abs($res - $rx);
                            echo "solo tx ";
                            var_dump($dif);
                        }
                    }elseif(stristr($rx, '-')){
                        $rest = substr($rx, 1);
                        $dif = abs($rest - $tx);
                        echo "solo rx ";
                        var_dump($dif);
                    }
                }else{
                    $dif = 0;
                }
                    $sql_temp = mysqli_query($conexion, "INSERT INTO `cotejo_sfp`(`ip1`, `mk_s`, `fibra_s`, `tx_s`, `rx_s`,`nm`,`dif`,`link` )
                        VALUES ('$ip_mk','$nombre','$com','$tx','$rx','$nm','$dif','$link')");
                    var_dump($com,$sql_temp);

            }
        }

?>
<meta http-equiv="refresh" content="1; url=../../admin/sfp.php">