<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinics;
use App\Models\Ticket;
use App\Models\User;


class DashboardController extends Controller
{
   
    public function TicketingDashboard()
    {
        $ticket = Ticket::all();
        $clinic = Clinics::all();
        $user   = User::all();

        $onHoldCount     = Ticket::where('status', 'On Hold')->count();
        $doneCount       = Ticket::where('status', 'Done')->count();
        $pendingCount    = Ticket::where('status', 'Pending')->count();
        $cancelledCount  = Ticket::where('status', 'Cancelled')->count();

        $branchConcerns = Ticket::selectRaw('clinics.name as clinic_name, count(ticket.id) as total')
        ->join('clinics', 'ticket.clinics_id', '=', 'clinics.id')
        ->groupBy('clinics.id', 'clinics.name')
        ->get();

        $branchLabels = $branchConcerns->pluck('clinic_name');
        $branchData   = $branchConcerns->pluck('total');

        return view('dashboard', compact(
            'clinic',
            'user',
            'ticket',
            'onHoldCount',
            'doneCount',
            'pendingCount',
            'cancelledCount',
            'branchLabels',
            'branchData'
        ));
    }



    public function index()
    {
        // return view('dashboard');
    }


    public function create()
    {
      
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
