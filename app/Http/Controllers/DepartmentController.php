<?php

namespace App\Http\Controllers;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

 public function fetchDepartmentData(Request $request)
    {
        $columns = ['id',  'name', 'contact_number', 'email', 'created_at'];

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $searchValue = $request->input('search.value', '');
        $perPage = $request->input('length', 10);
        $start = $request->input('start', 0);

        $query = Department::query()->select($columns);

        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('id', 'LIKE', "%{$searchValue}%")
                ->orWhere('name', 'LIKE', "%{$searchValue}%")
                ->orWhere('email', 'LIKE', "%{$searchValue}%")
                ->orWhere('created_at', 'LIKE', "%{$searchValue}%")
                ->orWhere('contact_number', 'LIKE', "%{$searchValue}%");
            });
        }

        $query->orderBy($columns[$orderColumnIndex] ?? 'id', $orderDir);

        $recordsTotal = Department::count();
        $recordsFiltered = $query->count();

        $department = $query->skip($start)->take($perPage)->get();


        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $department
        ]);
    }



    public function index()
    {
        $department = Department::all();

        return view('department.index', compact('department'));
    }


    public function create()
    {
        $department = Department::all();
        return view('department.create', compact('department'));
    }


    public function store(Request $request)
    {
             // Validate input
        $request->validate([
            'name' => 'required|string|max:255|unique:department,name',
            'email' => 'required',
            'contact_number' => 'required',
        ],
        [
           'department.unique' => 'The Department name already exists!' 
        ]);

        // Create the category
        $department = Department::create([
            'company' => $request->company,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Department added successfully!',
            'data' => $department,
        ], 201);
    }

    public function edit(string $id)
    {
        $department = Department::find($id);

        return view('department.edit', compact('department'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'id'      => 'required|exists:department,id',
            'name'    => 'required',
            'contact_number' => 'required',
            'email' => 'required',
        ]);

        $department = Department::find($request->id);


        // Update procedure details
        $department->update([
            'name'           => $request->name,
            'contact_number' => $request->contact_number,
            'email'          => $request->email,

        ]);
    
        return response()->json([
            'success'   => true,
            'message'   => 'Department updated successfully',
            'data' => $department
        ]);
       
    }

    public function destroy(string $id)
    {
    $department = Department::find($id);

        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }
    
        $department->delete();
        return response()->json(['success' => 'Department deleted successfully!']);
    }
}
