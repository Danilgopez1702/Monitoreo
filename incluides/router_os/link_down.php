<?php
//adjuntar conexion a base de datos
require("../bd/conn/conexion.php");
//adjuntar api 
require('routeros_api.class.php');

$API = new RouterosAPI();

$API->debug = true;

//conexiones a tablas de datos
$queryp = mysqli_query($conexion, "SELECT * FROM `puerto` ");
$p = mysqli_num_rows($queryp);


//Ciclo 
if ($p > 0) {
   while ($data = mysqli_fetch_assoc($queryp)) {

            //Definir el usuario de acceso
                  if($data['tipo'] = 2){
                        //conexiones a tablas de datos
                              $queryc = mysqli_query($conexion, "SELECT * FROM pass WHERE tipo = 2");
                              $c = mysqli_fetch_assoc($queryc);
                        //Guardar usuario y pass mk
                              $user = $c['user'];
                              $pass = $c['pass'];
                  }else{
                         //conexiones a tablas de datos
                         $queryc = mysqli_query($conexion, "SELECT * FROM pass WHERE tipo = 1");
                         $c = mysqli_fetch_assoc($queryc);
                   //Guardar usuario y pass mk
                         $user = $c['user'];
                         $pass = $c['pass'];
                  }
//Guardar ip de mk
   $ip = $data['ip_mk'];


   
//Conexion al mk
      if ($API->connect($ip, $user, $pass)) {
            //Comando mandado al mk
            $API->write("/interface/print",false);
            $API->write("detail",true);
            //Leer la respuesta del mk  
                  $READ = $API->read(false);
            //Guardar la respuesta en un array
                  $ARRAY = $API->parseResponse($READ);
            //Imprimir array de manera mas visual
                  echo('<pre>');
                  print_r($ARRAY);
                  echo('</pre>');
            //Contador para array    
                  $x = 0;
            //Ciclo para extraer del array
                  foreach ($ARRAY as $y) {
                        //Se declara el contador
                              $p1 = $y;
                        //Extraccion de datos del array
                              $link_down = $p1['link-downs'];
                              //echo($com);
                              //echo (' ');
                              $coment = $p1['comment'];
                              //echo($com);
                              //echo (' ');
                              $last = $p1['last-link-down-time'];
                              //echo($com);
                              //echo (' ');
                              $cadena = utf8_encode($coment);

                              
                                    if($link_down > 0 ){
                                          $sql_t = mysqli_query($conexion, "UPDATE `puerto` SET `link_down`='$link_down', `last`='$last' WHERE ip_mk = '$ip' && `comentario` = '$cadena'");
                                          var_dump($cadena,$sql_t);
                                    }else{
                                          $sql_t = mysqli_query($conexion, "UPDATE `puerto` SET `link_down`= 0, `last`='n/a'  WHERE ip_mk = '$ip' && `comentario` = '$cadena'");
                                          var_dump($cadena,$sql_t);
                                    }
                  }
            //Se desconecta del mk
            $API->disconnect();
      }
   }
}
?> 
<meta http-equiv="refresh" content="1; url=../admin/puertos.php">