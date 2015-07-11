<!DOCTYPE html>
<html>
    <head>
        <title>Inscripciones So1o</title>
        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/favicon.ico" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url() ?>assets/js/jquery-1.11.2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <br>
                <h1 class="text-center"><?php echo $this->lang->line('header'); ?></h1>
                <hr>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default">
                                <a href="<?php echo site_url('formulario/index/es'); ?>">Español</a>
                            </button>
                            <button type="button" class="btn btn-default">
                                <a href="<?php echo site_url('formulario/index/en'); ?>">English</a>
                            </button>
                            <button type="button" class="btn btn-default">
                                <a href="<?php echo site_url('formulario/index/pt'); ?>">Português</a>
                            </button>
                        </div>

                        <?php
                        switch ($error) {
                            case "repetido":
                                $error = "";
                                $mensaje = $this->lang->line('repetido');
                                break;
                            case "yainscrito":
                                $error = "";
                                $mensaje = $this->lang->line('yainscrito');
                                break;
                            case "correo":
                                $error = "";
                                $mensaje = $this->lang->line('errorcorreo');
                                break;
                            default:
                                $error = "hidden";
                                $mensaje = "hidden";
                                break;
                        }
                        ?>
                        <div <?php echo $error; ?>>
                            <br>
                            <div class="panel panel-danger">
                                <div class="panel-heading"><?php echo $mensaje; ?></div>
                            </div>
                        </div>
                        <form method="POST">
                            <div class="col-xs-12 col-sm-6">
                                <!--<img src="assets/logo.png">-->
                                <div class="form-group">
                                    <label for="pasaporte"><?php echo $this->lang->line('numpasaporte'); ?></label>
                                    <input name="pasaporte" pattern="[a-zA-Z0-9]+" value="<?php echo $pasaporte; ?>" type="" class="form-control" id="pasaporte" required="true" placeholder="<?php echo $this->lang->line('ingresapasaporte'); ?>" maxlength="20">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="pais"><?php echo $this->lang->line('pais'); ?></label>
                                    <select name="pais" class="form-control" id="pais" required="true">
                                        <option value=""><?php echo $this->lang->line('selecciona'); ?></option>
                                        <?php foreach ($paises as $pais) {
                                            ?>
                                            <option value="<?php echo $pais['id'] ?>"><?php echo $pais['nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="nombre"><?php echo $this->lang->line('tunombre'); ?></label>
                                    <input name="nombre" value="<?php echo $nombre; ?>" type="text" class="form-control" id="nombre" required="true" placeholder="<?php echo $this->lang->line('ingresanombre'); ?>" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="apellidos"><?php echo $this->lang->line('tuapellido'); ?></label>
                                    <input name="apellidos" value="<?php echo $apellidos; ?>" type="text" class="form-control" id="apellidos" required="true" placeholder="<?php echo $this->lang->line('ingresaapellido'); ?>" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="correo"><?php echo $this->lang->line('tucorreo'); ?></label>
                                    <input name="correo" value="<?php echo $correo; ?>" type="email" class="form-control" id="nombre" required="true" placeholder="<?php echo $this->lang->line('ingresacorreo'); ?>" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="correo2"><?php echo $this->lang->line('confirmacorreo'); ?></label>
                                    <input name="correo2" value="<?php echo $correo2; ?>" type="email" class="form-control" id="correo" required="true" placeholder="<?php echo $this->lang->line('ingresaconfirmacorreo'); ?>" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <hr>
                                <h4><strong><?php echo $this->lang->line('notaimportante'); ?></strong></h4>
                                <?php echo $this->lang->line('notaimportantetext'); ?>
                                <hr>
                                <h4><strong class="text-center"><?php echo $this->lang->line('talleresmiercoles'); ?></strong></h4>
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <?php foreach ($talleres[1] as $taller) { ?>
                                        <div class="panel panel-info">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $taller['tallerId'] ?>" aria-expanded="true" aria-controls="collapse<?php echo $taller['tallerId'] ?>">
                                                        <strong><?php echo $taller['tallerId'] . " - " . $taller['nombre'] ?></strong>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse<?php echo $taller['tallerId'] ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    <?php echo $taller['descripcion'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <hr>
                            </div>
                            <h4><strong class="text-center"><?php echo $this->lang->line('talleresdomingo'); ?></strong></h4>
                            <div class="col-xs-12">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <?php foreach ($talleres[3] as $taller) { ?>
                                        <div class="panel panel-info">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $taller['tallerId'] ?>" aria-expanded="true" aria-controls="collapse<?php echo $taller['tallerId'] ?>">
                                                        <strong><?php echo $taller['tallerId'] . " - " . $taller['nombre'] ?></strong>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse<?php echo $taller['tallerId'] ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    <?php echo $taller['descripcion'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <hr>
                            </div>
                            <hr>
                            <h4><strong><?php echo $this->lang->line('notaadicional'); ?></strong></h4>
                            <?php echo $this->lang->line('notaadicionaltext'); ?>
                            <br>
                            </p>
                            <hr>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="taller1"><?php echo $this->lang->line('selecciona1'); ?></label>
                                    <select name="taller1" class="form-control" id="taller1" required="true">
                                        <option value=""><?php echo $this->lang->line('selecciona'); ?></option>
                                        <?php foreach ($talleres[1] as $taller) {
                                            ?>
                                            <option value="<?php echo $taller['tallerhorario_id'] ?>"><?php echo $taller['tallerId'] . " " . $taller['nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="taller2"><?php echo $this->lang->line('selecciona2'); ?></label>
                                    <select name="taller2" class="form-control" id="taller2" required="true">
                                        <option value=""><?php echo $this->lang->line('selecciona'); ?></option>
                                        <?php foreach ($talleres[2] as $taller) {
                                            ?>
                                            <option value="<?php echo $taller['tallerhorario_id'] ?>"><?php echo $taller['tallerId'] . " " . $taller['nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="taller3"><?php echo $this->lang->line('selecciona3'); ?></label>
                                    <select name="taller3" class="form-control" id="taller3" required="true">
                                        <option value=""><?php echo $this->lang->line('selecciona'); ?></option>
                                        <?php foreach ($talleres[3] as $taller) {
                                            ?>
                                            <option value="<?php echo $taller['tallerhorario_id'] ?>"><?php echo $taller['tallerId'] . " " . $taller['nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="taller4"><?php echo $this->lang->line('selecciona4'); ?></label>
                                    <select name="taller4" class="form-control" id="taller4" required="true">
                                        <option value=""><?php echo $this->lang->line('selecciona'); ?></option>
                                        <?php foreach ($talleres[4] as $taller) {
                                            ?>
                                            <option value="<?php echo $taller['tallerhorario_id'] ?>"><?php echo $taller['tallerId'] . " " . $taller['nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                <div class="form-group">
                                    <button type="submit" style="width: 100%" class="btn btn-lg btn-success center-block"><?php echo $this->lang->line('enviar'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        $('.collapse').collapse("hide");
        $('#collapse1').collapse("show");
    </script>

</html>
