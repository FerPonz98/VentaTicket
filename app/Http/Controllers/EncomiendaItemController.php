<?php

namespace App\Http\Controllers;

use App\Models\Encomienda;
use App\Models\EncomiendaItem;
use Illuminate\Http\Request;

class EncomiendaItemController extends Controller
{
    /**
     * Show form to create a new item for a given encomienda
     */
    public function create(Encomienda $encomienda)
    {
        return view('encomienda_items.create', compact('encomienda'));
    }

    /**
     * Store a newly created item in storage
     */
    public function store(Request $request, Encomienda $encomienda)
    {
        $data = $request->validate([
            'cantidad'    => 'required|integer|min:1',
            'descripcion' => 'required|string|max:255',
            'peso'        => 'required|numeric|min:0.01',
            'costo'       => 'required|numeric|min:0',
        ]);

        $encomienda->items()->create($data);

        return redirect()
            ->route('encomiendas.show', $encomienda)
            ->with('success', 'Ítem agregado correctamente.');
    }

    /**
     * Show form to edit the specified item
     */
    public function edit(Encomienda $encomienda, EncomiendaItem $item)
    {
        return view('encomienda_items.edit', compact('encomienda', 'item'));
    }

    /**
     * Update the specified item in storage
     */
    public function update(Request $request, Encomienda $encomienda, EncomiendaItem $item)
    {
        $data = $request->validate([
            'cantidad'    => 'required|integer|min:1',
            'descripcion' => 'required|string|max:255',
            'peso'        => 'required|numeric|min:0.01',
            'costo'       => 'required|numeric|min:0',
        ]);

        $item->update($data);

        return redirect()
            ->route('encomiendas.show', $encomienda)
            ->with('success', 'Ítem actualizado correctamente.');
    }

    /**
     * Remove the specified item from storage
     */
    public function destroy(Encomienda $encomienda, EncomiendaItem $item)
    {
        $item->delete();

        return redirect()
            ->route('encomiendas.show', $encomienda)
            ->with('success', 'Ítem eliminado correctamente.');
    }
}
