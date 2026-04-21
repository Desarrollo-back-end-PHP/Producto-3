@extends('layouts.app')

@section('content')
<h1 class="mb-4">Calendario de Avisos</h1>
<div id="calendario"></div>
@endsection

@section('scripts')
<script>
const avisos = @json($avisos->map(function($a) {
    return [
        'title' => $a->tipo_servicio . ' - ' . $a->codigo,
        'start' => $a->fecha,
        'color' => $a->urgencia === 'urgente' ? '#e74c3c' : '#27ae60',
        'extendedProps' => [
            'descripcion' => $a->descripcion,
            'direccion'   => $a->direccion,
            'telefono'    => $a->telefono,
            'estado'      => $a->estado,
            'urgencia'    => $a->urgencia,
        ]
    ];
}));

document.addEventListener('DOMContentLoaded', function() {
    const calendar = new FullCalendar.Calendar(document.getElementById('calendario'), {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: avisos,
        eventClick: function(info) {
            const p = info.event.extendedProps;
            alert(
                'Código: ' + info.event.title +
                '\nDescripción: ' + p.descripcion +
                '\nDirección: ' + p.direccion +
                '\nTeléfono: ' + p.telefono +
                '\nEstado: ' + p.estado +
                '\nUrgencia: ' + p.urgencia
            );
        }
    });
    calendar.render();
});
</script>
@endsection