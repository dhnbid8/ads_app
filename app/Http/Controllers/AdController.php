<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Filters\AdFilter;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\AdResource;

class AdController extends Controller
{
     /**
     * Display a listing of ads
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filter = new AdFilter($request);
            
            $ads = Ad::query()
                ->when($filter, function ($query) use ($filter) {
                    return $filter->apply($query);
                })
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate($request->get('per_page', 15));

            return response()->json([
                'success' => true,
                'message' => 'آگهی‌ها با موفقیت دریافت شدند',
                'data' => AdResource::collection($ads->items()),
                'pagination' => [
                    'current_page' => $ads->currentPage(),
                    'per_page' => $ads->perPage(),
                    'total' => $ads->total(),
                    'last_page' => $ads->lastPage(),
                    'has_more' => $ads->hasMorePages()
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در دریافت آگهی‌ها',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Display the specified ad
     */
    public function show(Ad $ad): JsonResponse
    {
        try {
            // Increment views
            $ad->incrementViews();

            return response()->json([
                'success' => true,
                'message' => 'آگهی با موفقیت دریافت شد',
                'data' => new AdResource($ad)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در دریافت آگهی',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Get ads statistics
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = [
                'total_ads' => Ad::count(),
                'active_ads' => Ad::active()->count(),
                'featured_ads' => Ad::featured()->count(),
                'expired_ads' => Ad::where('expires_at', '<', now())->count(),
                'operators' => Ad::selectRaw('operator, COUNT(*) as count')
                    ->groupBy('operator')
                    ->get()
                    ->pluck('count', 'operator'),
                'total_views' => Ad::sum('views'),
                'avg_price' => Ad::avg('price')
            ];

            return response()->json([
                'success' => true,
                'message' => 'آمار با موفقیت دریافت شد',
                'data' => $stats
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در دریافت آمار',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }
}
