<?php include "resources/views/Components/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Arqueo de Cajas</li>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="arqueoCaja();"><i class="fas fa-plus"></i></button>
<button class="btn btn-warning mb-2" type="button" onclick="cerrarCaja();">Cerrar Caja</button>
<table class="table table-light display nowrap" id="t_arqueo" style="width: 100%;">
    <thead class="table table-dark">
        <tr>
            <th class="text-center">Monto Inicial</th>
            <th class="text-center">Monto Final</th>
            <th class="text-center">Fecha Apertura</th>
            <th class="text-center">Fecha Cierre</th>
            <th class="text-center">Total Ventas</th>
            <th class="text-center">Monto Total</th>
            <th class="text-center">Estado</th>
        </tr>
    </thead>
    <tbody class="text-center">
    </tbody>
</table>
<div id="abrir_caja" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-bs-labelledby="my-modal-title" aria-bs-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Arqueo Caja</h5>
                <button class="close text-white" data-bs-dismiss="modal" aria-bs-label="Close">
                    <span aria-bs-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmAbrirCaja" onsubmit="abrirArqueo(event);">
                    <div class="form-floating mb-3">
                        <input type="hidden" id="id" name="id">
                        <input id="monto_inicial" class="form-control" type="text" name="monto_inicial" placeholder="Monto Inicial">
                        <label for="monto_inicial">Monto Inicial</label>
                    </div>
                    <div id="ocultar_campos">
                        <div class="form-floating mb-3">
                            <input id="monto_final" class="form-control" type="text" disabled>
                            <label for="monto_final">Monto Final</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input id="total_ventas" class="form-control" type="text" disabled>
                            <label for="total_ventas">Total Ventas</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input id="monto_general" class="form-control" type="text" disabled>
                            <label for="monto_general">Monto Total</label>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" id="btnAccion">Abrir</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "resources/views/Components/footer.php"; ?>