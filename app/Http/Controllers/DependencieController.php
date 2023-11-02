<?php

namespace App\Http\Controllers;

use App\Models\Dependencie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DependencieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dependencies = Dependencie::all();
        
        return Inertia::render('Dependencies/Index',['dependencies' => $dependencies]);

        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('Dependencies/Create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:100']);
        $dependencie = new Dependencie($request->input());
        $dependencie->save();
        return redirect('dependencies');


    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dependencie $dependencie)
    {
        return Inertia::render('Dependencies/Edit',['dependencie' => $dependencie]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dependencie $dependencie)
    {
        $request->validate(['name' => 'required|max:100']);
        $dependencie->update($request->all());
        return redirect('dependencies');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dependencie $dependencie)
    {
        $dependencie->delete();
        return redirect('dependencies');

    }
}
