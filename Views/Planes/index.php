<?php include "Views/Templates/header.php"; ?>

<button class="btn btn-outline-primary mb-2" type="button" onclick="frmPlan();"><i class="fas fa-plus"></i></button>
<div class="card shadow-lg">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover display responsive nowrap" id="tblPlanes" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Foto</th>
                        <th>Plan</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Condición</th>
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
                <h5 class="modal-title" id="title">Nuevo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formulario" onsubmit="registrarPlan(event);" autocomplete="off">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="nombre">Nombre de membresía*</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre plan" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="precio_plan">Precio de membrecia *</label>
                                <input id="precio_plan" class="form-control" type="text" name="precio_plan" placeholder="Precio Plan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="condicion">Condición Pago *</label>
                                <select id="condicion" class="form-control" name="condicion">
                                    <option value="MENSUAL">MENSUAL</option>
                                    <option value="MENSUAL">TRIMESTRAL</option>
                                    <option value="ANUAL">ANUAL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion">Descripción *</label>
                                <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Descripción" rows="4" required></textarea>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-camera"></i> Foto (Opcional)</label>
                                <input id="imagen" class="form-control" type="file" name="imagen">
                            </div>
                            <input type="hidden" id="foto_actual" name="foto_actual">
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