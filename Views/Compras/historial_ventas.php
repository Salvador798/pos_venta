<?php include "Views/Components/header.php"; ?>
<br>
<form action="<?php echo APP_URL; ?>Compras/pdf" method="POST" target="_blank">
    <div class="row">
        <div class="col-md-3">
            <div class="mb-3">
                <label for="min">Desde</label>
                <input type="date" value="<?php echo date('Y-m-d'); ?>" name="desde" id="min">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="hasta">hasta</label>
                <input type="date" value="<?php echo date('Y-m-d'); ?>" name="hasta" id="hasta">
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
        <table class="table table-light" id="t_historial_v">
            <thead class="table table-dark">
                <tr>
                    <th class="text-center">#</th>
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
<?php include "Views/Components/footer.php"; ?>