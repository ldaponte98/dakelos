$(document).ready(function() {
    $('#filtro').keyup(function() {
        var rex = new RegExp($(this).val(), 'i');
        $('#bodytable tr').hide();
        $('#bodytable tr').filter(function() {
            console.log(rex.test($(this).text()));
            
            return rex.test($(this).text());
        }).show();
    }) 
});
const format = (number) => new Intl.NumberFormat("de-DE").format(number)

function setFiltro(id_input_filtro, id_tabla) {
    $(`#${id_input_filtro}`).keyup(function() {
        var rex = new RegExp($(this).val(), 'i');
        $(`#${id_tabla} tbody tr`).hide();
        $(`#${id_tabla} tbody tr`).filter(function() {
            return rex.test($(this).text());
        }).show();
    })
}

function buscar(caracteres) {
    if (caracteres.length > 3) {
        url = "/tercero/buscar/" + caracteres
        $.get(url, (response) => {
            var resultados = ""                
            if (response.length > 0) {
                response.forEach((tercero) => {
                    resultados += "<a class='dropdown-item media' href='/tercero/view/" + tercero.id_tercero + "'><b>" + tercero.identificacion + " - " + tercero.nombres + " " + tercero.apellidos + "</b></a>"
                })
                if (resultados != "") {
                    $("#div_busqueda").html(resultados)
                    $("#div_busqueda").fadeIn()
                } else {
                    $("#div_busqueda").html("")
                    $("#div_busqueda").fadeOut()
                }
            } else {
                $("#div_busqueda").html("")
                $("#div_busqueda").fadeOut()
            }
        })
    } else {
        $("#div_busqueda").html("")
        $("#div_busqueda").fadeOut()
    }
}

function Loading(show = true, message = "Por favor espere...") {
    if (show) {
        $.blockUI({
            message: `<i class="fa fa-spinner mt-3 fa-spin fa-5x fa-fw" style="color: #ffffff;"></i><h1><b>${message}</b></h1>`,
            css: {
                border: 'none',
                padding: '70px 5px 30px 5px',
                backgroundColor: 'transparent',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: 1,
                color: '#ffffff'
            }
        });
    } else {
        $.unblockUI();
    }
}

function Format(number) {
    return new Intl.NumberFormat("de-DE").format(number);
}

jQuery.datetimepicker.setLocale('es');

jQuery('.datetimepicker').datetimepicker({
 i18n:{
  es:{
   months:[
    'Enero','Febrero','Marzo','Abril',
    'Mayo','Junio','Julio','Agosto',
    'Septiembre','Octubre','Noviembre','Diciembre',
   ],
   dayOfWeek:[
    "Do", "Lu", "Ma", "Mi",
    "Ju", "Vi", "Sa",
   ]
  }
 },
 timepicker: true,
 format:'Y-m-d H:i'
});

jQuery('.datepicker').datetimepicker({
  i18n:{
   es:{
    months:[
     'Enero','Febrero','Marzo','Abril',
     'Mayo','Junio','Julio','Agosto',
     'Septiembre','Octubre','Noviembre','Diciembre',
    ],
    dayOfWeek:[
     "Do", "Lu", "Ma", "Mi",
     "Ju", "Vi", "Sa",
    ]
   }
  },
  timepicker: false,
  format:'Y-m-d'
 });

 FullCalendar.globalLocales.push(function () {
    'use strict';
     var es = {
         code: "es",
         week: {
             dow: 1,
             doy: 4
         },
         buttonText: {
             prev: "Ant",
             next: "Sig",
             today: "Hoy",
             month: "Mes",
             week: "Semana",
             day: "Día",
             list: "Agenda"
         },
         weekText: "Sm",
         allDayText: "Todo el día",
         moreLinkText: "más",
         noEventsText: "No hay eventos para mostrar"
     };
     return es;
  }());

  function isMobile() {
    return /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
  }

  function addZero(i) {
    if (i < 10) {i = "0" + i}
    return i;
  }

  function getHour(d) {
    let h = addZero(d.getHours());
    let m = addZero(d.getMinutes());
    let s = addZero(d.getSeconds());
    return h + ":" + m;
  }

  function parseDatetimeFromCalendar(strDate) {
        //2024-08-06T12:00:00-05:00
        if(strDate.includes("T")){
            let array = strDate.split("T")
            let date = array[0];
            let time = array[1].split("-")[0]; //12:00:00
            let arrayTime = time.split(":"); //[12, 00, 00] 
            time = arrayTime[0] + ":" + arrayTime[1]; //12:00
            return date + " " + time; //2024-08-06 12:00
        }else{
            let current = new Date();  
            let time = `${addZero(current.getHours())}:${addZero(current.getMinutes())}`      
            return `${strDate} ${time}`
        }
  }

  function parseDateToString(d) {
    let h = addZero(d.getHours());
    let m = addZero(d.getMinutes());
    let a = addZero(d.getFullYear());
    let me = addZero(d.getMonth() + 1);
    let day = addZero(d.getDate());
    return `${a}-${me}-${day} ${h}:${m}`;
  }

  function parseOnlyDateToString(d) {
    let h = addZero(d.getHours());
    let m = addZero(d.getMinutes());
    let a = addZero(d.getFullYear());
    let me = addZero(d.getMonth() + 1);
    let day = addZero(d.getDate());
    return `${a}-${me}-${day}`;
  }