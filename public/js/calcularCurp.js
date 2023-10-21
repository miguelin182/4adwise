
//Variables Globales
var vocales,nombres;

vocales = ["A","E","I","O","U"];
nombres = ["MARÍA","MARIA","JOSÉ","JOSE"];

/**
 * Recibe un string para poder quitar acentos y eñes
 *
 * @param {String} str
 * @returns {String}
 */
function limpiaString(str){

    str = str.replace(/\Á|á/g, 'A');
    str = str.replace(/\É|é/g, 'E');
    str = str.replace(/\Í|í/g, 'I');
    str = str.replace(/\Ó|ó/g, 'O');
    str = str.replace(/\Ú|ú/g, 'U');
    str = str.replace(/\Ñ|ñ/g, 'X');

    return str;
}

/**
 * Recibe un string para verificar si esta separadao por un espacio y si existe otro strong después del espacio.
 *
 * @param {String} arreglo Un arreglo de caracteres
 * @returns {String} El segundo string en caso de ser encontrado, si no existe regresa SINDEFINIR.
 */
function segundoString(arreglo){
    var segundo;
    //alert(arreglo[1]);
    if(arreglo[1] != undefined && arreglo[1] != ''){
        segundo = arreglo[1].toUpperCase();
        //alert(nombre2);
    }else{
        segundo = "SINDEFINIR";
    }

    return segundo;
}

/**
 * Recibe una fecha y la formatea para el curp, es decir con formato yymmdd Ej. (890418)
 *
 * @param {String} fecha Con formato dd-mm-yyyy Ej. (18-04-1989)
 * @returns {String} Fecha con formato yyddmm Ej. (890418)
 */
function getFecha(fecha){
    return fecha[8]+fecha[9]+fecha[3]+fecha[4]+fecha[0]+fecha[1];
}

/**
 * Obtiene la primer consonante interna de un String
 *
 * @param {String} string Cadena a verificar
 * @returns {char} Consonante Interna
 */
function consonanteInterna(string){
    var tmp,tmp1,tmp2;
    tmp1 = 0;
    tmp2 = 0;

    if(string != 'SINDEFINIR'){
        for (var i = 0; i < string.length; i++) {
            if (tmp1 == 0 && $.inArray(string[i], vocales) == -1 && tmp2 != 0) {
                //alert(vocales);
                //alert(apater[i]);
                tmp1 = tmp1 + 1;
                tmp = string[i];
            }
            tmp2++;
        }
    }else{
        tmp = "X";
    }


    return tmp;
}

/**
 * Obtiene la primer vocal interna de un String
 *
 * @param {String} string Cadena a verificar
 * @returns {char} Vocal Interna
 */
function vocalInterna(string){
    var tmp,tmp1,tmp2;
    tmp1 = 0;
    tmp2 = 0;

    if(string != 'SINDEFINIR'){
        for (var i = 0; i < string.length; i++) {
            if (tmp1 == 0 && $.inArray(string[i], vocales) != -1 && tmp2 != 0) {
                tmp1 = tmp1 + 1;
                tmp = string[i];
            }
            tmp2++;
        }
    }else{
        tmp = "X";
    }


    return tmp;
}

(function($) {
    /**
     * Función CURP. Calcula el CURP en base a ciertas opciones.
     *
     * @param {array} options Opciones para el calculo de la CURP.
     * @param {function} callbackFunction Posible función a ejecutar antes de terminar el proceso.
     * @returns {_L99.$.fn@call;val|_L99.$.fn@call;html} Puede regresar el valor calculado a un input o un div/span
     */
    $.fn.curp = function(options,callbackFunction) {

        //Variables locales
        var curp,nombre1,nombre2,apater,amater,tmp,tmp1;

        //Valores por default
        var settings = $.extend({
            nombre: "PrimerNombre SegundoNombre", //Separados por un Espacio.
            apellido: "ApellidoPaterno ApellidoMaterno", //Separados por un espacio.
            fechaNacimiento: "01-01-2001", //En formato dd-mm-yyyy.
            lugarNacimiento: "NE", //Por default lo trata como extranjero. Ver lista de valores aceptados.
            sexo: "H" //Sólo puede ser H o M.
        }, options);

        //Limpiamos de acentos los nombres y apellidos.
        settings.nombre = limpiaString(settings.nombre);
        settings.apellido = limpiaString(settings.apellido);

        //Separamos el nombre para obtener el segundo nombre.
        tmp = settings.nombre.split(" ");
        nombre1 = tmp[0].toUpperCase();
        nombre2 = segundoString(tmp);

        //Separamos el apellido en paterno y materno.
        tmp = settings.apellido.split(" ");
        apater = tmp[0].toUpperCase();
        amater = segundoString(tmp);

        //Obtenemos la primera vocal del apellido paterno
        curp = apater[0] + vocalInterna(apater);

        //Obtenemos la primer letra del apellido materno
        if(amater != 'SINDEFINIR'){
            curp = curp + amater[0];
        }else{
            curp = curp + "X";
        }


        //Obtenemos la primer letra del nombre, si el primer nombre es maria o jose y existe un segundo nombre se utiliza el segundo nombre.
        if($.inArray(nombre1,nombres) > -1 && nombre2 != 'SINDEFINIR'){
            curp = curp + nombre2[0];
        }else{
            curp = curp +nombre1[0];
        }

        //Obtenemos la fecha de nacimiento, el sexo y el lugar de nacimiento
        curp = curp+""+getFecha(settings.fechaNacimiento);
        curp = curp + settings.sexo.toUpperCase() + settings.lugarNacimiento;

        //Obtenemos la primer consonante interna del apellido paterno,materno y el primer nombre
        curp = curp + consonanteInterna(apater);
        curp = curp + consonanteInterna(amater);
        curp = curp + consonanteInterna(nombre1);

        //Los dos últimos digitos son de control generados por el gobierno para evitar duplicados y no tenemos acceso a ellos.
        curp = curp + "00";

        //Se ejecuta función callback si existe.
        if ($.isFunction(callbackFunction)) {
            callbackFunction.call();
        }

        //Se verifica que tipo de elemento DOM es this para ejecutar la instrucción correcta.
        tmp = this[0].tagName;
        if(tmp == 'INPUT'){
            return this.val(curp);
        }else{
            return this.html(curp);
        }

    };
}(jQuery));