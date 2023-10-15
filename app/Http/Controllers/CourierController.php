<?php

namespace App\Http\Controllers;

use App\Events\UserLog;
use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $couriers = Courier::all();
        return view('dashboard', ['couriers' => $couriers]);
    }

    public function create()
    {
        return view('Courier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
            'release_date' => 'required|date',
        ]);

        $courier = Courier::create($request->all());
        $user = auth()->user()->name;

        $log_entry = $user . " added a courier \"" . $courier->name . "\" with the ID #" . $courier->id;
        event(new UserLog($log_entry));

        return redirect()->route('courier.index')->with('success', 'Courier added successfully.');

    }

    public function show(Courier $courier)
    {
        // return view('courier.show', compact('courier'));
    }

    public function edit(Courier $courier)
    {
        return view('Courier.edit', compact('courier'));
    }

    public function update(Request $request, Courier $courier)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
            'release_date' => 'required|date',
        ]);

        $courier->update($request->all());
        $user = auth()->user()->name;

        $log_entry = $user . " updated the courier  \"" . $courier->name . "\" with the ID #" . $courier->id;
        event(new UserLog($log_entry));

        return redirect()->route('courier.index')->with('success', 'Courier deleted successfully.');


    }

    public function destroy(Courier $courier)
    {
        $courier->delete();

        $user = auth()->user()->name;

        $log_entry = $user . " removed a  courier \"" . $courier->name . "\" with the ID #" . $courier->id;
        event(new UserLog($log_entry));

        return redirect()->route('courier.index')->with('error', 'Courier deleted successfully.');

    }
}
