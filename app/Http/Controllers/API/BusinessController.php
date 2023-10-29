<?php

namespace App\Http\Controllers\API;

use App\Models\Business;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\BusinessRepositoryInterface;

class BusinessController extends Controller
{
    protected $businessRepository;

    public function __construct(BusinessRepositoryInterface $businessRepository)
    {
        $this->businessRepository = $businessRepository;
    }

    public function getBusinessDetails($id)
    {
        $business = $this->businessRepository->businessDetails($id);

        if (!$business) {
            return response()->json(['error' => 'Business Not Found'], 404);
        }

        return response()->json($business);
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'required|url',
            'is_closed' => 'required|boolean',
            'url' => 'required|url',
            'review_count' => 'required|integer',
            'transactions' => 'required|string|max:255',
            'rating' => 'required|numeric|between:0,5',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'price' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'display_phone' => 'required|string|max:20',
            'distance' => 'required|numeric',
        ]);

        $data['alias'] = Str::slug($data['name']);

        $business = $this->businessRepository->create($data);

        return response()->json(['message' => 'Business created successfully', 'data' => $business], 201);
    }
}
