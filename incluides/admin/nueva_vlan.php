<?php 
  include_once "../header/header1.php"; 
  require("../bd/conn/conexion.php");

?>
     <div class="p-2 align-middle" style="margin-top: 15px;">
        <h3 class="card-title">Nueva Vlan</h3>
        <br>
        <div class="p-4 col-md-12">
            <form method='post' action='../router_os/ruta_vlan.php'>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <select name="ip_oficina_vlan" id="ip_oficina_vlan" class="form-control">
                                <option selected="" disabled="true">Seleccione MK Oficina</option>
                                <option value="10.255.255.1">MK 2</option>
                                <option value="10.255.255.2">MK 3</option>
                                <option value="10.255.255.3">MK 4</option>
                                <option value="10.255.255.4">MK 5</option>
                                <option value="10.255.255.5">MK 6</option>
                                <option value="10.255.255.6">MK 7</option>
                                <option value="10.255.255.7">MK 8</option>
                                <option value="10.255.255.8">MK 9</option>
                                <option value="10.255.255.9">MK 10</option>
                                <option value="10.255.255.10">MK 11</option>
                                <option value="10.255.255.11">MK 12</option>
                                <option value="10.255.255.12">MK 13</option>
                            </select>
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">Puerto para vlan (Oficina)</label>
                            <input type="text" class="form-control" name="puerto_vlan_oficina" id="puerto_vlan_oficina">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nombre zona</label>
                            <input type="text" class="form-control"  name="nombre_zona_vlan" id="nombre_zona_vlan">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">IP mk zona</label>
                            <input type="text" class="form-control"  name="ip_mk_vlan" id="ip_mk_vlan">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <label class="form-label">Puerto para vlan (Zona)</label>
                            <input type="text" class="form-control"  name="puerto_vlan_mk" id="puerto_vlan_mk">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">Numero de vlan</label>
                            <input type="text" class="form-control"  name="numero_vlan" id="numero_vlan">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <label class="form-label">IP para vlan (red)</label>
                            <input type="text" class="form-control"  name="ip_vlan" id="ip_vlan">
                        </div>
                    </div>
                </div>
                <br>
                <div  style="margin-left: 1035px;">
                    <button type="submit" class=" col-md-12 btn btn-primary submitBtn">Crear</button>
                </div>
            </form>
        </div>


<?php
 
  include_once "../header/header2.php"; 
?>