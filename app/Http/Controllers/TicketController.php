<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use App\Models\Ticket;
use App\Models\User;
use App\Models\ticketAssigned;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller
{

    public function fetchClinicalTicketData(Request $request)
    {
        $columns = [
            'ticket.id',
            'ticket.type_of_concern',
            'branch',
            'ticket.type_equipment_or_machine',
            'ticket.equipment_or_machine_brand',
            'ticket.serial_number',
            'ticket.concern_description',
            'ticket.reported_by',
            'ticket.email',
            'ticket.status',
            'ticket.file',
            'ticket.created_at'
        ];

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $searchValue = $request->input('search.value', '');
        $perPage = $request->input('length', 5);
        $start = $request->input('start', 0);

        $user = auth()->user();

    $query = Ticket::query()
        ->with('assignees')
        ->leftJoin('users as reporter', 'reporter.id', '=', 'ticket.reported_by')
        ->leftJoin('clinics', 'clinics.id', '=', 'ticket.clinics_id')
        ->select(
            'ticket.*',
            'reporter.name as reported_name',
            'clinics.name as branch'
        )
        ->where(function ($q) {
            $q->where('ticket.ticket_type', 'GAOC - Maintenance IR Form')
                ->orWhere('ticket.ticket_type', 'Novodental - Maintenance IR Form');
        });
        

    // Non-superadmin: show tickets from their own clinic, OR tickets they created themselves
    if ($user->role !== 'superadmin') {
        $query->where(function ($q) use ($user) {
            $q->where('ticket.clinics_id', $user->clinics_id)
            ->orWhere('ticket.reported_by', $user->id);
        });
    }

        // FILTER BY TYPE OF CONCERN
        if ($request->filled('type_of_concern')) {
            $query->where('ticket.type_of_concern', $request->type_of_concern);
        }

        // SEARCH
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('ticket.type_of_concern', 'like', "%{$searchValue}%")
                    ->orWhere('ticket.type_equipment_or_machine', 'like', "%{$searchValue}%")
                    ->orWhere('ticket.equipment_or_machine_brand', 'like', "%{$searchValue}%")
                    ->orWhere('ticket.concern_description', 'like', "%{$searchValue}%")
                    ->orWhere('reporter.name', 'like', "%{$searchValue}%")
                    ->orWhere('clinics.name', 'like', "%{$searchValue}%");
            });
        }

        if (isset($columns[$orderColumnIndex])) {
            $query->orderBy($columns[$orderColumnIndex], $orderDir);
        }
        $recordsFiltered = (clone $query)->count();

        $totalQuery = Ticket::query()
            ->where(function ($q) {
                $q->where('ticket.ticket_type', 'GAOC - Maintenance IR Form')
                    ->orWhere('ticket.ticket_type', 'Novodental - Maintenance IR Form');
            });

        if ($user->role !== 'superadmin') {
            $totalQuery->where('ticket.clinics_id', $user->clinics_id);
        }

        $recordsTotal = $totalQuery->count();

        $tickets = $query->skip($start)
            ->take($perPage)
            ->get()
            ->map(function ($ticket) {
                $ticket->assignees = $ticket->assignees->map(function ($assignee) {
                    return [
                        'id' => $assignee->id,
                        'name' => $assignee->name
                    ];
                })->toArray();

                return $ticket;
            });

        return response()->json([
            'draw' => (int) $request->input('draw', 1),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $tickets,
        ]);
    }




    public function fetchOfficeTicketData(Request $request)
    {
        $columns = [
            'ticket.id',
            'ticket.type_of_concern',
            'branch',
            'ticket.type_equipment_or_machine',
            'ticket.equipment_or_machine_brand',
            'ticket.serial_number',
            'ticket.concern_description',
            'ticket.reported_by',
            'ticket.email',
            'ticket.status',
            'ticket.file',
            'assigned_name',
            'ticket.created_at'
        ];

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $searchValue = $request->input('search.value', '');
        $perPage = $request->input('length', 5);
        $start = $request->input('start', 0);

        $user = auth()->user();

$query = Ticket::query()
    ->with('assignees')
    ->leftJoin('users as reporter', 'reporter.id', '=', 'ticket.reported_by')
    ->leftJoin('clinics', 'clinics.id', '=', 'ticket.clinics_id')
    ->select(
        'ticket.*',
        'reporter.name as reported_name',
        'clinics.name as branch'
    )
    ->where(function ($q) {
        $q->where('ticket.ticket_type', 'GSS - Maintenance IR Form')
            ->orWhere('ticket.ticket_type', 'GGC Offices - Maintenance IR Form');
    });

// Non-superadmin: show tickets from their own clinic, OR tickets they created themselves
if ($user->role !== 'superadmin') {
    $query->where(function ($q) use ($user) {
        $q->where('ticket.clinics_id', $user->clinics_id)
          ->orWhere('ticket.reported_by', $user->id);
    });
}

    // FILTER BY TYPE OF CONCERN
    if ($request->filled('type_of_concern')) {
        $query->where('ticket.type_of_concern', $request->type_of_concern);
    }

        // SEARCH
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('ticket.type_of_concern', 'like', "%{$searchValue}%")
                    ->orWhere('ticket.type_equipment_or_machine', 'like', "%{$searchValue}%")
                    ->orWhere('ticket.equipment_or_machine_brand', 'like', "%{$searchValue}%")
                    ->orWhere('ticket.concern_description', 'like', "%{$searchValue}%")
                    ->orWhere('assigned.name', 'like', "%{$searchValue}%")
                    ->orWhere('clinics.name', 'like', "%{$searchValue}%");
            });
        }

        if (isset($columns[$orderColumnIndex])) {
            $query->orderBy($columns[$orderColumnIndex], $orderDir);
        }

        $recordsTotal = Ticket::count();
        $recordsFiltered = $query->count();

        $tickets = $query->skip($start)
            ->take($perPage)
            ->get();

        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $tickets
        ]);
    }


    public function taskAssign(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:ticket,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        try {
            $ticket = Ticket::find($validated['ticket_id']);
            
            // Sync with timestamps
            $syncData = [];
            foreach ($validated['user_ids'] as $userId) {
                $syncData[$userId] = [
                    'assigned_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            
            $ticket->assignees()->sync($syncData);
            
            return response()->json([
                'success' => true,
                'message' => 'Users assigned successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

public function updateStatus(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);

    if ($request->status == 'Pending') {

        $ticket->status = 'Pending';
        $ticket->remarks = null;
    }

    if ($request->status == 'On hold') {

        $request->validate([
            'remarks' => 'required|string'
        ]);

        $ticket->status = 'On hold';
        $ticket->remarks = $request->remarks;
    }

    if ($request->status == 'For Approved') {

        if ($ticket->status !== 'Pending') {
            return response()->json([
                'message' => 'Ticket must be Pending before it can be sent for approval.'
            ], 422);
        }

        $request->validate([
            'remarks' => 'required|string'
        ]);

        $ticket->status = 'For Approved';
        $ticket->remarks = $request->remarks;
    }

    if ($request->status == 'Done') {

        if (auth()->user()->role !== 'fdo') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        if ($ticket->status !== 'For Approved') {
            return response()->json([
                'message' => 'Ticket must be For Approved before it can be marked Done.'
            ], 422);
        }

        $ticket->status = 'Done';
    }

    $ticket->save();

    return response()->json([
        'success' => true
    ]);
}
        


    public function index_clinics()
    {
        $users = User::where('role', 'Maintenance')
                ->select('id', 'name')
                ->get();

        $ticket = Ticket::all();

        return view('ticket.index_clinics', compact('ticket','users'));
    }

    public function index_offices()
    {
        $users = User::select('id', 'name')->get();

        $ticket = Ticket::all();

        return view('ticket.index_offices', compact('ticket','users'));
    }


        // viewing of ticket frontend route

    public function createGAOC()
    {
        $clinic = Clinics::all();
        $user = User::all();
        return view('ticket.ticket-form.gaoc-form',compact('clinic','user'));
    }

    public function createNOVO()
    {
        $clinic = Clinics::all();
        $user = User::all();
        return view('ticket.ticket-form.novo-form',compact('clinic','user'));
    }

    public function createGSS()
    {
        $clinic = Clinics::all();
        $user = User::all();
        return view('ticket.ticket-form.gss-form',compact('clinic','user'));
    }

    public function createGCC()
    {
        $clinic = Clinics::all();
        $user = User::all();
        return view('ticket.ticket-form.ggc-form',compact('clinic','user'));
    }



   public function store(Request $request)
   {

        $user_branch = auth()->user()->branch;
        $user_email = auth()->user()->email;

        try {
            $request->validate([
                'ticket_type'                => 'required|string|max:255',
                'type_equipment_or_machine'  => 'required|string|max:255',
                'equipment_or_machine_brand' => 'required|string|max:255',
                'serial_number'              => 'required|string|max:255',
                'concern_description'        => 'required|string|max:255',
                'file'                       => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors()
            ], 422);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('tickets', 'public');
        }

        $ticket = Ticket::create([
            'ticket_type'                => $request->ticket_type,
            'type_of_concern'            => $request->type_of_concern,
            'clinics_id'                 => $user_branch,
            'type_equipment_or_machine'  => $request->type_equipment_or_machine,
            'equipment_or_machine_brand' => $request->equipment_or_machine_brand,
            'serial_number'              => $request->serial_number,
            'concern_description'        => $request->concern_description,
            'reported_by'                => auth()->id(),
            'email'                      => $user_email,
            'status'                     => 'Pending',
            'file'                       => $filePath,
            'assigned_by'                => null,

        ]);
            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully',
                'data'    => $ticket
            ]);
    }



    public function editGAOC(String $id)
    {
        $ticket = Ticket::find($id);
        $user = User::select('id', 'name')->get();
        $clinic = Clinics::select('id', 'name')->get();


        return view('ticket.edit-ticket-form.gaoc-form', compact('ticket', 'user', 'clinic'));
    }

public function update(Request $request)
{
    try {
        $request->validate([
            'type_of_concern' => 'required|string|max:255',
            'clinics_id' => 'nullable|exists:clinics,id',
            'equipment_or_machine' => 'required|string|max:255',
            'equipment_or_machine_brand' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'concern_description' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'errors' => $e->errors()
        ], 422);
    }

    // Find the ticket by ID
    $ticket = Ticket::findOrFail($request->id);

    // Keep old file by default
    $filePath = $ticket->file;

    // Check if new file is uploaded
    if ($request->hasFile('file')) {
        // Store new file and replace old file path
        $filePath = $request->file('file')->store('tickets', 'public');
    }

    // Update the ticket, only changing fields if new values are present
    $ticket->update([
        'type_of_concern' => $request->type_of_concern,
        'clinics_id' => $request->clinics_id,
        'equipment_or_machine' => $request->equipment_or_machine,
        'equipment_or_machine_brand' => $request->equipment_or_machine_brand,
        'serial_number' => $request->serial_number,
        'concern_description' => $request->concern_description,
        'email' => $request->email,
        'status' => 'Pending',
        'file' => $filePath, // update only if new file uploaded
        'assigned_by' => null
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Ticket updated successfully',
        'data' => $ticket
    ]);
}


    public function destroy(String $id)
    {
    $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }
    
        $ticket->delete();
        return response()->json(['success' => 'Ticket deleted successfully!']);
    }
}
