<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use Illuminate\Http\Request;

class ClinicsController extends Controller
{

    public function fetchClinicData(Request $request)
    {
        $columns = ['id', 'company', 'name', 'contact_number', 'email', 'address', 'created_at'];

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $searchValue = $request->input('search.value', '');
        $perPage = $request->input('length', 10);
        $start = $request->input('start', 0);

        $query = Clinics::query()->select($columns);

        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('id', 'LIKE', "%{$searchValue}%")
                ->orWhere('name', 'LIKE', "%{$searchValue}%")
                ->orWhere('email', 'LIKE', "%{$searchValue}%")
                ->orWhere('address', 'LIKE', "%{$searchValue}%")
                ->orWhere('created_at', 'LIKE', "%{$searchValue}%")
                ->orWhere('contact_number', 'LIKE', "%{$searchValue}%");
            });
        }

        $query->orderBy($columns[$orderColumnIndex] ?? 'id', $orderDir);

        $recordsTotal = Clinics::count();
        $recordsFiltered = $query->count();

        $clinic = $query->skip($start)->take($perPage)->get();


        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $clinic
        ]);
    }


    public function index()
    {
        $clinic = Clinics::all();

        return view('clinic.index', compact('clinic'));
    }

    public function create()
    {
        $clinic = Clinics::all();
        return view('clinic.create', compact('clinic'));
    }


    public function store(Request $request)
    {
            // Validate input
        $request->validate([
            'company' => 'required',
            'name' => 'required|string|max:255|unique:clinics,name',
            'email' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
        ],
        [
           'name.unique' => 'The clinic name already exists!' 
        ]);

        // Create the category
        $clinic = Clinics::create([
            'company' => $request->company,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Clinic added successfully!',
            'clinic' => $clinic,
        ], 201);
        
    }

 
    public function edit(String $id)
    {
        $clinic = Clinics::find($id);

        return view('clinic.edit', compact('clinic'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'id'      => 'required|exists:clinics,id',
            'name'    => 'required',
            'company'    => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'email' => 'required',
        ]);

        $clinic = Clinics::find($request->id);


        // Update procedure details
        $clinic->update([
            'name'           => $request->name,
            'company'        => $request->company,
            'address'        => $request->address,
            'contact_number' => $request->contact_number,
            'email'          => $request->email,

        ]);
    
        return response()->json([
            'success'   => true,
            'message'   => 'Clinic updated successfully',
            'clinic' => $clinic
        ]);
    }


    public function destroy(String $id)
    {
        $clinic = Clinics::find($id);

        if (!$clinic) {
            return response()->json(['error' => 'Clinic not found'], 404);
        }
    
        $clinic->delete();
        return response()->json(['success' => 'Clinic deleted successfully!']);
    }

}
