<?php 
  include_once "../header/header1.php"; 
  require("../bd/conn/conexion.php");

?>
   <div class="align-middle my-2">
        <div class="rounded float-start col-sm-4">
            <h3 class="card-title col">Nueva ruta de torre</h3>
        <form method='post' action='../router_os/ruta_torre.php'>
            <label>IP zona</label>
            <input type="text" name="ip_mk" id="ip_mk">
            <br><br>
            <label>IP mk oficina</label>
            <input type="text" name="ip_oficina" id="ip_oficina">
            <br><br>
            <label>IP vergas</label>
            <input type="text" name="ip_vergas" id="ip_vergas">
            <br><br>
            <label name="label_nombre_nat" id="label_nombre_nat">Nombre para nat (nat existente)</label>
            <input type="text" name="nombre_nat" id="nombre_nat" onfocusout="esconder_ip()">
            <br><br>
            <label name="label_nat" id="label_nat">IP para nat (Nuevo nat)</label>
            <input type="text" name="ip_nat" id="ip_nat" onfocusout="esconder_nombre()">
            <br><br>
            <label>Nombre torre</label>
            <input type="text" name="nombre_torre" id="nombre_torre">
            <br><br>
            <label>Numero torre</label>
            <input type="text" name="numero_torre" id="numero_torre">
            <br><br>
            <label>Puerto conectado</label>
            <input type="text" name="puerto" id="puerto">
            <br><br>

            <button type="submit" class="btn btn-primary submitBtn">Guardar</button>
        </form>   
        </div>
    </div>


    <div class="align-middle my-2">
        <div class="rounded float-start col-sm-4">
            <h3 class="card-title col">Nueva ruta de fibra</h3>
        <form method='post' action='../router_os/ruta_fibra.php'>
            <label>Nombre zona</label>
            <input type="text" name="nombre_mk_fibra" id="nombre_mk_fibra">
            <br><br>
            <label>IP zona</label>
            <input type="text" name="ip_mk_fibra" id="ip_mk_fibra">
            <br><br>
            <label>IP OLT</label>
            <input type="text" name="ip_olt" id="ip_olt">
            <br><br>
            <label>IP mk oficina</label>
            <input type="text" name="ip_oficina_fibra" id="ip_oficina_fibra_fibra">
            <br><br>
            <label>IP vergas</label>
            <input type="text" name="ip_vergas_fibra" id="ip_vergas_fibra">
            <br><br>
            <label>IP para nat</label>
            <input type="text" name="ip_nat_fibra" id="ip_nat_fibra">
            <br><br>
            <label>Puerto datos</label>
            <input type="text" name="puerto_datos" id="puerto_datos">
            <br><br>
            <label>Puerto administracion</label>
            <input type="text" name="puerto_administracion" id="puerto_administracion">
            <br><br>
            <label>Cantidad vlan</label>
            <input type="text" name="cantidad_vlan" id="cantidad_vlan">
            <br><br>
            <label>Numero inicio vlan</label>
            <input type="text" name="numero_inicio_vlan" id="numero_inicio_vlan">
            <br><br>
            <label>IP inicio vlan</label>
            <input type="text" name="ip_inicio_vlan" id="ip_inicio_vlan">
            <br><br>
            <label>Pones a utilizar</label>
            <input type="text" name="cantidad_pones" id="cantidad_pones">
            <br><br>

            <button type="submit" class="btn btn-primary submitBtn">Guardar</button>
        </form>   
        </div>
    </div>

<script type="text/javascript">
        
function esconder_ip() {

document.getElementById("ip_nat").style.display = 'none';
document.getElementById("label_nat").style.display = 'none';
}

function esconder_nombre() {

document.getElementById("nombre_nat").style.display = 'none';
document.getElementById("label_nombre_nat").style.display = 'none';
}


</script>
        