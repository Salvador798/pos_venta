<?php include "resources/views/Components/header.php"; ?>
<br>
<form action="<?php echo APP_URL; ?>shopping/pdfSale" method="POST" target="_blank">
    <div class="row">
        <div class="col-md-3">
            <div class="mb-3">
                <label for="min">Desde</label>
                <input type="date" name="desde" id="min" value="<?php date_default_timezone_set('America/Caracas');
                                                                echo date('Y-m-d'); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="hasta">hasta</label>
                <input type="date" name="hasta" id="hasta" value="<?php date_default_timezone_set('America/Caracas');
                                                                    echo date('Y-m-d'); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <button type="submit" class="btn btn-danger">PDF</button>
            </div>
        </div>
    </div>
</form>
<div class="card my-2">
    <div class="card-header text-white sub_title">
        Ventas
    </div>
    <div class="card-body">
        <table class="table table-light table-shadow" id="t_historial_v" style="width: 100%;">
            <thead class="table table-dark">
                <tr>
                    <th class="text-center">Clientes</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Fecha Compra</th>
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody class="text-center">
            </tbody>
        </table>
    </div>
</div>
<?php include "resources/views/Components/footer.php"; ?>