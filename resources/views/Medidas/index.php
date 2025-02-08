<?php include "resources/views/Components/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Medidas</li>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmMedida();"><i class="fas fa-plus"></i></button>
<div class="table-responsive">
    <table class="table table-light display nowrap table-shadow" id="tblMedidas" style="width: 100%;">
        <thead class="table sub_title">
            <tr>
                <th class="text-center">Nombre</th>
                <th class="text-center">Estado</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody class="text-center">
        </tbody>
    </table>
</div>
<div id="nueva_medida" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-bs-labelledby="my-modal-title" aria-bs-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Medida</h5>
                <button class="close text-white" data-bs-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmMedida">
                    <div class="form-floating m-3">
                        <input type="hidden" id="id" name="id">
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                        <label for="nombre">Nombre</label>
                    </div>
                    <br>
                    <button class="btn btn-primary" type="button" onclick="registerExtends(event);" id="btnAccion">Agregar</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "resources/views/Components/footer.php"; ?>