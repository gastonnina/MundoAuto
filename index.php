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
                    <li class="active"><form class="form-search">
                            <input type="text" placeholder="Filtro">
                            <button type="button" class="btn btn-medium" onclick="busca()">
                                <i class="icon-search"></i>
                            </button>
                        </form>
                    </li>
                    <li><a href="javascript:void(0);">Acerca de</a></li>
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
                <div class="span12">
                    <h4>XAS-002</h4>
                    <p>
                        <b><i class="icon-barcode"></i> Placa</b> XAS-001<br />
                        <b><i class="icon-user"></i> Propietario</b> Gaston Nina<br />
                        <b><i class="icon-road"></i> Tipo de Coche</b> Minibus<br />
                        <b><i class="icon-road"></i> Marca</b> Toyota<br />
                        <b><i class="icon-road"></i> Modelo</b> 99<br />
                        <b><i class="icon-road"></i> Color</b> Azul<br />
                    </p>
                    <hr>
                    <h4>XAS-001</h4>
                    <p>
                        <b><i class="icon-barcode"></i> Placa</b> XAS-001<br />
                        <b><i class="icon-user"></i> Propietario</b> Gaston Nina<br />
                        <b><i class="icon-road"></i> Tipo de Coche</b> Minibus<br />
                        <b><i class="icon-road"></i> Marca</b> Toyota<br />
                        <b><i class="icon-road"></i> Modelo</b> 99<br />
                        <b><i class="icon-road"></i> Color</b> Azul<br />
                    </p>
                    <hr>

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
            function busca() {
                $('#filtro_res').show();
                $.ajax({
                    url: "ajax.php",
                    context: document.body
                }).done(function() {
                    $(this).addClass("done");
                });
            }
        </script>
    </body>
</html>