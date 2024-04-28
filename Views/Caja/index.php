<?php include "Views/Components/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Cajas</li>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmCaja();"><i class="fas fa-plus"></i></button>
<table class="table table-light" id="tblCajas">
    <thead class="table table-dark text-center">
        <tr>
            <th>Id</th>
            <th>Caja</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody class="text-center">
    </tbody>
</table>
<div id="nueva_caja" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Caja</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmCaja">
                    <div class="form-group">
                        <label for="caja">Nombre</label>
                        <input type="hidden" id="id" name="id">
                        <input id="caja" class="form-control" type="text" name="caja" placeholder="Nombre">
                    </div>
                    <br>
                    <button class="btn btn-primary" type="button" onclick="registrarCaj(event);" id="btnAccion">Agregar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Components/footer.php"; ?>