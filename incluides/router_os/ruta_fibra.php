<?php

require('routeros_api.class.php');

$API = new RouterosAPI();

$nombre_mk = utf8_decode($_POST['nombre_mk_fibra']); //valor que se obtiene de entrada
$ip_mk = $_POST['ip_mk_fibra']; //valor que se obtiene de entrada
$usuario_mk = "admin";
$contraseña_mk = "f4tOql8ebQYUj7khpb4Upow60413";
$ip_olt = $_POST['ip_olt']; //valor que se obtiene de entrada
$ip_oficina = $_POST['ip_oficina_fibra']; //valor que se obtiene de entrada
$usuario_oficina = "SYSADMIN";
$contraseña_oficina = ",xa^)w3V5jrk!h&L";
$ip_vergas = $_POST['ip_vergas_fibra']; //valor que se obtiene de entrada
$usuario_vergas = "NEWADMINDN";
$contraseña_vergas = "B@n4YD^X4zDMJ7jw#5nE_QJgk";
$ip_nat = $_POST['ip_nat_fibra']; //valor que se obtiene de entrada
$puerto_datos = $_POST['puerto_datos']; //valor que se obtiene de entrada
$puerto_int_datos = (int) $puerto_datos;
$puerto_real_datos = $puerto_int_datos - 1;
$comentario_datos = "Datos OLT"." ".$nombre_mk;
$puerto_administracion = $_POST['puerto_administracion']; //valor que se obtiene de entrada
$puerto_int_administracion = (int) $puerto_administracion;
$puerto_real_administracion = $puerto_int_administracion - 1;
$comentario_administracion = "Administracion OLT"." ".$nombre_mk;
$cantidad_vlan = $_POST['cantidad_vlan']; //valor que se obtiene de entrada
$cantidad_vlan_int = (int) $cantidad_vlan;
$numero_inicio_vlan = $_POST['numero_inicio_vlan']; //valor que se obtiene de entrada
$numero_inicio_vlan_int = (int) $numero_inicio_vlan;
$ip_inicio_vlan = $_POST['ip_inicio_vlan']; //valor que se obtiene de entrada
$total_vlan = $numero_inicio_vlan_int + ($cantidad_vlan_int - 1);
$i = $numero_inicio_vlan_int;
$pon = 1;
$numero_pones = $_POST['cantidad_pones']; //valor que se obtiene de entrada


list($ip1_olt, $ip2_olt, $ip3_olt, $ip4_olt) = explode(".", $ip_olt);
$ip4_olt_int = (int) $ip4_olt;
$ip4_olt_real = $ip4_olt_int - 1;
$ip4_olt_string = (string) $ip4_olt_real;
$ip_olt_gateway = ($ip1_olt.".".$ip2_olt.".".$ip3_olt.".".$ip4_olt_string);



$API->debug = true;

//configuracion en mk de zona
if ($API->connect($ip_mk, $usuario_mk, $contraseña_mk)) {

   //poner comentario a puertos
   $API->write('/interface/ethernet/comment',false);
   $API->write("=numbers=".$puerto_real_datos,false);
   $API->write("=comment=".$comentario_datos,true);
   sleep(3);

   $API->write('/interface/ethernet/comment',false);
   $API->write("=numbers=".$puerto_real_administracion,false);
   $API->write("=comment=".$comentario_administracion,true);
   sleep(3);

   //asignar ip a puerto de administracion
   $API->write('/ip/address/add',false);
   $API->write("=address=".$ip_olt_gateway."/30",false);
   $API->write("=interface="."ether".$puerto_administracion,true);
   sleep(3);

   while ($i <= $total_vlan) {

   //crear vlan para puerto de datos
   $API->write('/interface/vlan/add',false);
   $API->write("=name="."vlan"." ".$i,false);
   $API->write("=vlan-id=".$i,false);
   $API->write("=interface="."ether".$puerto_datos,true);
   sleep(3);

   $id_tunel = substr_replace($i, 0, 1, 0);

   //crear tuneles eoip
   $API->write('/interface/eoip/add',false);
   $API->write("=remote-address=".$ip_oficina,false);
   $API->write("=tunnel-id=".$id_tunel,false);
   $API->write("=name="."eoip-vlan"." ".$i." "."PON".$pon." ".$nombre_mk,false);
   $API->write("=!keepalive",true);
   sleep(3);

   //crear bridges
   $API->write('/interface/bridge/add',false);
   $API->write("=name="."bridge_vlan"." ".$i,true);
   sleep(3);

   //asignar puertos a bridges
   $API->write('/interface/bridge/port/add',false);
   $API->write("=bridge="."bridge_vlan"." ".$i,false);
   $API->write("=interface="."vlan"." ".$i,true);
   sleep(3);

   $API->write('/interface/bridge/port/add',false);
   $API->write("=bridge="."bridge_vlan"." ".$i,false);
   $API->write("=interface="."eoip-vlan"." ".$i." "."PON".$pon." ".$nombre_mk,true);
   sleep(3);
   
   $i = $i + 1;
   $pon = $pon + 1;

   }
   

   

   $READ = $API->read(false);
   $ARRAY = $API->parseResponse($READ);

   print_r($ARRAY);

   $API->disconnect();

}

sleep(10);

