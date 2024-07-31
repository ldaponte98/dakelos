<script>

    $(document).ready(() => {
        IniciarCalendario();
    })

    function IniciarCalendario(events = []) {
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
        })
        calendar.render()
    }




</script>