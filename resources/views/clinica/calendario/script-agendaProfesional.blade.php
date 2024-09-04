<script>
    let url = "{{ config('global.url_base') }}/clinica/calendario/agendaProfesional" 
    
    $(document).ready(() => {
        consultarAgendas()
    })

    async function consultarAgendas() {
        try {
            let validacion = await $.get(url);
            if(validacion.error){
                toastr.error(validacion.message, "Error")
                return;
            }                        
            IniciarCalendario(validacion.data)
            
        } catch (error) {
            console.log(error);
        }   
    }

    function IniciarCalendario(eventos) {                      
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridDay',
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
        return
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
        $("#btn-atender").css("display", "block");

        if(event.atendida == 1){
            $("#btn-atender").css("display", "none");
        }
        
        $("#id_agenda").val(info.event.id)
        $("#start").val(parseDateToString(event.start));
        $("#title").val(event.title)
        $("#identificacion").val(info.event.extendedProps.tercero.identificacion)
        $("#nombres").val(info.event.extendedProps.tercero.nombres + " " + info.event.extendedProps.tercero.apellidos)
        $("#genero").val(info.event.extendedProps.tercero.id_dominio_sexo)
        $("#telefono").val(info.event.extendedProps.tercero.telefono)
        $("#correo").val(info.event.extendedProps.tercero.email)
        $("#observaciones").val(info.event.extendedProps.observaciones)
        document.getElementById('btn-atender').addEventListener("click", function() {
            Loading(true, "Abriendo historia clinica");
            let url_atender = "{{ config('global.url_base') }}/clinica/historiaClinica/crear/" 
            return window.location.href= url_atender+info.event.id;
        });
    
    }
    
    function hoverEvent(info) {         
        $(info.el).tooltip({    
            title: info.event.extendedProps.tercero.nombres + " " + info.event.extendedProps.tercero.apellidos + " " + ` (Horario: ${parseDateToString(info.event.start)} hasta ${parseDateToString(info.event.end)})` 
        });
    }

</script>