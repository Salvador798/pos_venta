<?php include "Views/Components/header.php"; ?>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Nueva Compra</h4>
    </div>
    <div class="card-body">
        <form id="frmCompra">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="codigo"><i class="fas fa-barcode"></i> Código de barras</label>
                        <input type="hidden" id="id" name="id">
                        <input id="codigo" class="form-control" type="text" name="codigo" onkeyup="buscarCodigo(event)">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="nombre">Descripción</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input id="cantidad" class="form-control" type="number" name="cantidad" onkeyup="calcularPrecio(event)" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input id="precio" class="form-control" type="text" name="precio" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="sub_total">Sub Total</label>
                        <input id="sub_total" class="form-control" type="text" name="sub_total" disabled>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="scroll-container">
    <table class="table table-light table-bordered table-hover table-shadow">
        <thead class="table table-dark">
            <tr>
                <th class="text-center">Descripción</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Sub total</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody id="tblDetalle" class="text-center">
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-4 ml-auto">
        <div class="form-group">
            <label for="total" class="font-weight-bold">Total</label>
            <input id="total" class="form-control" type="text" name="total" disabled>
            <button class="btn btn-primary mt-2 btn-block" type="button" onclick="procesar(1)">Generar Compra</button>
            <a href="<?php echo APP_URL; ?>Compras/historial" class="btn btn-warning mt-2 btn-block" type="button">Historial de las compras</a>
        </div>
    </div>
</div>
<?php include "Views/Components/footer.php"; ?>