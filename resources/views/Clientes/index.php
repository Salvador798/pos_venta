<?php include "resources/views/Components/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Clientes</li>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmCliente();"><i class="fas fa-plus"></i></button>
<table class="table table-light display nowrap table-shadow" id="tblClientes" style="width:100%">
    <thead class="table sub_title">
        <tr>
            <th class="text-center">Dni</th>
            <th class="text-center">Nombre</th>
            <th class="text-center">Telefono</th>
            <th class="text-center">Dirección</th>
            <th class="text-center">Estado</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody class="text-center">
    </tbody>
</table>
<div id="nuevo_cliente" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-bs-labelledby="my-modal-title" aria-bs-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Cliente</h5>
                <button class="close text-white" data-bs-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmCliente">
                    <div class="form-floating mb-3">
                        <input type="hidden" id="id" name="id">
                        <input id="dni" class="form-control" type="text" name="dni" placeholder="Documento de indentidad">
                        <label for="dni">Dni</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                        <label for="nombre">Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Teléfono">
                        <label for="telefono">Teléfono</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea id="direccion" class="form-control" name="direccion" placeholder="Dirección" rows="3"></textarea>
                        <label for="direccion">Dirección</label>
                    </div>
                    <button class="btn btn-primary" type="button" onclick="registrarCli(event);" id="btnAccion">Agregar</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "resources/views/Components/footer.php"; ?>