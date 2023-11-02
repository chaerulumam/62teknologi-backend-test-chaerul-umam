<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            return response()->json(['messsage' => 'Business Not Found'], 404);
        }

        return response()->json($business);
    }

    public function getDataByParams(Request $request)
    {
        $field = $request->input('field', null);
        $keyword = $request->input('keyword', null);
        $sortBy = $request->input('sort_by', 'name');
        $limit = $request->input('limit', 10);

        $result = $this->businessRepository->getDataByParams($field, $keyword, $sortBy, $limit);

        if (empty($result['businesses'])) {
            return response()->json([
                "success" => true,
                "message" => "No businesses found based on the provided criteria.",
                "businesses" => [],
            ]);
        }

        return response()->json($result);
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

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string|max:255',
            'image_url' => 'url',
            'is_closed' => 'boolean',
            'url' => 'url',
            'review_count' => 'integer',
            'transactions' => 'string|max:255',
            'rating' => 'numeric|between:0,5',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'price' => 'string|max:255',
            'phone' => 'string|max:20',
            'display_phone' => 'string|max:20',
            'distance' => 'numeric',
        ]);

        $response = $this->businessRepository->updateDataById($id, $data);

        return $response;
    }

    public function destroy($id)
    {
        try {
            $this->businessRepository->deleteDataById($id);

            return response()->json(['message' => 'Business deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
