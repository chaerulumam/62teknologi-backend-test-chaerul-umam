<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Repositories\BusinessRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
