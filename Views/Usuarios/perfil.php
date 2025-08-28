<?php include "Views/Templates/header.php"; ?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="card-title">
                    <h4>Datos</h4>
                </div>
                <ul class="list-group list-group-flush">
                    <div class="form-group mb-3">
                        <label for="usuario"><i class="fas fa-user"></i> Usuario</label>
                        <input id="usuario" class="form-control" type="text" name="usuario" value="<?php echo $_SESSION['usuario']; ?>" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nombre"><i class="fas fa-list"></i> Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" value="<?php echo $_SESSION['nombre']; ?>" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label for="correo"><i class="fas fa-envelope"></i> Correo</label>
                        <input id="correo" class="form-control" type="email" name="correo" value="<?php echo $_SESSION['correo']; ?>" disabled>
                    </div>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-lg-6 col-md-6 col-sm-12">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="card-title">
                    <h4>Modificar Contraseña</h4>
                </div>
                <form id="frmCambiarPass" onsubmit="frmCambiarPass(event);">
                    <div class="form-group mb-3">
                        <label for="clave_actual"><i class="fas fa-key"></i> Contraseña Actual</label>
                        <input id="clave_actual" class="form-control" type="password" name="clave_actual" placeholder="Contraseña Actual" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="clave_nueva"><i class="fas fa-lock"></i> Contraseña Nueva</label>
                        <input id="clave_nueva" class="form-control" type="password" name="clave_nueva" placeholder="Contraseña Nueva" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirmar_clave"><i class="fas fa-unlock"></i> Confirmar Contraseña</label>
                        <input id="confirmar_clave" class="form-control" type="password" name="confirmar_clave" placeholder="Confirmar Contraseña" required>
                    </div>
                    <div class="d-grid gap-2 mt-2">
                        <button class="btn btn-outline-primary" type="submit">Modificar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>