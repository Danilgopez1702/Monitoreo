<?php 
  include_once "../header/header1.php"; 
  require("../bd/conn/conexion.php");

?>
     <div class="p-2 align-middle" style="margin-top: 15px;">
        <h3 class="card-title">Nueva Ruta de Fibra</h3>
        <br>
        <div class="p-4 col-md-12">
            <form method='post' action='../router_os/ruta_fibra.php'>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nombre zona</label>
                            <input type="text" class="form-control" id="nombre_mk_fibra" name="nombre_mk_fibra">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">IP mk zona</label>
                            <input type="text" class="form-control" name="ip_mk_fibra" id="ip_mk_fibra">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">IP OLT</label>
                            <input type="text" class="form-control"  name="ip_olt" id="ip_olt">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <select name="ip_oficina_fibra" id="ip_oficina_fibra" class="form-control">
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
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <select name="ip_vergas_fibra" id="ip_vergas_fibra" class="form-control">
                                <option selected="" disabled="true">Seleccione MK Vergas</option>
                                <option value="189.201.191.241">Vergas 1</option>
                                <option value="189.201.191.242">Vergas 2</option>
                                <option value="189.201.188.153">Vergas 3</option>
                            </select>
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">IP para nat</label>
                            <input type="text" class="form-control"  name="ip_nat_fibra" id="ip_nat_fibra">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <label class="form-label">Puerto datos</label>
                            <input type="text" class="form-control"  name="puerto_datos" id="puerto_datos">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">Puerto administracion</label>
                            <input type="text" class="form-control"  name="puerto_administracion" id="puerto_administracion">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <label class="form-label">Cantidad vlan</label>
                            <input type="text" class="form-control"  name="cantidad_vlan" id="cantidad_vlan">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">Numero inicio vlan</label>
                            <input type="text" class="form-control"  name="numero_inicio_vlan" id="numero_inicio_vlan">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <label class="form-label">IP inicio vlan (red)</label>
                            <input type="text" class="form-control"  name="ip_inicio_vlan" id="ip_inicio_vlan">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">Pones a utilizar</label>
                            <input type="text" class="form-control"  name="cantidad_pones" id="cantidad_pones">
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