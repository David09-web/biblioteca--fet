<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Aviso;

class AvisoController extends Controller
{
    public function index()
    {
        $avisos = Aviso::latest()->get();
        return view('avisos.index', compact('avisos'));
    }

    public function create()
    {
        return view('avisos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Aviso::create($validated);

        return redirect()->route('avisos.index')->with('success', 'Aviso publicado exitosamente.');
    }
}
