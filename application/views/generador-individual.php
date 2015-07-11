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
                <h1 class="text-center"><?php echo $this->lang->line('header-gen'); ?></h1>
                <br>
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <h3 style="color: red"><?php if(isset($error)){ echo $error;} ?></h3>
                    <form method="POST">
                        <div class="form-group">
                            <label for="pasaporte"><?php echo $this->lang->line('numpasaporte'); ?></label>
                            <input name="pasaporte" pattern="[a-zA-Z0-9]+" class="form-control" id="pasaporte" required="true" placeholder="<?php echo $this->lang->line('ingresapasaporte'); ?>" maxlength="20">
                        </div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <div class="form-group">
                                <button type="submit" style="width: 100%" class="btn btn-lg btn-success center-block"><?php echo $this->lang->line('descargar'); ?></button>
                            </div>  
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
