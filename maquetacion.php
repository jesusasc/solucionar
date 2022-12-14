<?php
require_once 'views/layout/header.php';
?>
<section class="info-section-head">

    <div class="container">
        <div class="row align-items-center">
            <link rel="stylesheet" type="text/css" href="<?= base_url ?>assets/sweetalert/sweetalert2.min.css">
            <link rel="stylesheet" href="<?= base_url ?>assets/css/estilos.css">
            <div class="col-sm">
                <h1>Reporte</h1>
            </div>
            <div class="col-sm">
                <img id="img-home" class="img-fluid" src="<?= base_url ?>/assets/img/azul.png">
            </div>
        </div>
    </div>
</section>

<section class="info-section bg-light text-muted" id="info-section">
    <div class="col-auto p-5 text-center d-md-block">
        <form>
            <input type="button" class="btn btn-outline-info" value="CALENDARIO" id="btnEnviar" autofocus="autofocus">
            </body>

            </html>
        </form>
    </div>
    </section>

    <section class="info-section bg-light text-muted posiciontabla" id="info-section">
        <div class="container">
            <div class="row">
                <h1>Reporte Coaches</h1>
                <div class="table-responsive-sm">
                    <form id="excel" method="post">
                <table class="table table-striped table-hover caption-top">
                    <thead>
                        <tr>
                            <th scope="row col-sm">Sucursal</th>
                            <th scope="row col-sm">diaventa</th>
                            <th scope="row col-sm">nombre</th>
                            <th scope="row col-sm">producto</th>
                            <th scope="row col-sm">Total</th>
                            <th scope="row col-sm">Asistencia</th>
                            <th scope="row col-sm">Factor</th>
                            <th scope="row col-sm">estatusConexion</th>
                            <th scope="row col-sm">totalhoras</th>
                            <th scope="row col-sm">porcentaje</th>
                        </tr>
                    </thead>
                    <tbody id="table">
                    </tbody>
                </table>
                </div>
            </div>
        </div>        
        </form>
    </section>

</section> <!-- /section del boton  -->

<?php
require_once 'views/layout/footer.php';
?>

<script>
    var base_url = '<?= base_url ?>';
</script>
<script src="<?= base_url ?>assets/js/ajax.js"></script>
