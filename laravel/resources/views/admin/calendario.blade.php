@extends('layouts.app')

@section('content')

<h1 class="mb-4">Calendario de Avisos</h1>

<div class="card">
    <div class="card-body">
        <div id="calendario"></div>
    </div>
</div>

@endsection

@section('scripts')

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
const avisos = {!! json_encode($eventos) !!};

document.addEventListener('DOMContentLoaded', function() {

    const calendar = new FullCalendar.Calendar(document.getElementById('calendario'), {
        initialView: 'dayGridMonth',
        locale: 'es',
        height: 650,

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        events: avisos,

        eventClick: function(info) {
            const p = info.event.extendedProps;

            alert(
                '📌 Código: ' + info.event.title +
                '\n📄 Descripción: ' + p.descripcion +
                '\n📍 Dirección: ' + p.direccion +
                '\n📞 Teléfono: ' + p.telefono +
                '\n📊 Estado: ' + p.estado +
                '\n⚡ Urgencia: ' + p.urgencia
            );
        }
    });

    calendar.render();
});
</script>

@endsection