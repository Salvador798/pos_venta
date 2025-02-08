</div>
</main>
<footer class="py-1 bg-light mt-3">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Jesús Martinez</div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<div id="cambiarPass" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-bs-labelledby="my-modal-title" aria-bs-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Cambiar Contraseña</h5>
                <button class="close text-white" data-bs-dismiss="modal" aria-bs-label="Close">
                    <span aria-bs-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCambiarPass" onsubmit="frmCambiarPass(event);">
                    <div class="form-group">
                        <label for="clave_actual">Contraseña Actual</label>
                        <input id="clave_actual" class="form-control" type="password" name="clave_actual" placeholder="Contraseña Actual">
                    </div>
                    <div class="form-group">
                        <label for="clave_nueva">Contraseña Nueva</label>
                        <input id="clave_nueva" class="form-control" type="password" name="clave_nueva" placeholder="Contraseña Nueva">
                    </div>
                    <div class="form-group">
                        <label for="confirmar_clave">Confirmar Contraseña</label>
                        <input id="confirmar_clave" class="form-control" type="password" name="confirmar_clave" placeholder="Confirmar Contraseña">
                    </div>
                    <button class="btn btn-primary" type="submit">Modificar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo APP_URL; ?>public/js/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="<?php echo APP_URL; ?>public/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?php echo APP_URL; ?>public/js/scripts.js"></script>
<script src="<?php echo APP_URL; ?>public/DataTables/datatables.min.js"></script>
<script>
    const APP_URL = "<?php echo APP_URL; ?>";
</script>
<script src="<?php echo APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
<script src="<?php echo APP_URL; ?>public/js/select2.min.js"></script>
<script src="<?php echo APP_URL; ?>public/js/chart.min.js"></script>
<!-- <script src="<?php echo APP_URL; ?>public/js/funciones.js"></script> -->
<script type="module" src="<?php echo APP_URL; ?>resources/js/main.js"></script>
<script src="<?php echo APP_URL; ?>resources/js/alerts.js"></script>
<script src="<?php echo APP_URL; ?>resources/js/date.js"></script>
</body>

</html>