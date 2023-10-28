<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Computer;
use App\Models\Dependencie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $computers = Computer::select(
        'computers.id',
        'computers.name',
        'so',
        'ofimatica',
        'cpu',
        'storage',
        'ram',
        'ip',
        'mac',
        'serial',
        'fixed_asset',
        'anydesk',
        'printer',
        'scanner',
        'dependencie_id','dependencies.name as dependencie')
        ->join('dependencies','dependencies.id','=','computers.dependencie_id')
        ->paginate(10);

        $dependencies = Dependencie::all();
        return Inertia::render('Computers/Index',['computers' => $computers,
        'dependencies' => $dependencies]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'so' => 'required|max:100',
            'ofimatica' => 'required|max:150',
            'cpu' => 'required|max:150',
            'storage' => 'required|max:150',
            'ram' => 'required|max:150',
            'ip' => 'required|max:150|unique',
            'mac' => 'required|max:150',
            'serial' => 'required|max:150',
            'fixed_asset' => 'required|max:150',
            'anydesk' => 'required|max:150',
            'printer' => 'required|max:150',
            'scanner' => 'required|max:150',
            'dependencie_id' => 'required|numeric'
        ]);
        $computer = new Computer($request->input());
        $computer->save();
        return redirect('computers');

    }

    /**
     * Display the specified resource.
     */
    public function show(Computer $computer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Computer $computer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Computer $computer)
    {
        $request->validate([
            'name' => 'required|max:150',
            'so' => 'required|max:100',
            'ofimatica' => 'required|max:150',
            'cpu' => 'required|max:150',
            'storage' => 'required|max:150',
            'ram' => 'required|max:150',
            'ip' => 'required|max:150|unique',
            'mac' => 'required|max:150',
            'serial' => 'required|max:150',
            'fixed_asset' => 'required|max:150',
            'anydesk' => 'required|max:150',
            'printer' => 'required|max:150',
            'scanner' => 'required|max:150',
            'dependencie_id' => 'required|numeric'
        ]);
        $computer ->update($request->input());
        return redirect('computers');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Computer $computer)
    {
        $computer->delete();
        return redirect('computers');

    }

    public function ComputerByDependencie()
    {

        $data = Computer::select(DB::raw('count(computers.id) as count, dependencies.name'))
        ->join('dependencies','dependencies.id','=','computers.department_id')
        ->groupBy('dependencies.name')->get();
        return Inertia::render('Computers/Graphic',['data' => $data]);
    }

    public function reports(){

        $computers = Computer::select(
            'computers.id',
            'computers.name',
            'so',
            'ofimatica',
            'cpu',
            'storage',
            'ram',
            'ip',
            'mac',
            'serial',
            'fixed_asset',
            'anydesk',
            'printer',
            'scanner',
            'dependencie_id','dependencies.name as dependencie')
            ->join('dependencies','dependencies.id','=','computers.dependencie_id')->get();


        $dependencies = Dependencie::all();

        return Inertia::render('Computers/Reports',['computers' => $computers,
        'dependencies' => $dependencies]);
    }


}
