<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index() {
        return $this->sendResponse(Ticket::with('fixture')->get(), 'Tickets retrieved successfully');
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'fixture_id' => 'required|exists:fixtures,id',
                'type' => 'required|string',
                'price' => 'required|numeric|min:0',
                'quantity_available' => 'required|integer|min:1',
            ]);

            $ticket = Ticket::create($request->all());
            return $this->sendResponse($ticket, 'Ticket created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create ticket: ' . $e->getMessage());
        }
    }

    public function destroy($id) {
        try {
            Ticket::destroy($id);
            return $this->sendResponse(null, 'Ticket deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete ticket: ' . $e->getMessage());
        }
    }
}
