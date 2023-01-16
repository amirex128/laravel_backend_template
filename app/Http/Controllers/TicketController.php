<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    /**
     * @api {get} /ticket ticket.index
     * @apiName ticket.index
     * @apiGroup ticket
     * @apiHeader {String} Authorization token
     */
    public function index(Request $request)
    {
        $tickets = Ticket::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return response()->json($tickets);
    }


    /**
     * @api {post} /ticket ticket.store
     * @apiName ticket.store
     * @apiGroup ticket
     * @apiHeader {String} Authorization token
     * @apiBody {Number} parent_id parent_id
     * @apiBody {String} title title
     * @apiBody {String} body body
     * @apiBody {Number} gallery_id gallery_id
     */
    public function store(StoreTicketRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $ticket = Ticket::create($request->validated());
        return response()->json($ticket);
    }

    /**
     * @api {get} /ticket/{ticket} ticket.show
     * @apiName ticket.show
     * @apiGroup ticket
     * @apiHeader {String} Authorization token
     */
    public function show(Ticket $ticket)
    {
        if ($ticket->visited === false) {
            $ticket->visited = true;
            $ticket->save();
        }
        return response()->json($ticket->with('children'));
    }


    /**
     * @api {put} /ticket/{ticket} ticket.update
     * @apiName ticket.update
     * @apiGroup ticket
     * @apiHeader {String} Authorization token
     * @apiBody {String} title title
     * @apiBody {String} body body
     * @apiBody {Number} gallery_id gallery_id
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        return response()->json($ticket);
    }

    /**
     * @api {delete} /ticket/{ticket} ticket.destroy
     * @apiName ticket.destroy
     * @apiGroup ticket
     * @apiHeader {String} Authorization token
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json([
            'message' => 'تیکت با موفقیت حذف شد',
        ]);
    }
}
