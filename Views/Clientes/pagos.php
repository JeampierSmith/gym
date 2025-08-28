<?php include "Views/Templates/header.php"; ?>
<div class="card shadow-lg">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-4">
                <label for="">Desde</label>
                <input class="form-control" id="min" type="date" name="pagos_min">
            </div>
            <div class="col-md-4">
                <label for="">Hasta</label>
                <input class="form-control" id="max" type="date" name="pagos_max">
            </div>
            <div class="col-md-4">
                <div class="d-grid">
                    <label>Acción</label> <br>
                    <button class="btn btn-outline-primary" type="button" name="pagos" onclick="mostrarTodo(event)">Limpiar</button>
                </div>
            </div>
        </div>
        <div class="table-responsive my-2">
            <table class="table table-striped table-hover display responsive nowrap" id="tblPago" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Fecha de Pago</th>
                        <th>Cliente</th>
                        <th>Plan</th>
                        <th>Precio</th>
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
<?php include "Views/Templates/footer.php"; ?>