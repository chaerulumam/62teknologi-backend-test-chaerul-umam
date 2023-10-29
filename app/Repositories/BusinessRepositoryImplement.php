<?php

namespace App\Repositories;

use App\Models\Business;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BusinessRepositoryImplement implements BusinessRepositoryInterface
{
    public function businessDetails($id)
    {
        $business = Business::with('categories', 'location')->find($id);

        if (!$business) {
            return response()->json(['error' => 'Business Not Found'], 404);
        }

        $location = $business->location;
        $locationData = null;

        if ($location) {
            $displayAddress = json_decode($location->display_address);
            $locationData = [
                'address1' => $location->address1,
                'address2' => $location->address2,
                'address3' => $location->address3,
                'city' => $location->city,
                'country' => $location->country,
                'display_address' => $displayAddress,
                'state' => $location->state,
                'zip_code' => $location->zip_code
            ];
        } else {
            $locationData = [
                'address1' => null,
                'address2' => null,
                'address3' => null,
                'city' => null,
                'zip_code' => null,
                'country' => null,
                'state' => null,
                'display_address' => []
            ];
        }

        $response = [
            'businesses' => [
                [
                    'alias' => $business->alias,
                    'categories' => $business->categories->map(function ($category) {
                        return [
                            'alias' => $category->alias,
                            'title' => $category->title
                        ];
                    }),
                    'coordinates' => [
                        'latitude' => $business->latitude,
                        'longtitude' => $business->longtitude
                    ],
                    'display_phone' => $business->display_phone,
                    'disstance' => $business->distance,
                    'id' => $business->id,
                    'image_url' => $business->image_url,
                    'is_closed' => $business->is_closed,
                    'location' => $locationData,
                    'name' => $business->name,
                    'phone' => $business->phone,
                    'price' => $business->price,
                    'rating' => $business->rating,
                    'review_count' => $business->review_count,
                    'transactions' => $business->transactions,
                    'url' => $business->url,
                ]
            ],
            'region' => [
                'center' => [
                    'latitude' =>
                    37.76089938976322,
                    'longitude' => -122.43644714355469,
                ]
            ],
            'total' => $business->count()
        ];

        return response()->json($response);
    }

    public function create(array $data)
    {
        return Business::create($data);
    }

    public function updateDataById(int $id, array $data)
    {
        $business = Business::find($id);

        if (!$business) {
            return response()->json(['message' => 'Business not found'], 404);
        }

        $business->update($data);

        if (isset($data['name'])) {
            $business->update(['alias' => Str::slug($data['name'])]);
        }

        return response()->json([
            'message' => 'Business updated successfully',
            'data' => $business
        ]);
    }

    public function deleteDataById(int $id)
    {
        $business = DB::table('businesses')->where('id', $id)->delete($id);

        if (!$business) {
            throw new \Exception('Delete data failed');
        }

        return $business;
    }
}
