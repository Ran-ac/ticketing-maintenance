<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Department;
use App\Models\Clinics;
use Illuminate\Http\Request;


use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function fetchUserData(Request $request)
    {
        // Map DataTables column index => qualified DB column
        $columns = [
            'users.id',
            'users.name',
            'users.email',
            'users.address',
            'clinics.name',          // branch is displayed as the clinic name
            'users.contact_number',
            'users.role',
            'users.created_at',
        ];

        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc') === 'desc' ? 'desc' : 'asc';
        $searchValue = $request->input('search.value', '');
        $perPage = (int) $request->input('length', 10);
        $start = (int) $request->input('start', 0);

        $query = User::query()
            ->with('user_department')
            ->leftJoin('clinics', 'clinics.id', '=', 'users.branch')
            ->select('users.*', 'clinics.name as branch');

        // SEARCH
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('users.id', 'LIKE', "%{$searchValue}%")
                ->orWhere('users.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('users.email', 'LIKE', "%{$searchValue}%")
                ->orWhere('clinics.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('users.role', 'LIKE', "%{$searchValue}%")
                ->orWhere('users.created_at', 'LIKE', "%{$searchValue}%")
                ->orWhereHas('user_department', function ($d) use ($searchValue) {
                    $d->where('department.name', 'LIKE', "%{$searchValue}%");
                });
            });
        }

        // SORTING
        $query->orderBy($columns[$orderColumnIndex] ?? 'users.id', $orderDir);

        $recordsTotal = User::count();
        $recordsFiltered = $query->count();

        // PAGINATION
        $users = $query->skip($start)->take($perPage)->get();

        // FORMAT DEPARTMENT OUTPUT
        $users->each(function ($user) {
            $user->department = $user->user_department->pluck('name')->implode(', ');
        });

        return response()->json([
            'draw' => (int) $request->input('draw', 1),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $users,
        ]);
    }


    public function index()
    {
        $users = User::all();
        $clinic = Clinics::all();

        return view('users.index', compact('users','clinic'));
    }


    public function create()
    {
        $users = User::all();
        $clinic = Clinics::all();
        $department = Department::all();


        return view('users.create',compact('users','department','clinic'));
    }


    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'branch' => 'required|exists:clinics,id',
            'department' => 'required',
            'role' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

         $clinic = Clinics::findOrFail($request->branch);

        // Create the user
        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'branch' => $clinic->id,
            'address' => $request->address,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $users->user_department()->attach($request->department);

        return response()->json([
            'success' => true,
            'message' => 'User added successfully!',
            'data' => $users,
        ], 201);
    }

    public function edit(string $id)
    {
        $users = User::find($id);
        $department = Department::select('name')->get();
        $clinic = Clinics::select('id', 'name')->get();
        $userDepartmentIds = $users->user_department->pluck('id')->toArray();


        return view('users.edit',compact('users','department','userDepartmentIds','clinic'));
    }


    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'contact_number' => 'required',
                'branch' => 'required',
                'address' => 'required',
                'department' => 'required',
                'role' => 'required',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

         $users = User::find($request->id);


        $users->update([
                'name' => $request->name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'branch' => $request->branch,
                'address' => $request->address,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket updated successfully',
            'data' => $users
        ]);

    }


    public function destroy(string $id)
    {
        //
    }
}
