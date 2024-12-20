<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Resources\AgentResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagination_limit = request()->query('pagination_limit');
        $search_keyword = request()->query('search_keyword');

        $vendors = User::role(User::VENDOR)->when($search_keyword, function ($query) use ($search_keyword) {
            $query->where('name', 'like', '%' . $search_keyword . '%');
        })
            ->latest();

        $pagination = $pagination_limit ? $vendors->paginate($pagination_limit) : $vendors->get();

        return AgentResource::collection($pagination);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        try {

            $agent = DB::transaction(function () use ($request) {
                $agent = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => $request->password,
                    'address' => $request->address,
                    'organization_name' => $request->organization_name,
                    'organization_category' => $request->organization_category
                ]);

                $agent->assignRole(User::VENDOR);

                if ($request->organization_logo) {
                    $agent->addMedia($request->organization_logo)->toMediaCollection('organization_logo');
                }
                return $agent;
            });

            if ($agent) {
                return responseSuccess(new AgentResource($agent), 200, 'Agent Account Created Successfully!');
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