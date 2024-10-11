<?php include "Views/Components/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Productos</li>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmProducto();"><i class="fas fa-plus"></i></button>
<div class="table-responsive">
    <table class="table table-light display nowrap table-shadow" id="tblProductos" style="width:100%">
        <thead class="table sub_title">
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Foto</th>
                <th class="text-center">Precio</th>
                <th class="text-center">IVA</th>
                <th class="text-center">Stock</th>
                <th class="text-center">Estado</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody class="text-center">
        </tbody>
    </table>
</div>
<div id="nuevo_producto" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-bs-labelledby="my-modal-title" aria-bs-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Producto</h5>
                <button class="close text-white" data-bs-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmProducto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="hidden" id="id" name="id">
                                <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Ingrese el código">
                                <label for="codigo">Código de Barra</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                                <label for="nombre">Descripción</label>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="form-floating">
                                <input id="precio_compra" class="form-control" type="text" name="precio_compra" placeholder="Precio Compra">
                                <label for="precio_compra">Precio de Compra</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input id="precio_venta" class="form-control" type="text" name="precio_venta" placeholder="Precio Venta">
                                <label for="precio_venta">Precio de Venta</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <select id="iva" class="form-control" name="iva" required>
                                    <option value="Exento">Exento</option>
                                    <option value="Aplica">Aplica</option>
                                </select>
                                <label for="iva">Impuesto (IVA)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select id="medida" class="form-control" name="medida">
                                    <?php foreach ($data['medidas'] as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="medida">Medida</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select id="categoria" class="form-control" name="categoria">
                                    <?php foreach ($data['categorias'] as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="categoria">Medida</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Foto</label>
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fas fa-image"></i></label>
                                        <span id="icon-cerrar"></span>
                                        <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event)">
                                        <input type="hidden" id="foto_actual" name="foto_actual">
                                        <input type="hidden" id="foto_delete" name="foto_delete">
                                        <img class="img-thumbnail" id="img-preview">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="button" onclick="registrarPro(event);" id="btnAccion">Agregar</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Components/footer.php"; ?>