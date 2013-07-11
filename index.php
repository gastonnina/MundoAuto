<!DOCTYPE html>
<html>
    <head>
        <title>.:Mundo Auto:.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <style type="text/css">
            body {
                padding-top: 20px;
                padding-bottom: 40px;
            }

            /* Custom container */
            .container-narrow {
                margin: 0 auto;
                max-width: 700px;
            }
            .container-narrow > hr {
                margin: 30px 0;
            }

            /* Main marketing message and sign up button */
            .jumbotron {
                margin: 60px 0;
                text-align: center;
            }
            .jumbotron h1 {
                font-size: 72px;
                line-height: 1;
            }
            .jumbotron .btn {
                font-size: 21px;
                padding: 14px 24px;
            }

            /* Supporting marketing content */
            .marketing {
                margin: 60px 0;
            }
            .marketing p + h4 {
                margin-top: 28px;
            }
            .marketing p b{
                color: #006dcc;
            }
            #filtro_res{
                display: none;
            }
        </style>
    </head>
    <body>
        <div class="container-narrow">
            <div class="masthead">
                <ul class="nav nav-pills pull-right">
                    <li class="active"><form id="frm_search" class="form-search" onsubmit="javascript:busca(); return false;">
                            <input name="txtFiltro" type="text" placeholder="Filtro">
                            <button type="submit" class="btn btn-medium">
                                <i class="icon-search"></i>
                            </button>
                        </form>
                    </li>
                    <li><a href="javascript:acerca();">Acerca de</a></li>
                </ul>
                <h3 class="muted">Mundo Auto</h3>
            </div>
            <hr>
            <div id="acerca" class="jumbotron">
                <h1>Mundo Auto!</h1>
                <p class="lead">busca informacion sobre un Automovil solo por su placa.</p>
            </div>

            <hr>

            <div id="filtro_res" class="row-fluid marketing">
                <div id="filtro_res_data" class="span12">
                    
                </div>
            </div>

            <div id="footer">
                <div class="container">
                    <p class="muted credit">Creado por <a href="http://gastonnina.com">Gaston Nina</a>.</p>
                </div>
            </div>
        </div>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            function acerca(){
                $('#filtro_res').hide();
                                    $('#acerca').show();
            }
                                function busca() {
                                    $('#filtro_res').show();
                                    $('#acerca').hide();
                                    $.ajax({
                                        dataType: "json",
                                        url: "ajax.php",
                                        data: $('#frm_search').serialize(),
                                        success: function(dataR) {
                                            if (dataR.code == 200) {
                                                var items = [];
                                                $.each(dataR.data, function(key, val) {
                                                    items.push('<h4>'+this.placa+'</h4> \
                    <p>\
                        <b><i class="icon-barcode"></i> Placa</b> '+this.placa+'<br />\
                        <b><i class="icon-user"></i> Propietario</b> '+this.propietario+'<br />\
                        <b><i class="icon-road"></i> Tipo de Coche</b> '+this.tipo+'<br />\
                        <b><i class="icon-road"></i> Marca</b> '+this.marca+'<br />\
                        <b><i class="icon-road"></i> Modelo</b> '+this.modelo+'<br />\
                        <b><i class="icon-road"></i> Color</b> '+this.color+'<br />\
                        <b><i class="icon-road"></i> Caracteristicas</b> '+this.obs+'<br />\
                    </p>\
                    <hr>');
                                                    $('#filtro_res_data').html(items.join(''));
                                                  
                                                });
                                            } else {
                                                alert(dataR.msg);
                                            }


                                        }
                                    });
                                }
        </script>
    </body>
</html>