$i = $numero_inicio_vlan_int;
$pon = 1;
list($ip1_vlan, $ip2_vlan, $ip3_vlan, $ip4_vlan) = explode(".", $ip_inicio_vlan);
$ip4_vlan_int = (int) $ip4_vlan;
$ip4_vlan_real = $ip4_vlan_int + 1;
$ip4_vlan_string = (string) $ip4_vlan_real;
$j = $ip3_vlan;

//configuracion en mk de oficina
if ($API->connect($ip_oficina, $usuario_oficina, $contraseña_oficina)) {

   while ($i <= $total_vlan) {

   $id_tunel = substr_replace($i, 0, 1, 0);

   //crear tuneles eoip
   $API->write('/interface/eoip/add',false);
   $API->write("=remote-address=".$ip_mk,false);
   $API->write("=tunnel-id=".$id_tunel,false);
   $API->write("=name="."eoip-vlan"." ".$i." "."PON".$pon." ".$nombre_mk,false);
   $API->write("=!keepalive",true);
   sleep(3);

   $ip_vlan_gateway = ($ip1_vlan.".".$ip2_vlan.".".$j.".".$ip4_vlan_string);

   //asignar ip a tuneles eoip
   $API->write('/ip/address/add',false);
   $API->write("=address=".$ip_vlan_gateway."/24",false);
   $API->write("=interface="."eoip-vlan"." ".$i." "."PON".$pon." ".$nombre_mk,true);
   sleep(3);

   //crear hostpot de cada pon
   $API->write('/ip/hotspot/add',false);
   $API->write("=addresses-per-mac="."unlimited",false);
   $API->write("=disabled="."no",false);
   $API->write("=interface="."eoip-vlan"." ".$i." "."PON".$pon." ".$nombre_mk,false);
   $API->write("=name="."PON".$pon." ".$nombre_mk,false);
   $API->write("=profile="."hsprof1",true);
   sleep(3);

   $ip_dhcp_inicio = ($ip1_vlan.".".$ip2_vlan.".".$j."."."2");
   $ip_dhcp_final = ($ip1_vlan.".".$ip2_vlan.".".$j."."."200");

   //crear ip pool de cada pon
   $API->write('/ip/pool/add',false);
   $API->write("=name="."PON".$pon." ".$nombre_mk,false);
   $API->write("=ranges=".$ip_dhcp_inicio."-".$ip_dhcp_final,true);
   sleep(3);


   //crear dhcp servers
   $API->write('/ip/dhcp-server/add',false);
   $API->write("=name="."PON".$pon." ".$nombre_mk,false);
   $API->write("=interface="."eoip-vlan"." ".$i." "."PON".$pon." ".$nombre_mk,false);
   $API->write("=address-pool="."PON".$pon." ".$nombre_mk,false);
   $API->write("=disabled="."no",true);
   sleep(3);

   $ip_dhcp_red = ($ip1_vlan.".".$ip2_vlan.".".$j."."."0");

   $API->write('/ip/dhcp-server/network/add',false);
   $API->write("=address=".$ip_dhcp_red."/24",false);
   $API->write("=gateway=".$ip_vlan_gateway,false);
   $API->write("=dns-server="."189.201.158.82, 189.201.158.83",true);
   sleep(3);

   
   $i = $i + 1;
   $pon = $pon + 1;
   $j = (int) $j;
   $j = $j + 1;
   $j = (string) $j;

   }

     

   $READ = $API->read(false);
   $ARRAY = $API->parseResponse($READ);

   print_r($ARRAY);

   $API->disconnect();

}


sleep(10);

$i = 1;
$pon = 1;
list($ip1_vlan, $ip2_vlan, $ip3_vlan, $ip4_vlan) = explode(".", $ip_inicio_vlan);
$j = $ip3_vlan;
list($ip1_nat, $ip2_nat, $ip3_nat, $ip4_nat) = explode(".", $ip_nat); 
$h = $ip4_nat;

//configuracion en vergas
if ($API->connect($ip_vergas, $usuario_vergas, $contraseña_vergas)) {

   while ($i <= $numero_pones) {
 
   $ip_nat_real = ($ip1_nat.".".$ip2_nat.".".$ip3_nat.".".$h);

   //crear nat
   $API->write('/ip/firewall/nat/add',false);
   $API->write("=comment="."PON".$pon." ".$nombre_mk,false);
   $API->write("=action="."src-nat",false);
   $API->write("=src-address-list="."PON".$pon." ".$nombre_mk,false);
   $API->write("=to-addresses=".$ip_nat_real,false);
   $API->write("=out-interface="."sfp-sfpplus1",false);
   $API->write("=chain="."srcnat",true);
   sleep(3);

   $ip_vlan_red = ($ip1_vlan.".".$ip2_vlan.".".$j."."."0");

   $API->write('/ip/firewall/address-list/add',false);
   $API->write("=list="."PON".$pon." ".$nombre_mk,false);
   $API->write("=address=".$ip_vlan_red."/24",true);
   sleep(3);

   $i = $i + 1;
   $pon = $pon + 1;
   $h = (int) $h;
   $h = $h + 1;
   $h = (string) $h;
   $j = (int) $j;
   $j = $j + 1;
   $j = (string) $j;
   

}
   
   $READ = $API->read(false);
   $ARRAY = $API->parseResponse($READ);

   print_r($ARRAY);

   $API->disconnect();


}

echo "<SCRIPT>
      alert('Ruta creada exitosamente')
      window.location.replace('../admin/ruta_fibra.php');
     </SCRIPT>";



?>