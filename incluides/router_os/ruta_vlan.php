<?php

require('routeros_api.class.php');

$API = new RouterosAPI();

$ip_oficina = $_POST['ip_oficina_vlan']; //valor que se obtiene de entrada
$usuario_oficina = "SYSADMIN";
$contraseña_oficina = ",xa^)w3V5jrk!h&L";
$puerto_oficina = $_POST['puerto_vlan_oficina']; //valor que se obtiene de entrada
$nombre_mk = utf8_decode($_POST['nombre_zona_vlan']); //valor que se obtiene de entrada
$ip_mk = $_POST['ip_mk_vlan']; //valor que se obtiene de entrada
$usuario_mk = "admin";
$contraseña_mk = "f4tOql8ebQYUj7khpb4Upow60413";
$puerto_mk = $_POST['puerto_vlan_mk']; //valor que se obtiene de entrada
$numero_vlan = $_POST['numero_vlan']; //valor que se obtiene de entrada
$ip_vlan = $_POST['ip_vlan']; //valor que se obtiene de entrada

list($ip1_vlan, $ip2_vlan, $ip3_vlan, $ip4_vlan) = explode(".", $ip_vlan);
$ip4_vlan_int = (int) $ip4_vlan;
$ip4_vlan_real = $ip4_vlan_int + 1;
$ip4_vlan_ap = $ip4_vlan_int + 2;
$ip4_vlan_string = (string) $ip4_vlan_real;
$ip4_vlan_ap_string = (string) $ip4_vlan_ap;
$ip_vlan_gateway = ($ip1_vlan.".".$ip2_vlan.".".$ip3_vlan.".".$ip4_vlan_string);
$ip_vlan_ap = ($ip1_vlan.".".$ip2_vlan.".".$ip3_vlan.".".$ip4_vlan_ap_string);

$API->debug = true;

//configuracion en mk de oficina
if ($API->connect($ip_oficina, $usuario_oficina, $contraseña_oficina)) {
   
   //crear vlan en interfaz correspondiente
   $API->write('/interface/vlan/add',false);
   $API->write("=name="."vlan".$numero_vlan." ".$nombre_mk,false);
   $API->write("=vlan-id=".$numero_vlan,false);
   $API->write("=interface=".$puerto_oficina,true);
   sleep(3); 

   //asignar ip a vlan
   $API->write('/ip/address/add',false);
   $API->write("=address=".$ip_vlan_gateway."/29",false);
   $API->write("=interface="."vlan".$numero_vlan." ".$nombre_mk,true);
   sleep(3);

   //crear ospf para vlan
   $API->write('/routing/ospf/interface/add',false);
   $API->write("=interface="."vlan".$numero_vlan." ".$nombre_mk,false);
   $API->write("=network-type="."point-to-point",true);
   sleep(3);

   //crear network ospf para vlan
   $API->write('/routing/ospf/network/add',false);
   $API->write("=network=".$ip_vlan."/29",false);
   $API->write("=area="."backbone",true);
   sleep(3); 


   $READ = $API->read(false);
   $ARRAY = $API->parseResponse($READ);

   print_r($ARRAY);

   $API->disconnect();


}

sleep(10);

//configuracion en mk de zona
if ($API->connect($ip_mk, $usuario_mk, $contraseña_mk)) {
   
   //crear vlan en interfaz correspondiente
   $API->write('/interface/vlan/add',false);
   $API->write("=name="."vlan".$numero_vlan." ".$nombre_mk,false);
   $API->write("=vlan-id=".$numero_vlan,false);
   $API->write("=interface=".$puerto_mk,true);
   sleep(3); 

   //asignar ip a vlan
   $API->write('/ip/address/add',false);
   $API->write("=address=".$ip_vlan_ap."/29",false);
   $API->write("=interface="."vlan".$numero_vlan." ".$nombre_mk,true);
   sleep(3);

   //crear ospf para vlan
   $API->write('/routing/ospf/interface/add',false);
   $API->write("=interface="."vlan".$numero_vlan." ".$nombre_mk,false);
   $API->write("=network-type="."point-to-point",true);
   sleep(3);

   //crear network ospf para vlan
   $API->write('/routing/ospf/network/add',false);
   $API->write("=network=".$ip_vlan."/29",false);
   $API->write("=area="."backbone",true);
   sleep(3); 


   $READ = $API->read(false);
   $ARRAY = $API->parseResponse($READ);

   print_r($ARRAY);

   $API->disconnect();


}

require_once("../admin/telnet_class.php");

$telnet = new Telnet();


// conexion telnet hacia los switches de oficina para creacion de vlan

$telnet->set_host("10.2.247.245");
$telnet->connect();

$telnet->set_prompt("User: ");
$telnet->wait_prompt();
$telnet->write("ubnt");

$telnet->set_prompt("Password: ");
$telnet->wait_prompt();
$telnet->write("2OI6@Dig@1");

$telnet->set_prompt("> ");
$telnet->wait_prompt();

$telnet->write('enable');
$telnet->write('2OI6@Dig@1');

$telnet->set_prompt("# ");
$telnet->wait_prompt();

$telnet->write('vlan database');

$telnet->set_prompt("# ");
$telnet->wait_prompt();

$telnet->write('vlan'.' '.$numero_vlan);

$telnet->disconnect();

sleep(10);

$telnet->set_host("10.2.245.66");
$telnet->connect();

$telnet->set_prompt("User: ");
$telnet->wait_prompt();
$telnet->write("ubnt");

$telnet->set_prompt("Password: ");
$telnet->wait_prompt();
$telnet->write("ubnt");

$telnet->set_prompt("> ");
$telnet->wait_prompt();

$telnet->write('enable');
$telnet->write('ubnt');

$telnet->set_prompt("# ");
$telnet->wait_prompt();

$telnet->write('vlan database');

$telnet->set_prompt("# ");
$telnet->wait_prompt();

$telnet->write('vlan'.' '.$numero_vlan);

$telnet->write('vlan name'.' '.$numero_vlan.' '.'VLAN'.' '.$numero_vlan);

$telnet->disconnect();



echo "<SCRIPT>
      alert('Vlan creada exitosamente')
      window.location.replace('../admin/nueva_vlan.php');
     </SCRIPT>";

?>