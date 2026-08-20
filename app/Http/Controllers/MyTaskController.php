<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Http\Request;

class MyTaskController extends Controller
{

    public function fetchMyTaskTickets(Request $request)
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
            'ticket.assigned_by',
            'ticket.email',
            'ticket.status',
            'ticket.file',
            'ticket.remarks',
            'ticket.created_at'
        ];

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $searchValue = $request->input('search.value', '');
        $perPage = $request->input('length', 5);
        $start = $request->input('start', 0);
        $userId = auth()->id();

    $query = Ticket::query()
        ->with('assignees')
        ->leftJoin('users as reporter', 'reporter.id', '=', 'ticket.reported_by')
        ->leftJoin('users as resolved_by', 'resolved_by.id', '=', 'ticket.assigned_by')
        ->leftJoin('clinics', 'clinics.id', '=', 'ticket.clinics_id')
        ->join('ticket_assigned', 'ticket.id', '=', 'ticket_assigned.ticket_id')
        ->select(
            'ticket.*',
            'reporter.name as reported_name',
            'resolved_by.name as resolved_by',
            'clinics.name as branch'
        )
    ->where(function ($q) {
        $q->where('ticket.ticket_type', 'GAOC - Maintenance IR Form')
            ->orWhere('ticket.ticket_type', 'Novodental - Maintenance IR Form')
            ->orWhere('ticket.ticket_type', 'GSS - Maintenance IR Form')
            ->orWhere('ticket.ticket_type', 'GGC Offices - Maintenance IR Form');
    })
        ->where('ticket_assigned.user_id', $userId)
        ->distinct();

        if ($request->filled('type_of_concern')) {
            $query->where('ticket.type_of_concern', $request->type_of_concern);
        }


        $recordsTotal = (clone $query)->count();

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

        $tickets = $query->skip($start)
            ->take($perPage)
            ->get()
            ->map(function ($ticket) {
                $ticket->assignees = $ticket->assignees->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name
                    ];
                })->toArray();

                return $ticket;
            });

        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $tickets
        ]);
    }


    public function index()
    {
        $mytask = ticket::all();

        return view('myTask.my-task', compact('mytask'));
    }


    public function create()
    {
        
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
