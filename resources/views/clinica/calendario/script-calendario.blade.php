<script>
    let url = "{{ config('global.url_base') }}/clinica/calendario/mostrar" 
    
    $(document).ready(() => {
        $('#search_id_profesional').on('change', function() {
            let profesional = $(this).val();            
            consultarAgendas(profesional)
        });
    })

    function openModal() {
        $("#days").prop("readonly", false)
        $("#evento").modal('show')
        $("#btn-cancelar").css("display", "none");
        $("#btn-guardar").css("display", "block");
    }

    let botonGuardar = document.getElementById('btn-guardar').addEventListener("click", function() {

        let fechaHoraActual = new Date();            
        if($("#start").val() < parseDateToString(fechaHoraActual)){
            toastr.error("La fecha debe ser superior a la actual", "Error")
            return;
        }

        if($("#days").val() == null){
            toastr.error("El día o días de la cita es obligatorio", "Error")
            return;
        }

        if($("#identificacion").val().trim() == ""){
            toastr.error("La identificacion del paciente es obligatoria", "Error")
            return;
        }
        if($("#nombres").val().trim() == ""){
            toastr.error("El nombre del paciente es obligatorio", "Error")
            return;
        }

        if($("#title").val().trim() == ""){
            toastr.error("El motivo de cita es obligatorio", "Error")
            return;
        }   

        if($("#fecha_nacimiento").val().trim() == ""){
            toastr.error("La fecha de nacimiento es obligatorio", "Error")
            return;
        }  

        if($("#id_cita").val() != "" && $("#id_cita").val() != null){
            if($("#days").val().length > 1){
                toastr.error("Para la edicion de citas, el campo días de ser [Todos los dias]", "Error")
                return;
            }

            if($("#days").val()[0] != "all"){
                toastr.error("Para la edicion de citas, el campo días de ser [Todos los dias]", "Error")
                return;
            }
        }
        Loading(true);
        $('#form-citas').submit()
    });

    async function consultarAgendas(profesional) {
        try {
            Loading(true, "Consultando agendas...");
            let validacion = await $.get(url+'/'+profesional);
            if(validacion.error){
                Loading(false);
                toastr.error(validacion.message, "Error")
                return;
            }
            
            IniciarCalendario(validacion.data)
            Loading(false);
        } catch (error) {
            Loading(false);
            console.log(error);
        }   
    }

    function buscarPersona(caracter) { 
        if(caracter.length > 6){
            $("#modal-search-loading").css("display", "grid")
            let url = "{{ config('global.url_base') }}/tercero/buscar/" + caracter
            $.get(url, (res) => {
                $("#modal-search-loading").css("display", "none")
                if(res.length == 1){
                    const data = res[0]
                    $("#tipo_identificacion").val(data.id_dominio_tipo_identificacion)
                    $("#identificacion").val(data.identificacion)
                    $("#nombres").val(data.nombres)
                    $("#apellidos").val(data.apellidos)
                    $("#telefono").val(data.telefono)
                    $("#genero").val(data.id_dominio_sexo)
                    $("#email").val(data.email)
                    $("#fecha_nacimiento").val(data.fecha_nacimiento)
                    $("#direccion").val(data.direccion)
                }
            }).fail((error) => {
                $("#modal-search-loading").css("display", "grid")
            })
        }
    }

    function IniciarCalendario(eventos) {                      
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: isMobile() ? 'timeGridDay' : 'dayGridMonth',
            locale: 'es',
            dateClick: selectedDate,
            eventClick: selectedEvent,
            eventMouseLeave: hoverEvent,
            displayEventTime: false,
            events: eventos.map((item)=>{
                if(item.atendida==1){
                    item.className ='eventGreen'
                }
                return item
            }),
            headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
                    longPressDelay: 0,  
            },
            
        })
        calendar.render()
    }

    function selectedDate(info) {
        if(info.date < new Date()){
            toastr.error("Solo se permiten fechas mayores a la actual", "Ups")
            return;
        }
        $("#btn-cancelar").css("display", "block");
        $("#btn-guardar").css("display", "block");

        let formulario = document.getElementById('form-citas');
        formulario.reset();
        $("#id_cita").val('')          
        $("#evento").modal("show");
        $("#days").prop("readonly", false)
        if($("#id_cita").val() == ''){
            $("#btn-cancelar").css("display", "none");
        }else{
            $("#btn-cancelar").css("display", "block");
        }
        $("#start").val(parseDatetimeFromCalendar(info.dateStr));
        $("#end").val(parseDatetimeFromCalendar(info.dateStr));
        let profesional = document.getElementById('search_id_profesional').value;
        $("#id_profesional").val(parseInt(profesional));
        botonGuardar
    }

    function selectedEvent(info) {
        let event = {
            days: "all",
            start: info.event.start,
            end: info.event.end,
            id: info.event.id,
            title: info.event.title,
        }
       
        Object.assign(event, info.event.extendedProps);
        $("#evento").modal("show");
        if(info.event.id == ''){
            $("#btn-cancelar").css("display", "none");
        }else{
            $("#btn-cancelar").css("display", "block");
        }

        if(event.atendida == 1){
            $("#btn-cancelar").css("display", "none");
            $("#btn-guardar").css("display", "none");
        }else{
            $("#btn-cancelar").css("display", "block");
            $("#btn-guardar").css("display", "block");
        }
        
        let motivoConsulta = event.title.split('-') 
        $("#days").prop("readonly", true)
        $("#id_cita").val(info.event.id)
        $("#start").val(parseDateToString(event.start));
        $("#end").val(parseDateToString(event.end));
        $("#id_profesional").val(event.id_profesional)
        $("#title option").filter(function() {
            return $(this).text() == motivoConsulta[1];
        }).prop("selected", true);
        $("#tipo_identificacion").val(info.event.extendedProps.tercero.id_dominio_tipo_identificacion)
        $("#identificacion").val(info.event.extendedProps.tercero.identificacion)
        $("#nombres").val(info.event.extendedProps.tercero.nombres)
        $("#apellidos").val(info.event.extendedProps.tercero.apellidos)
        $("#genero").val(info.event.extendedProps.tercero.id_dominio_sexo)
        $("#telefono").val(info.event.extendedProps.tercero.telefono)
        $("#fecha_nacimiento").val(info.event.extendedProps.tercero.fecha_nacimiento)
        $("#email").val(info.event.extendedProps.tercero.email)
        $("#observaciones").val(info.event.extendedProps.observaciones)

        document.getElementById('btn-cancelar').addEventListener("click", function() {
            if(confirm("¿Esta seguro de cancelar la cita?")){
                let url = "{{ config('global.url_base') }}/clinica/calendario/cancelar/" + info.event.id
                $.get(url, (response) => {
                toastr.success(response.message, "Proceso exitoso")
                $("#evento").modal("hide");
                consultarAgendas(response.data.id_profesional);                   
            }).fail((error) => {
                console.log(error);
            })
            }
        });
        
    }
    
    function hoverEvent(info) { 
        $(info.el).tooltip({ 
            title: info.event.extendedProps.tercero.nombres + " " + info.event.extendedProps.tercero.apellidos + " " + ` (Horario: ${parseDateToString(info.event.start)} hasta ${parseDateToString(info.event.end)})` 
        });
    }



</script>