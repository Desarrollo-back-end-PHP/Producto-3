public function store(NuevaSolicitudRequest $request)
{
    // Crear la incidencia del cliente
    $incidencia = Incidencia::create([
        'codigo'         => 'INC-' . strtoupper(uniqid()),
        'usuario_id'     => Auth::id(),
        'descripcion'    => $request->descripcion,
        'tipo_servicio'  => $request->tipo_servicio,
        'fecha_servicio' => $request->fecha_servicio,
        'estado'         => 'pendiente',
    ]);

    // Crear el aviso correspondiente para que admin/técnico lo vean
    \App\Models\Aviso::create([
        'codigo'        => $incidencia->codigo,
        'usuario_id'    => Auth::id(),
        'urgencia'      => $request->tipo_servicio,
        'fecha'         => $request->fecha_servicio,
        'descripcion'   => $request->descripcion,
        'estado'        => 'pendiente',
    ]);

    return redirect()->route('incidencias.index')
        ->with('success', 'Solicitud creada correctamente.');
}