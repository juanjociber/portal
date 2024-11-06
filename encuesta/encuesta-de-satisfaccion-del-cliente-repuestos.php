<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de satisfaccion del Cliente | GPEM SAC.</title>
    <!--<link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css"/>
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">-->

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../../librerias/css/menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/44f4eb5be4.js" crossorigin="anonymous"></script>

    <?php 
        //include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php");
        include($_SERVER['DOCUMENT_ROOT']."/pages/menu/navbar.php");
    ?>

</head>
<body style="margin-top:5rem">
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>
    <div class="container">
        <div class="row mb-2">
            <div class="col-12 bg-warning text-center mb-3">
                <h3 class="text-white font-weight-bold m-0 p-2">ENCUESTA DE SATISFACCIÓN</h3>
            </div>
            <div class="col-12">
                <p><h5>Gracias por confiar en GPEM SAC., su opinión es muy importante para mejorar nuestro servicio, es por eso que le solicitamos que nos apoye contestando las siguientes preguntas:</h5></p>
            </div>
        </div>
        <div class="row mb-2">  
            <div class="col-12 col-sm-6 mb-3">
                <label for="txtEmpresa" class="form-label font-weight-bold">Nombre de la Empresa.</label>
                <input type="text" class="form-control" id="txtEmpresa">
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <label for="txtNombre" class="form-label font-weight-bold">Nombre</label>
                <input type="text" class="form-control" id="txtNombre">
            </div>        
            <div class="col-12 bg-light pt-2 pb-2 mb-2">
                <p class="font-weight-bold m-0">1 - ¿Cómo calificaría el nivel de satisfacción en los siguientes aspectos?</p>
            </div>
            <div class="col-12 pl-4 mb-2 border-bottom">
                <p class="font-weight-bold">1.1 - Rapidez en la atención.</p>
                <div class="row pl-4 mb-2">
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta11" id="rbMuyInsatisfecho11" value="muy-insatisfecho">
                        <label class="form-check-label" for="rbMuyInsatisfecho11">Muy insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta11" id="rbInsatisfecho11" value="insatisfecho">
                        <label class="form-check-label" for="rbInsatisfecho11">Insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta11" id="rbMedianamenteSatisfecho11" value="medianamente-satisfecho">
                        <label class="form-check-label" for="rbMedianamenteSatisfecho11">Medianamente satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta11" id="rbSatisfecho11" value="satisfecho">
                        <label class="form-check-label" for="rbSatisfecho11">Satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta11" id="rbMuySatisfecho11" value="muy-satisfecho">
                        <label class="form-check-label" for="rbMuySatisfecho11">Muy satisfecho</label>
                    </div>
                </div>
            </div>
            <div class="col-12 pl-4 mb-2 border-bottom">
                <p class="font-weight-bold">1.2 - Atención en requerimientos directos de las fábricas Cummins, Allison y Prestolite a través de GPEM SAC.</p>
                <div class="row pl-4 mb-2">
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta12" id="rbMuyInsatisfecho12" value="muy-insatisfecho">
                        <label class="form-check-label" for="rbMuyInsatisfecho12">Muy insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta12" id="rbInsatisfecho12" value="insatisfecho">
                        <label class="form-check-label" for="rbInsatisfecho12">Insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta12" id="rbMedianamenteSatisfecho12" value="medianamente-satisfecho">
                        <label class="form-check-label" for="rbMedianamenteSatisfecho12">Medianamente satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta12" id="rbSatisfecho12" value="satisfecho">
                        <label class="form-check-label" for="rbSatisfecho12">Satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta12" id="rbMuySatisfecho12" value="muy-satisfecho">
                        <label class="form-check-label" for="rbMuySatisfecho12">Muy satisfecho</label>
                    </div>
                </div>
            </div>
            <div class="col-12 pl-4 mb-2 border-bottom">
                <p class="font-weight-bold">1.3 - Calidad de servicio.</p>
                <div class="row pl-4 mb-2">
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta13" id="rbMuyInsatisfecho13" value="muy-insatisfecho">
                        <label class="form-check-label" for="rbMuyInsatisfecho13">Muy insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta13" id="rbInsatisfecho13" value="insatisfecho">
                        <label class="form-check-label" for="rbInsatisfecho13">Insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta13" id="rbMedianamenteSatisfecho13" value="medianamente-satisfecho">
                        <label class="form-check-label" for="rbMedianamenteSatisfecho13">Medianamente satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta13" id="rbSatisfecho13" value="satisfecho">
                        <label class="form-check-label" for="rbSatisfecho13">Satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta13" id="rbMuySatisfecho13" value="muy-satisfecho">
                        <label class="form-check-label" for="rbMuySatisfecho13">Muy satisfecho</label>
                    </div>
                </div>
            </div>

            <div class="col-12 pl-4 mb-2 border-bottom">
                <p class="font-weight-bold">1.4 - Garantía del servicio.</p>
                <div class="row pl-4 mb-2">
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta14" id="rbMuyInsatisfecho14" value="muy-insatisfecho">
                        <label class="form-check-label" for="rbMuyInsatisfecho14">Muy insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta14" id="rbInsatisfecho14" value="insatisfecho">
                        <label class="form-check-label" for="rbInsatisfecho14">Insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta14" id="rbMedianamenteSatisfecho14" value="medianamente-satisfecho">
                        <label class="form-check-label" for="rbMedianamenteSatisfecho14">Medianamente satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta14" id="rbSatisfecho14" value="satisfecho">
                        <label class="form-check-label" for="rbSatisfecho14">Satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta14" id="rbMuySatisfecho14" value="muy-satisfecho">
                        <label class="form-check-label" for="rbMuySatisfecho14">Muy satisfecho</label>
                    </div>
                </div>
            </div>

            <div class="col-12 pl-4 mb-2 border-bottom">
                <p class="font-weight-bold">1.5 - Disponibilidad de repuestos y productos.</p>
                <div class="row pl-4 mb-2">
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta15" id="rbMuyInsatisfecho15" value="muy-insatisfecho">
                        <label class="form-check-label" for="rbMuyInsatisfecho15">Muy insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta15" id="rbInsatisfecho15" value="insatisfecho">
                        <label class="form-check-label" for="rbInsatisfecho15">Insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta15" id="rbMedianamenteSatisfecho15" value="medianamente-satisfecho">
                        <label class="form-check-label" for="rbMedianamenteSatisfecho15">Medianamente satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta15" id="rbSatisfecho15" value="satisfecho">
                        <label class="form-check-label" for="rbSatisfecho15">Satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta15" id="rbMuySatisfecho15" value="muy-satisfecho">
                        <label class="form-check-label" for="rbMuySatisfecho15">Muy satisfecho</label>
                    </div>
                </div>
            </div>

            <div class="col-12 pl-4 mb-2 border-bottom">
                <p class="font-weight-bold">1.6 - Amabilidad en la atención.</p>
                <div class="row pl-4 mb-2">
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta16" id="rbMuyInsatisfecho16" value="muy-insatisfecho">
                        <label class="form-check-label" for="rbMuyInsatisfecho16">Muy insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta16" id="rbInsatisfecho16" value="insatisfecho">
                        <label class="form-check-label" for="rbInsatisfecho16">Insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta16" id="rbMedianamenteSatisfecho16" value="medianamente-satisfecho">
                        <label class="form-check-label" for="rbMedianamenteSatisfecho16">Medianamente satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta16" id="rbSatisfecho16" value="satisfecho">
                        <label class="form-check-label" for="rbSatisfecho16">Satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta16" id="rbMuySatisfecho16" value="muy-satisfecho">
                        <label class="form-check-label" for="rbMuySatisfecho16">Muy satisfecho</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 bg-light pt-2 pb-2 mb-2">
                <p class="font-weight-bold m-0">2 - ¿En general se encuentra satisfecho con el servicio recibido?</p>
            </div>
            <div class="col-12 pl-4 mb-2 border-bottom">
                <p class="font-weight-bold">2.1 - Se encuentra satisfecho con el servicio recibido.</p>
                <div class="row pl-4 mb-2">
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta21" id="rbMuyInsatisfecho21" value="muy-insatisfecho">
                        <label class="form-check-label" for="rbMuyInsatisfecho21">Muy insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta21" id="rbInsatisfecho21" value="insatisfecho">
                        <label class="form-check-label" for="rbInsatisfecho21">Insatisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta21" id="rbMedianamenteSatisfecho21" value="medianamente-satisfecho">
                        <label class="form-check-label" for="rbMedianamenteSatisfecho21">Medianamente satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta21" id="rbSatisfecho21" value="satisfecho">
                        <label class="form-check-label" for="rbSatisfecho21">Satisfecho</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta21" id="rbMuySatisfecho21" value="muy-satisfecho">
                        <label class="form-check-label" for="rbMuySatisfecho21">Muy satisfecho</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 bg-light pt-2 pb-2 mb-2">
                <p class="font-weight-bold m-0">3 - ¿Recomendaría el servicio que brinda GPEM S.A.C. a otro cliente?</p>
            </div>
            <div class="col-12 pl-4 mb-2 border-bottom">
                <div class="row pl-4 mb-2">
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta30" id="rbSi30" value="si">
                        <label class="form-check-label" for="rbSi30">Si</label>
                    </div>
                    <div class="col-12 col-md-2 form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbRespuesta30" id="rbNo30" value="no">
                        <label class="form-check-label" for="rbNo30">No</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12 text-center mb-2">
                <button type="button" class="btn btn-primary btn-lg" onclick="fnEnviarEncuestaRepuestos(); return false;">Enviar respuestas</button>
            </div>
        </div>
    </div>

    <!--<script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>-->
    <script src="/mycloud/library/gpemsac/portal/js/encuesta.js"></script>
</body>
<?php 
    //include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html");
    include($_SERVER['DOCUMENT_ROOT']."/pages/menu/footer.html"); 
?>
</html>