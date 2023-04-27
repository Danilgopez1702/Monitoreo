<?php

require('routeros_api.class.php');

$API = new RouterosAPI();

$ip_mk = $_POST['ip_mk']; //valor que se obtiene de entrada
$usuario_mk = "admin";
$contraseña_mk = "f4tOql8ebQYUj7khpb4Upow60413";
$ip_oficina = $_POST['ip_oficina']; //valor que se obtiene de entrada
$usuario_oficina = "SYSADMIN";
$contraseña_oficina = ",xa^)w3V5jrk!h&L";
$ip_vergas = $_POST['ip_vergas']; //valor que se obtiene de entrada
$usuario_vergas = "NEWADMINDN";
$contraseña_vergas = "B@n4YD^X4zDMJ7jw#5nE_QJgk";
$nombre_nat = $_POST['nombre_nat'];
$ip_nat = $_POST['ip_nat'];
$nombre_torre = utf8_decode($_POST['nombre_torre']); //valor que se obtiene de entrada
$numero_torre = $_POST['numero_torre']; //valor que se obtiene de entrada
$puerto = $_POST['puerto']; //valor que se obtiene de entrada
$puerto_int = (int) $puerto;
$puerto_real = $puerto_int - 1;
$comentario = $nombre_torre." ".$numero_torre;
$tunel = "20";
$direccion_ip_torre = "";
$gateway_torre = "";
$red_torre = "";

if(strpos($numero_torre, "A") !== false){

   $tunel = "30";
   $torre = strtok($numero_torre, "A");
   $id_tunel = $tunel.$torre;
   $direccion_ip_torre = "10."."3.".$torre."."."254";
   $gateway_torre = "10."."3.".$torre."."."1";
   $red_torre = "10."."3.".$torre."."."0";

}else{

   $id_tunel = $tunel.$numero_torre;
   $direccion_ip_torre = "10."."2.".$numero_torre."."."254";
   $gateway_torre = "10."."2.".$numero_torre."."."1";
   $red_torre = "10."."2.".$numero_torre."."."0";
}




$API->debug = true;

//configuracion en mk de zona
if ($API->connect($ip_mk, $usuario_mk, $contraseña_mk)) {

   //poner comentario a puerto
   $API->write('/interface/ethernet/comment',false);
   $API->write("=numbers=".$puerto_real,false);
   $API->write("=comment=".$comentario,true);
   sleep(3);

   //crear tunel eoip
   $API->write('/interface/eoip/add',false);
   $API->write("=remote-address=".$ip_oficina,false);
   $API->write("=tunnel-id=".$id_tunel,false);
   $API->write("=name="."eoip-".$nombre_torre." ".$numero_torre,false);
   $API->write("=!keepalive",true);
   sleep(3);
   
   //crear bridge
   $API->write('/interface/bridge/add',false);
   $API->write("=name="."bridge_".$nombre_torre." ".$numero_torre,true);
   sleep(3);

   //asignar puertos a bridge
   $API->write('/interface/bridge/port/add',false);
   $API->write("=bridge="."bridge_".$nombre_torre." ".$numero_torre,false);
   $API->write("=interface="."ether".$puerto,true);
   sleep(3);

   $API->write('/interface/bridge/port/add',false);
   $API->write("=bridge="."bridge_".$nombre_torre." ".$numero_torre,false);
   $API->write("=interface="."eoip-".$nombre_torre." ".$numero_torre,true);
   sleep(3);

   

   $READ = $API->read(false);
   $ARRAY = $API->parseResponse($READ);

   print_r($ARRAY);

   $API->disconnect();

}

sleep(10);

//configuracion en mk de oficina
if ($API->connect($ip_oficina, $usuario_oficina, $contraseña_oficina)) {

   //crear tunel eoip
   $API->write('/interface/eoip/add',false);
   $API->write("=remote-address=".$ip_mk,false);
   $API->write("=tunnel-id=".$id_tunel,false);
   $API->write("=name="."eoip-".$nombre_torre." ".$numero_torre,false);
   $API->write("=!keepalive",true);
   sleep(3);

   //asignar ip a tunel eoip
   $API->write('/ip/address/add',false);
   $API->write("=address=".$gateway_torre."/24",false);
   $API->write("=interface="."eoip-".$nombre_torre." ".$numero_torre,true);
   sleep(3);

   //crear hostpot de la torre
   $API->write('/ip/hotspot/add',false);
   $API->write("=addresses-per-mac="."unlimited",false);
   $API->write("=disabled="."no",false);
   $API->write("=interface="."eoip-".$nombre_torre." ".$numero_torre,false);
   $API->write("=name=".$nombre_torre." ".$numero_torre,false);
   $API->write("=profile="."hsprof1",true);
   sleep(3);

   $API->write('/ip/hotspot/ip-binding/add',false);
   $API->write("=address=".$direccion_ip_torre,false);
   $API->write("=server=".$nombre_torre." ".$numero_torre,false);
   $API->write("=type="."bypassed",true);
   sleep(3);
   
   

   $READ = $API->read(false);
   $ARRAY = $API->parseResponse($READ);

   print_r($ARRAY);

   $API->disconnect();

}

sleep(10);

if ($API->connect($ip_vergas, $usuario_vergas, $contraseña_vergas)) {
   
   $API->write('/ip/firewall/nat/print');
   $READ = $API->read(false);
   $ARRAY = $API->parseResponse($READ);
   $x = 0;

   foreach ($ARRAY as $y) {

      $p1 = $y;
                  
      if(isset($p1['src-address-list'])){
                        
         $list = $p1['src-address-list'];

            if(strpos($list, $nombre_nat) !== false){

             $x = $x + 1;  
                              
            }else{
                             
             }
      }        
   }

   if ($x > 0) {
      
      $API->write('/ip/firewall/address-list/add',false);
      $API->write("=list=".$nombre_nat,false);
      $API->write("=address=".$red_torre."/24",true);
      sleep(3);


      $READ = $API->read(false);
      $ARRAY = $API->parseResponse($READ);

      print_r($ARRAY);

   
   }


   $API->disconnect();
}

sleep(10);

if(strlen($ip_nat > 0)){

//configuracion en vergas
if ($API->connect($ip_vergas, $usuario_vergas, $contraseña_vergas)) {

   //crear nat
   $API->write('/ip/firewall/nat/add',false);
   $API->write("=comment=".$nombre_torre." ".$numero_torre,false);
   $API->write("=action="."src-nat",false);
   $API->write("=src-address-list=".$nombre_torre." ".$numero_torre,false);
   $API->write("=to-addresses=".$ip_nat,false);
   $API->write("=out-interface="."sfp-sfpplus1",false);
   $API->write("=chain="."srcnat",true);
   sleep(3);

   $API->write('/ip/firewall/address-list/add',false);
   $API->write("=list=".$nombre_torre." ".$numero_torre,false);
   $API->write("=address=".$red_torre."/24",true);
   sleep(3);
   


   $READ = $API->read(false);
   $ARRAY = $API->parseResponse($READ);

   print_r($ARRAY);

   $API->disconnect();

}

}

echo "<SCRIPT>
      alert('Ruta creada exitosamente')
      window.location.replace('../admin/ruta_torre.php');
     </SCRIPT>";

?>