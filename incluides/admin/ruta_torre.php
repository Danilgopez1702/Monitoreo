<?php 
  include_once "../header/header1.php"; 
  require("../bd/conn/conexion.php");

?>
     <div class="p-2 align-middle" style="margin-top: 15px;">
        <h3 class="card-title">Nueva ruta de torre</h3>
        <br>
        <div class="p-4 col-md-12">
            <form method='post' action='../router_os/ruta_torre.php'>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">IP mk zona</label>
                            <input type="text" class="form-control" id="ip_mk" name="ip_mk">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <select name="ip_oficina" id="ip_oficina" class="form-control">
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
                        <div class="input-group input-group-outline my-3">
                            <select name="ip_vergas" id="ip_vergas" class="form-control">
                                <option selected="" disabled="true">Seleccione MK Vergas</option>
                                <option value="189.201.191.241">Vergas 1</option>
                                <option value="189.201.191.242">Vergas 2</option>
                                <option value="189.201.188.153">Vergas 3</option>
                            </select>
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">Nombre para nat (nat existente)</label>
                            <input type="text" class="form-control"  name="nombre_nat" id="nombre_nat" onblur="deshabilitar_ip()">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <label class="form-label">IP para nat (Nuevo nat)</label>
                            <input type="text" class="form-control"  name="ip_nat" id="ip_nat" onblur="deshabilitar_nombre()">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">Nombre torre</label>
                            <input type="text" class="form-control"  name="nombre_torre" id="nombre_torre">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <label class="form-label">Numero torre</label>
                            <input type="text" class="form-control"  name="numero_torre" id="numero_torre">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">Puerto conectado</label>
                            <input type="text" class="form-control"  name="puerto" id="puerto">
                        </div>
                    </div>
                </div>
                <br>
                <div  style="margin-left: 1035px;">
                    <button type="submit" class=" col-md-12 btn btn-primary submitBtn">Crear</button>
                </div>
            </form>
        </div>

    <script type="text/javascript">
        
        function deshabilitar_ip() {
            var nat_nombre = document.getElementById('nombre_nat').value;
            if (nat_nombre.length > 5) {

                document.getElementById("ip_nat").disabled = true;
                document.getElementById("ip_nat").value = "";

            }else{

            document.getElementById("ip_nat").disabled = false;

            }
        }
        
        function deshabilitar_nombre() {
            var nat_ip = document.getElementById('ip_nat').value;
            if (nat_ip.length > 5) {

            document.getElementById("nombre_nat").disabled = true;
            document.getElementById("nombre_nat").value = "";

            }else{
        
            document.getElementById("nombre_nat").disabled = false;
            
            }
        
        }
        
        
        </script>


<?php
 
  include_once "../header/header2.php"; 
?>