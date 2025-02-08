<?php include "resources/views/Components/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Cajas</li>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmCaja();"><i class="fas fa-plus"></i></button>
<table class="table table-light display nowrap" id="tblCajas" style="width: 100%;">
    <thead class="table table-dark">
        <tr>
            <th class="text-center">Caja</th>
            <th class="text-center">Estado</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody class="text-center">
    </tbody>
</table>
<div id="nueva_caja" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-bs-labelledby="my-modal-title" aria-bs-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Caja</h5>
                <button class="close text-white" data-bs-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmCaja">
                    <div class="form-floating mb-3">
                        <input type="hidden" id="id" name="id">
                        <input id="caja" class="form-control" type="text" name="caja" placeholder="Nombre">
                        <label for="caja">Nombre</label>
                    </div>
                    <br>
                    <button class="btn btn-primary" type="button" onclick="registerCaj(event);" id="btnAccion">Agregar</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "resources/views/Components/footer.php"; ?>