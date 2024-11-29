<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category()
    {

        $reasons = [
            "Entertainment",
            "Social Service",
            "Education",
            "Sports and Fitness",
            "Networking",
            "Arts and Culture",
            "Technology",
            "Health and Wellness",
            "Food and Drink",
            "Family and Kids",
            "Religious and Spiritual",
            "Shopping",
            "Travel and Adventure",
            "Others"
        ];
        

        return responseSuccess($reasons, 200);
    }
}