<script>
    let url = "{{ config('global.url_base') }}/citas/calendario/mostrar" 
    
    $(document).ready(() => {
        $('#profesional').on('change', function() {
            let profesional = $(this).val();            
            consultarAgendas(profesional)
        }); 
        
    })

    async function consultarAgendas(profesional) {
        try {
            let validacion = await $.get(url+'/'+profesional);
            if(validacion.error){
                toastr.error(validacion.message, "Error")
                return;
            }
            IniciarCalendario(validacion.data)
            
        } catch (error) {
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
                    $("#correo").val(data.email)
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
            events: eventos,
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
        let formulario = document.getElementById('form-citas');
        formulario.reset();
        $("#id_cita").val('')          
        $("#evento").modal("show");
        if($("#id_cita").val() == ''){
            $("#btn-cancelar").css("display", "none");
        }else{
            $("#btn-cancelar").css("display", "block");
        }
        $("#start").val(parseDatetimeFromCalendar(info.dateStr));
        $("#end").val(parseDatetimeFromCalendar(info.dateStr));
        let profesional = document.getElementById('profesional').value;
        $("#modal-profesional").val(parseInt(profesional));

        
        document.getElementById('btn-guardar').addEventListener("click", function() {
            const datos = new FormData(formulario);            
            
            if($("#identificacion").val().trim() == ""){
                toastr.error("La identificacion del paciente es obligatoria", "Error")
                return;
            }
            if($("#nombres").val().trim() == ""){
                toastr.error("El nombre del paciente es obligatorio", "Error")
                return;
            }
            if($("#apellidos").val().trim() == ""){
                toastr.error("El apellido del paciente es obligatorio", "Error")
                return;
            }
            if($("#title").val().trim() == ""){
                toastr.error("El motivo de cita es obligatorio", "Error")
                return;
            }

            $('#form-citas').submit()
    
        });

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
  
        $("#id_cita").val(info.event.id)
        $("#start").val(parseDateToString(event.start));
        $("#end").val(parseDateToString(event.end));
        $("#modal-profesional").val(event.id_profesional)
        $("#title").val(event.title)
        $("#tipo_identificacion").val(info.event.extendedProps.tercero.id_dominio_tipo_identificacion)
        $("#identificacion").val(info.event.extendedProps.tercero.identificacion)
        $("#nombres").val(info.event.extendedProps.tercero.nombres)
        $("#apellidos").val(info.event.extendedProps.tercero.apellidos)
        $("#genero").val(info.event.extendedProps.tercero.id_dominio_sexo)
        $("#telefono").val(info.event.extendedProps.tercero.telefono)
        $("#correo").val(info.event.extendedProps.tercero.email)
        $("#observaciones").val(info.event.extendedProps.observaciones)


        
        
    }
    
    function hoverEvent(info) { 
        $(info.el).tooltip({ 
            title: info.event.title + ` (Horario: ${parseDateToString(info.event.start)} hasta ${parseDateToString(info.event.end)})` 
        });
    }

</script>