$(document).ready(function() {
    $('#btnEnviar').click(function() {

        Swal.fire({
            title: "Ingrese una fecha inicial y una final",
            confirmButtonText: "Aceptar",
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,

            showDenyButton: true,
            denyButtonText: "Cancelar",

            background: "linear-gradient(63deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 37%, rgba(0,212,255,1) 100%)",
            color: "#FFFFFF",

            html: '<input type="date" id="Date1" class="flex-nowrap w-50 swal2-input">' +
                '<input type="date" id="Date2" class="flex-nowrap w-50 swal2-input">',

        }).then(function(isConfirm) {

            var date1 = $('#Date1').val();
            var date2 = $('#Date2').val();
            if (isConfirm.isConfirmed) {

                if (date1 > date2) {

                    Swal.fire({
                        icon: "error",
                        title: "Error en las fechas",
                        text: "asegurese de agregar correctamente las fechas",
                        timer: "3500",
                        showConfirmButton: false,
                        timerProgressBar: true,
                        customClass: {
                            timerProgressBar: "progress-bar"
                        },
                        iconColor: "#FFFFFF",
                        color: "#FFFFFF",
                        background: "linear-gradient(63deg, rgba(2,0,36,1) 22%, rgba(121,9,32,1) 48%, rgba(255,0,22,1) 100%)"

                    });

                } // termina if error 

                //*urls para madar a cada ajax
                url = base_url + "Historico/tabla1";
                url2 = base_url + "Historico/tabla2";
                url5 = base_url + "Historico/tabla4";

                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    data: { 'date1': date1, 'date2': date2 },
                    success: function(data) {
                        $("#tableReporte").empty()

                        data.forEach(centro => {

                            switch (centro.prefijo) {
                                case 'ECI':
                                    centro.prefijo = 'LCC';
                                    break;
                            }

                            var fila = "<tr>" +

                                "<td>" + centro.nombre + "</td>" +
                                "<td>" + centro.pagodia + "</td>" +
                                "<td>" + centro.pago2 + "</td>" +
                                "<td>" + centro.totales + "</td>" +
                                "<td>" + centro.porcentaje + "%" + "</td>" +
                                "<td>" + centro.nombreproeducto + "</td>" +
                                "<td>" + centro.factor + "%" + "</td>" +
                                "</tr>";
                            $("#tableReporte").append(fila);
                        }); // termina forEach

                        $("#tableReporte tr:last").css('background-color', '#e6e6e7').css('font-weight', '800');
                    }

                }); //termina ajax reporte por centro

                $.ajax({
                        type: "POST",
                        url: url3,
                        dataType: "json",
                        data: { 'date1': date1, 'date2': date2 },
                        success: function(dataCoach) {
                            $("#table").empty();

                            dataCoach.forEach(coach => {
                                var tablacoach = "<tr>" +

                                    "<td>" + coach.nombre + "</td>" +
                                    "<td>" + coach.pago + "</td>" +
                                    "<td>" + coach.dato1 + "</td>" +
                                    "<td>" + coach.base + "</td>" +
                                    "<td>" + coach.total + "</td>" +
                                    "<td>" + coach.asistencia + "</td>" +
                                    "<td>" + coach.factor + "%" + "</td>" +
                                    "<td>" + coach.conexion + "</td>" +
                                    "<td>" + coach.horas + "%" + "</td>" +
                                    "<td>" + coach.porcentaje + "</td>" +
                                    "</tr>";

                                $("#table").append(tablacoach);

                            }); //termina forEach de coach

                            $("#table tr:last").css("background-color", "#e6e6e7").css('font-weight', '800');

                        }
                    }) //termina ajax de reporte 

                /* TODO: Empieza reporte */
                $.ajax({
                    type: "POST",
                    url: url5,
                    dataType: "json",
                    data: { 'date1': date1, 'date2': date2 },
                    success: function(sector) {
                        $("#sector").empty();
                        sector.forEach(function(sectores) {

                            var tablasector = "<tr>" +
                                "<td>" + sectores.sector + "</td>" +
                                "<td>" + sectores.ventas + "</td>" +
                                "<td>" + sectores.asistencia + "</td>" +
                                "<td>" + sectores.factor + "</td>" +
                                "</tr>"
                            $("#sector").append(tablasector);
                        });
                    },
                }); //Fin de reporte


            } //termina la confirmacion de cancelar

            /************************quiero obtner este ajax para descargar el excel **************************** */
            urlexcel = base_url + "Inicio/generarExcel";
            $.ajax({
                type: "POST",
                url: urlexcel,
                data: { 'date1': date1, 'date2': date2 },
                cache: false,
                success: function(data) {
                    $('#excel').append(data);

                }

            })

        });


    }); // cierre de llave y parentesis de #btnEnviar


});