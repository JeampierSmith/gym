<?php include "Views/Templates/header.php"; ?>

<div class="row grid-margin">
    <div class="col-12">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="statistics-item">
                        <p>
                            <i class="icon-sm fa fa-user mr-2"></i>
                            Empleados
                        </p>
                        <h2><?php echo $data['usuarios']['total']; ?></h2>
                    </div>
                    <div class="statistics-item">
                        <p>
                            <i class="icon-sm fas fa-users mr-2"></i>
                            Clientes
                        </p>
                        <h2><?php echo $data['clientes']['total']; ?></h2>
                    </div>
                    <div class="statistics-item">
                        <p>
                            <i class="icon-sm fas fa-list-alt mr-2"></i>
                            Membresías
                        </p>
                        <h2><?php echo $data['planes']['total']; ?></h2>
                    </div>
                    <div class="statistics-item">
                        <p>
                            <i class="icon-sm fas fa-check-circle mr-2"></i>
                            Entrenadores
                        </p>
                        <h2><?php echo $data['entrenador']['total']; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-xl-6 col-md-6 col-sm-12">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="card-title">
                    <h6>Reporte Grafico de Ingreso por Mes
                        <select id="year" class="float-end" onchange="actualizarGrafico()">
                            <?php
                            $fecha = date('Y');
                            for ($i = 2021; $i <= $fecha; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == $fecha) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </h6>
                </div>
                <canvas id="ProductosVendidos"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="card-title">
                    <h6>Ingreso por Día</h6>
                </div>
                <canvas id="ventaDia"></canvas>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>