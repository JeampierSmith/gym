<?php include "Views/Templates/header.php"; ?>

<button class="btn btn-outline-primary mb-2" type="button" onclick="frmCliente();"><i class="fas fa-plus"></i></button>

<div class="card shadow-lg">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover display responsive nowrap" id="tblClientes" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>CI</th>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmCliente" onsubmit="registrarCli(event);" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <input type="hidden" id="id" name="id">
                        <label for="dni"><i class="fas fa-id-card"></i> CI</label>
                        <input id="dni" class="form-control" type="number" name="dni" placeholder="Documento de Identidad">
                    </div>
                    <div class="form-group mb-3">
                        <label for="nombre"><i class="fas fa-list"></i> Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del cliente" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
                        <input id="telefono" class="form-control" type="number" name="telefono" placeholder="Teléfono" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="direccion"><i class="fas fa-home"></i> Dirección</label>
                        <textarea id="direccion" class="form-control" name="direccion" placeholder="Dirección" rows="3" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <label><i class="fas fa-camera"></i> Foto</label>
                                <input id="foto" class="form-control" type="file" name="foto">
                        </div>
                        <input type="hidden" id="foto_actual" name="foto_actual">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="submit" id="btnAccion">Registrar</button>
                    <button class="btn btn-outline-danger" type="button" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>