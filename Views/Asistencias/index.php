<?php include "Views/Templates/header.php"; ?>
<button class="btn btn-outline-primary mb-2" type="button" onclick="frmAsistencia();"><i class="fas fa-plus"></i></button>
<div class="card shadow-lg">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover display responsive nowrap" id="tblAsistencias" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Fecha</th>
                        <th>Entreda</th>
                        <th>Salida</th>
                        <th>Cliente</th>
                        <th>Entrenador</th>
                        <th>Rutina</th>
                        <th>Estado</th>
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
            <form id="formulario" onsubmit="registrarAsistencia(event);" autocomplete="off">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <input type="hidden" id="id_cli" name="id_cli" required>
                                <label for="select_cliente"><i class="fas fa-users"></i> Buscar Cliente</label>
                                <input type="text" id="select_cliente" class="form-control" placeholder="Buscar..." required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="select_entrenador"><i class="fas fa-user"></i> Buscar Entrenador</label>
                                <input type="hidden" id="id_entrenador" name="id_entrenador" required>
                                <input type="text" id="select_entrenador" placeholder="Buscar..." class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="select_rutina"><i class="fas fa-list"></i> Buscar Rutina</label>
                                <input type="hidden" id="id_rutina" name="id_rutina" required>
                                <input type="text" id="select_rutina" placeholder="Buscar..." class="form-control" required>
                            </div>
                        </div>
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