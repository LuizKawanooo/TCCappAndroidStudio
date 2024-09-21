// routes/api.php
Route::get('/horarios', 'HorarioController@index');

// app/Http/Controllers/HorarioController.php
public function index()
{
    $horarios = Horario::all();
    return response()->json($horarios);
}

// app/Models/Horario.php
public function getStatusAttribute()
{
    return $this->status_horario ? 'available' : 'unavailable';
}
