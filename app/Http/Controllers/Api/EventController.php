<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventCreateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\EventVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagination_limit = request()->query('pagination_limit');
        $search_keyword = request()->query('search_keyword');

        $vendors = Event::with('eventVendors.event')->where('user_id',Auth::user()->id)->when($search_keyword, function ($query) use ($search_keyword) {
            $query->where('title', 'like', '%' . $search_keyword . '%');
        })
            ->latest();

        $pagination = $pagination_limit ? $vendors->paginate($pagination_limit) : $vendors->get();

        return EventResource::collection($pagination);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventCreateRequest $request)
    {
        try {

            $event = DB::transaction(function () use ($request) {
                $event = Event::create([
                    'user_id' => Auth::user()->id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'address' => $request->address
                ]);

                if ($request->event_image) {
                    $event->addMedia($request->event_image)->toMediaCollection('event_image');
                }

                if ($request->has('event_vender_id') && is_array($request->event_vender_id)) {
                    $eventVendors = collect($request->event_vender_id)->map(function ($event_vender_id) use ($event) {
                        return [
                            'user_id' => Auth::id(),
                            'event_id' => $event->id,
                            'vendor_user_id' => $event_vender_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    })->toArray();
                    EventVendor::insert($eventVendors);
                }

                return $event;
            });

            if ($event) {
                return responseSuccess(new EventResource($event), 200, 'Event Created Successfully!');
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