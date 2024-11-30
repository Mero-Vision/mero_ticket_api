<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserTicket\UserTicketCreateRequest;
use App\Http\Resources\UserTicketResource;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagination_limit = request()->query('pagination_limit');
        
        $vendors = UserTicket::with('event','event_ticket')->where('user_id', Auth::user()->id)
            ->latest();

        $pagination = $pagination_limit ? $vendors->paginate($pagination_limit) : $vendors->get();

        return UserTicketResource::collection($pagination);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserTicketCreateRequest $request)
    {
        try {

            $userTicket = DB::transaction(function () use ($request) {
                $userTicket = UserTicket::create([
                    'user_id' =>Auth::user()->id,
                    'ticket_id' => $request->ticket_id,
                    'event_id' => $request->event_id,
                    'price' => $request->price,
                ]);

                return $userTicket;
            });

            if ($userTicket) {
                $userTicket->load('event','event_ticket');
                return responseSuccess(new UserTicketResource($userTicket), 200, 'Ticket Purchased Successfully!');
            }
        } catch (\Exception $e) {
            return responseError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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