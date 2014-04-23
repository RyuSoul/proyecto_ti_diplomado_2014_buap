/**
 * Created by Cesar Luis Rosagel on 19/04/14.
 */
$(document).ready(function(){

    /*document.getElementById("uploadBtn").onchange = function () {
        document.getElementById("uploadFile").value = this.value;
    };*/

    var getEstados = function(){

        $.post('/digitalMedical/ajax/getEstadosList', 'pais=' + $("#paises").val(), function (datos) {
            $("#estados").html('');
            $("#estados").append('<option value="">-Selecione Estado-</option>');
            for (var i = 0; i < datos.length; i++) {
                $("#estados").append('<option value="' + datos[i].idEstado + '">' + datos[i].nombre + '</option>');
            }

        }, 'json');

    }

    var getMunicipios = function(){

        $.post('/digitalMedical/ajax/getMunicipiosList', 'estado=' + $("#estados").val(), function (datos) {
            $("#municipios").html('');
            $("#municipios").append('<option value="">-Selecione Municipio-</option>');
            for (var i = 0; i < datos.length; i++) {
                $("#municipios").append('<option value="' + datos[i].idMunicipio + '">' + datos[i].nombre + '</option>');
            }

        }, 'json');

    }

    var getLocalidades = function(){

        $.post('/digitalMedical/ajax/getLocalidadesList', 'municipio=' + $("#municipios").val(), function (datos) {
            $("#LocalidadColonia").html('');
            $("#LocalidadColonia").append('<option value="">-Selecione Localidad-</option>');
            for (var i = 0; i < datos.length; i++) {
                $("#LocalidadColonia").append('<option value="' + datos[i].idLocalidadColonia + '">' + datos[i].nombre + '</option>');
            }

        }, 'json');

    }

    var getZipCode = function(){

        $.post('/digitalMedical/ajax/getCodigoPostal', 'localidad=' + $("#LocalidadColonia").val(), function (datos) {
           $("#zipCode").val(datos[0].codigo);
        }, 'json');

    }

    $("#paises").change(function(){
        if(!$("#paises").val()){
            $("#estados").html('');
            $("#municipios").html('');
            $("#LocalidadColonia").html('');
        }
        else{
            getEstados();
        }

    });


    $("#estados").change(function(){
        if(!$("#estados").val()){
            $("#municipios").html('');
            $("#LocalidadColonia").html('');
        }else{
            getMunicipios();
        }
    });

    $("#municipios").change(function(){
        if(!$("#municipios").val()){
            $("#LocalidadColonia").html('');
        }else{
            getLocalidades();
        }
    });

    $("#LocalidadColonia").change(function(){
        if(!$("#LocalidadColonia").val()){
            $("#zipCode").val("");
        }
        else{
            getZipCode();
        }
    });



});