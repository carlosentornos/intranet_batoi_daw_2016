// variables globales
var datos = [];

// función que se ejecutará al cargar el JS
// aunque no se cargue antes el árbol DOM
$(function(){

	// para los datapicker
	$('#fechasalida, #fechallegada').datepicker();
	// función que llama a formFunctions y modifica
	// a formato del calendario al español
	datepickerCastellano();

	// no se envían los datos directamente
	// se validarán
    $('#submit').click(function(evt) {
        evt.preventDefault();
        checkData(evt);
    });

});

// funcion para comprobar los datos
// escritos en el formulario
function checkData() {
    var errores = [];

    //campo nombre
    var nombre = $('#nombre').val();
    if (checkNameLastname(nombre)) {
        datos.nombre = nombre;
    } else {
        errores.push("el campo nombre no puede estar vacio o no debe ser mas largo de 25 caracteres");
    }

    //apellido1
    var apellido1 = $('#apellido1').val();
    if (checkNameLastname(apellido1)) {
        datos.apellido1 = apellido1;
    } else {
        errores.push("el campo apellido1 no puede estar vacio o no debe ser mas largo de 25 caracteres");
    }

    //apellido2
    var apellido2 = $('#apellido2').val();
    if (checkNameLastname(apellido2)) {
        datos.apellido2 = apellido2;
    } else {
        errores.push("el campo apellido2 no puede estar vacio o no debe ser mas largo de 25 caracteres.");
    }

    // nif
    var nif = $('#nif').val();
    if(nif!==""){
    	datos.nif = nif;
    }else {
    	errores.push("el nif no puede estar vacío.");
    }

    // detalle del servicio
    var servicio = $('#servicio').val();
    if(checkServicios(servicio)){
    	datos.servicio = servicio;
    }else{
    	errores.push("el detalle del servicio no puede estar vacío o excede los 200 caracteres.")
    }

    // para la fecha de salida no hace falta comprobar
    var fechaSalida = $('#fechasalida').val();
    datos.fechaSalida = fechaSalida;

    // hora de salida
    var horasalida = $('#horasalida').val();
    if(checkTimeFormat(horasalida)){
    	datos.horasalida = horasalida;
    }else {
    	errores.push("la hora de salida no es correcta.");
    }

    // para la fecha de llegada no hace falta comprobar
    var fechaLlegada = $('#fechallegada').val();
    datos.fechaLlegada = fechaLlegada;

    // hora de llegada
    var horallegada = $('#horallegada').val();
    if(checkTimeFormat(horallegada)){
    	datos.horallegada = horallegada;
    }else {
    	errores.push("la hora de llegada no es correcta.");
    }

    // dieta alojamiento
    // puede estar vacío, sólo controlar el tamaño
    var dietaAlojamiento = $('#dietaalojamiento').val();
    if(checkDietas(dietaAlojamiento)){
    	datos.dietaAlojamiento = dietaAlojamiento;
    }else{
		errores.push("la dieta de alojamiento excede el tamaño permitido 40.");	
    }
    // dieta comida
    // puede estar vacío, sólo controlar el tamaño
    var dietaComida = $('#dietacomida').val();
    if(checkDietas(dietaComida)){
		datos.dietaComida = dietaComida;
    }else{
    	errores.push("la dieta de comida excede el tamaño permitido de 40.");
    }
    
    // dieta otros gastos
    // puede estar vacío, sólo controlar el tamaño
    var otrosGastos = $('#otrosgastos').val();
    if(checkDietas(otrosGastos)){
		datos.otrosGastos = otrosGastos;
    }else{
    	errores.push("la dieta de otros gastos excede el tamaño permitido de 40.");
    }

    // medio utilizado para desplazarse
    var medioLocomocion = $('#locomocionmedia').val();
    if(checkMedioLocomocion(medioLocomocion)){
    	datos.medioLocomocion = medioLocomocion;
    }else{
    	errores.push("El campo medio de locomoción está vacío o excede los 40 caracteres.");
    }

    // km
    // no contendrá letras, sólo números
    var km = $('#km').val();
    if((!isNaN(km))||(km!=="")){
    	datos.km = km;
    }else{
    	errores.push("El campo km está vacío o no tiene números.");
    }

    // marca del vehículo
    var marcaVehiculo = $('#marcavehiculo').val();
    if(checkMarcaVehiculo(marcaVehiculo)){
    	datos.marcaVehiculo = marcaVehiculo;
    }else{
    	errores.push("La marca del vehículo no puede estar vacía o superar los 18 caracteres.");
    }

    // matricula del vehículo
    var matricula = $('#matricula').val();
    if(checkMatriculaVehiculo(matricula)){
    	datos.matricula = matricula;
    }else{
    	errores.push("La matrícula está vacía o supera los 10 caracteres.");
    }

    // otros medios utilizados de locomoción
    // avión, tren, autobus, taxi...
    // al no ser requerido, puede ser vacío o no
    var otrosMedios = $('#otrosmedios').val();
    datos.otrosMedios = otrosMedios;


    if (errores.length === 0) {
        //enviamos lo datos que hay en la funcion ahora mismo, no los del formulario
        generarPDF(datos);
    }else{
    	showErrors(errores,"errores");
    }

    console.log(errores.length);
    console.log(errores);

}

function generarPDF(datos) {
    
    window.open('php/pdf/plantillaSolicitudAutorizacionComisionServicio.php?nombre='
    	+datos.nombre.toUpperCase() 
    	+'&apellido1='+datos.apellido1.toUpperCase()
        +'&apellido2='+datos.apellido2.toUpperCase()
        +'&nif='+datos.nif.toUpperCase()
        +'&servicio='+datos.servicio.toUpperCase()
        +'&fechasalida='+datos.fechaSalida
        +'&horasalida='+datos.horasalida
        +'&fechallegada='+datos.fechaLlegada
        +'&horallegada='+datos.horallegada
        +'&dietaalojamiento='+datos.dietaAlojamiento.toUpperCase()
        +'&dietacomida='+datos.dietaComida.toUpperCase()
        +'&otrosgastos='+datos.otrosGastos.toUpperCase()
        +'&mediolocomocion='+datos.medioLocomocion.toUpperCase()
        +'&km='+datos.km
        +'&marcavehiculo='+datos.marcaVehiculo.toUpperCase()
        +'&matricula='+datos.matricula.toUpperCase()
        +'&otrosmedios='+datos.otrosMedios);
}


// enviamos los datos del array "datos" a la función que dará de alta estos
// a un fichero PHP que ejecutará un PDF
function altaComisionServicio(datos) {
    // realizar el envío por POST
    $.get('php/pdf/plantillaSolicitudAutorizacionComisionServicio.php', {
        nombre: datos.nombre.toUpperCase(),
        apellido1: datos.apellido1.toUpperCase(),
        apellido2: datos.apellido2.toUpperCase(),
        nif: datos.nif,
        servicio: datos.servicio,
        fechasalida: datos.fechaSalida,
        horasalida: datos.horasalida,
        fechallegada: datos.fechaLlegada,
        horallegada: datos.horallegada,
        dietaalojamiento: datos.dietaAlojamiento,
        dietacomida: datos.dietaComida,
        otrosgastos: datos.otrosGastos,
        mediolocomocion: datos.medioLocomocion.toUpperCase(),
        km: datos.km,
        marcavehiculo: datos.marcaVehiculo.toUpperCase(),
        matricula: datos.matricula.toUpperCase(),
        otrosmedios: datos.otrosMedios
        
    },
    function (dataReceived) {
        //console.log(dataReceived);
        window.open("data:application/pdf;base64, "+dataReceived);
        
    });
}