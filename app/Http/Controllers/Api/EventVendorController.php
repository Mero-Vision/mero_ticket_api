<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventVendorResource;
use App\Models\EventVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventVendorController extends Controller
{
    public function index()
    {
        $pagination_limit = request()->query('pagination_limit');
        $search_keyword = request()->query('search_keyword');

        $vendors = EventVendor::with('vendorUser')->where('user_id',Auth::user()->id)->when($search_keyword, function ($query) use ($search_keyword) {
            $query->where('title', 'like', '%' . $search_keyword . '%');
        })
            ->latest();

        $pagination = $pagination_limit ? $vendors->paginate($pagination_limit) : $vendors->get();

        return EventVendorResource::collection($pagination);
    }
}