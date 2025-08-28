<?php include "Views/Templates/header.php"; ?>
<div class="card">
    <div class="card-body">
        <div class="card-title">
            <h4>Tus Pagos</h4>
        </div>
        <div class="table-responsive my-2">
            <table class="table table-striped table-hover display responsive nowrap" id="tbl" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Cliente</th>
                        <th>Plan</th>
                        <th>Precio</th>
                        <th>Fecha de pago</th>
                        <th>Hora</th>
                        <th>Mes y Año</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['pagos'] as $row) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['plan']; ?></td>
                            <td><?php echo $row['precio_plan']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['hora']; ?></td>
                            <td><?php echo date("M.Y", strtotime($row['fecha'])); ?></td>
                            <td><a class="btn btn-outline-danger" target="_blank" href="<?php echo base_url; ?>clientes/pdfPagos/<?php echo $row['id_cliente']; ?>"><i class="fas fa-file-pdf"></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>