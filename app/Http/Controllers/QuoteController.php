<?php

namespace App\Http\Controllers;

use App\Models\DesignPackage;
use App\Models\Package;
use App\Support\EstimateRange;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Live "approximate range" previews for the popups.
 * Rates stay on the server - the browser only ever receives a rounded range.
 */
class QuoteController extends Controller
{
    public function construction(Request $request): JsonResponse
    {
        if (!EstimateRange::enabled()) {
            return response()->json(['ok' => true, 'show' => false]);
        }

        $data = $request->validate([
            'package' => ['required', Rule::in(Package::active()->pluck('slug')->all())],
            'area'    => ['required', 'numeric', 'min:1', 'max:1000000'],
        ]);

        $package = Package::active()->where('slug', $data['package'])->firstOrFail();
        $cost    = (int) round((float) $data['area'] * $package->rate);

        return response()->json(['ok' => true, 'show' => true, 'range' => EstimateRange::make($cost)['label']]);
    }

    public function design(Request $request): JsonResponse
    {
        if (!EstimateRange::enabled()) {
            return response()->json(['ok' => true, 'show' => false]);
        }

        $data = $request->validate([
            'package' => ['required', Rule::in(DesignPackage::active()->pluck('slug')->all())],
            'area'    => ['required', 'numeric', 'min:1', 'max:1000000'],
        ]);

        $package = DesignPackage::active()->where('slug', $data['package'])->firstOrFail();
        $calc    = $package->calculate((float) $data['area']);

        return response()->json([
            'ok'                 => true,
            'show'               => true,
            'fee_range'          => EstimateRange::make($calc['fee'])['label'],
            'construction_range' => EstimateRange::make($calc['construction'])['label'],
        ]);
    }
}
