<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contato = Contato::where('user_id', Auth::user()->id)->get();
        return view('contatos.index', compact('contatos'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contatos.creat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validade([
            'nome' => 'required',
            'numero' => 'required',
            'email' => 'nullable|email',
        ]);

        Contato::creat([
            'user_id' => Auth::id(),
            'nome' => $request->nome,
            'numero' => $request->numero,
            'email'=> $request->email,
        ]);

        return redirect()->route('contatos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contato $contato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contato $contato)
    {
        if ($contato->user_id !== Auth::id()) abort(403);
        return view('contatos.edit', compact('contato'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contato $contato)
    {
        if ($contato->user_id !== Auth::id()) abort(403);

        $request->validate([
            'nome' => 'required',
            'numer'=> 'required',
            'email'=> 'nullable|email',
        ]);
        $contato->update($request->only('nome','numer','email'));
        return redirect()->route('contatos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contato $contato)
    {
        if ($contato->user_id !== Auth::id()) abort(403);
        $contato->delete();
        return redirect()->route('contatos.index');
    }
}
