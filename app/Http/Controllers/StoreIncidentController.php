<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncidentRequest;
use App\Models\Incident;
use Illuminate\Http\Request;

class StoreIncidentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreIncidentRequest $request)
    {
        // return $request->validated();
        $incident = Incident::newModelInstance($request->validated());
        $incident->code = 2;
        $incident->attention_date = now();
        $incident->save();

        // Subir los files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $incident->addMedia($file)
                    ->toMediaCollection('files'); // Agregar a la colección 'files'
            }
        }

        return response()->json($incident, 201);
    }
}
