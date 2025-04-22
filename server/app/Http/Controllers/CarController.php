<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Repositories\CarRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    // Fetch all car brands
    public function index()
    {
        $id = 0;
        if (auth()->user()->id) {
            $id = auth()->user()->id;
        }
        return response()->json(Car::where('user_id', 0)->orWhere('user_id', $id)->get());
    }

    /**
     * Fetch car brands created by the current user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchUserCars()
    {
        $userId = auth()->id(); // Lấy ID của người dùng hiện tại
        $userCarBrands = Car::where('user_id', $userId)->get();
        return response()->json(
            $userCarBrands,
        );
    }

    /**
     * Store multiple car brands.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $names = $request->input('names', []);
        $results = [];
        $skipped = [];

        foreach ($names as $name) {
            // Skip if the name already exists for the user or globally
            if (Car::where('name', $name)
                ->where(function ($query) {
                    $query->where('user_id', Auth::id())->orWhere('user_id', 0);
                })->exists()
            ) {
                $skipped[] = $name; // Track skipped names
                continue;
            }

            $cars= CarRepository::create($name);
            $results[] = $cars;
        }

        return response()->json([
            'success' => $results,
            'skipped' => $skipped,
        ], 201);
    }

    /**
     * Delete a car brand by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $carBrand = Car::find($id);

        if (!$carBrand) {
            return response()->json(['message' => 'Car brand not found.'], 404);
        }

        if ($carBrand->user_id !== Auth::id() && $carBrand->user_id !== 0) {
            return response()->json(['message' => 'You do not have permission to delete this car brand.'], 403);
        }

        $carBrand->delete();

        return response()->json(['message' => 'Car brand deleted successfully.'], 200);
    }
}
