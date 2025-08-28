<?php include "Views/Templates/header.php"; ?>
<button class="btn btn-outline-primary mb-2" type="button" onclick="frmUsuario();"><i class="fas fa-plus"></i></button>

<div class="card shadow-lg">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover display responsive nowrap" id="tblUsuarios" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmUsuario" onsubmit="registrarUser(event);" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input type="hidden" id="id" name="id">
                                <label for="usuario"><i class="fas fa-id-card"></i> Usuario</label>
                                <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="nombre"><i class="fas fa-list"></i> Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del usuario" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="correo"><i class="fas fa-envelope"></i> Correo</label>
                                <input id="correo" class="form-control" type="text" name="correo" placeholder="Correo electrónico" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="telefono"><i class="fas fa-phone"></i> Telefono</label>
                                <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Telefono" required>
                            </div>
                        </div>
                        <div class="col-md-12"  id="claves">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="clave"><i class="fas fa-key"></i> Contraseña</label>
                                        <input id="clave" class="form-control" type="password" name="clave" placeholder="Contraseña">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="confirmar"><i class="fas fa-lock"></i> Confirmar Contraseña</label>
                                        <input id="confirmar" class="form-control" type="password" name="confirmar" placeholder="Confirmar contraseña">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="rol">Rol</label>
                                <select id="rol" class="form-control" name="rol" required>
                                    <option value="1">Administrador</option>
                                    <option value="2">Empleado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnAccion">Registrar</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>