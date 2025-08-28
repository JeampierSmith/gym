<?php include "Views/Templates/header.php"; ?>

<div class="card shadow-lg">
    <div class="card-body">
        <div class="card-title">
            <h5>Datos de GYM</h5>
        </div>
        <form id="frmEmpresa" onsubmit="modificarEmpresa(event)" autocomplete="off">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <input id="id" class="form-control" type="hidden" name="id" value="<?php echo $data['empresa']['id']; ?>" required>
                        <label for="ruc"><i class="fas fa-id-card"></i> CI</label>
                        <input id="ruc" class="form-control" type="number" name="ruc" placeholder="Ruc" value="<?php echo $data['empresa']['ruc'] ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                    <label for="nombre"><i class="fas fa-list"></i> Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" value="<?php echo $data['empresa']['nombre'] ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                    <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Teléfono" value="<?php echo $data['empresa']['telefono'] ?>" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group mb-3">
                    <label for="correo"><i class="fas fa-envelope"></i> Correo</label>
                        <input id="correo" class="form-control" type="text" name="correo" placeholder="Correo Electrónico" value="<?php echo $data['empresa']['correo'] ?>" required>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group mb-3">
                    <label for="direccion"><i class="fas fa-home"></i> Dirección</label>
                        <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Dirección" value="<?php echo $data['empresa']['direccion'] ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                    <label for="limite"><i class="fas fa-home"></i> Limite</label>
                        <input id="limite" class="form-control" type="text" name="limite" placeholder="Lmite" value="<?php echo $data['empresa']['limite'] ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" class="form-control" name="mensaje" rows="3"><?php echo $data['empresa']['mensaje'] ?></textarea>
                    </div>
                </div>
               
            </div>
                <div class="d-grid gap-2 my-3">
                    <button class="btn btn-outline-primary" type="submit" id="btnAccion">Modificar</button>
                </div>
        </form>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>