<?php
//adjuntar conexion a base de datos
require("../bd/conn/conexion.php");
//adjuntar api 
require('routeros_api.class.php');

$API = new RouterosAPI();

$API->debug = true;


//conexiones a tablas de datos
$queryp = mysqli_query($conexion, "SELECT * FROM principal");
$p = mysqli_num_rows($queryp);

//Ciclo 
if ($p > 0) {
      while ($data = mysqli_fetch_assoc($queryp)) {

                  if($data['tipo'] == 2 ){
                        //Nombre mel Mk a conectarse
                              $padre = $data['nombre'];
                        //conexiones a tablas de datos
                              $queryc = mysqli_query($conexion, "SELECT * FROM pass WHERE tipo = 3");
                              $c = mysqli_fetch_assoc($queryc);
                        //Guardar usuario y pass mk
                              $user = $c['user'];
                              $pass = $c['pass'];

                        //Guardar ip de mk
                              $ip_mk = $data['ip_mk'];
                              
                        //Conexion al mk
                              if ($API->connect($ip_mk, $user, $pass)) {
                                    //Comando mandado al mk
                                          $API->write('/interface/eoip/print');     
                                    //Leer la respuesta del mk  
                                          $READ = $API->read(false);
                                    //Guardar la respuesta en un array
                                          $ARRAY = $API->parseResponse($READ);
                                    //Imprimir array de manera mas visual
                                          echo('<pre>');
                                          print_r($ARRAY);
                                          echo('</pre>');                                         
                                    //Ciclo para extraer del array
                                          foreach ($ARRAY as $y) {
                                                //Se declara el contador
                                                      $p1 = $y;
                                                //Extraccion de datos del array
                                                      $nombre = $p1['name'];
                                                      //echo($com);
                                                      //echo (' ');
                                                      $inter = $p1['remote-address'];
                                                      //echo($vel);

                                                //Subida a bd
                                                      $quer = mysqli_query($conexion, "SELECT * FROM principal WHERE ip_mk = '$inter'");
                                                      $pa = mysqli_num_rows($quer);

                                                      if($pa > 0){

                                                      }else{
                                                            if(stristr($nombre, 'eoip-')){
                                                                  $sql_tempo = mysqli_query($conexion, "INSERT INTO `principal`(`ip_mk`, `sale_de`, `tipo`)
                                                                  VALUES ('".$inter."', '$padre', 2)");
                                                                  var_dump($sql_tempo); 
                                                            }
                                                      }                                         
                                          }
                              }
                        //Se desconecta del mk
                              $API->disconnect();
                  }
      }
}
?>
<meta http-equiv="refresh" content="1; url=identity.php">


