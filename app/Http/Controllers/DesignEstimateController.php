<?php

namespace App\Http\Controllers;

use App\Models\DesignInquiry;
use App\Models\DesignPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DesignEstimateController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Hidden trap field: real visitors leave it empty. Browser auto-fill can fill it by mistake,
        // so we never drop the enquiry - we only flag it for the admin.
        $flagged = $request->filled('hp_extra');

        $data = $request->validate([
            'package'    => ['required', Rule::in(DesignPackage::active()->pluck('slug')->all())],
            'area'       => ['required', 'numeric', 'min:1', 'max:1000000'],
            'house_type' => ['required', Rule::in(config('vega.design_house_types'))],
            'district'   => ['nullable', Rule::in(config('vega.districts'))],
            'addons'     => ['nullable', 'array', 'max:12'],
            'addons.*'   => ['string', Rule::in(array_keys(config('vega.design_addons')))],
            'name'       => ['required', 'string', 'max:120'],
            'phone'      => ['required', 'string', 'max:40'],
            'email'      => ['nullable', 'email', 'max:190'],
            'start_date' => ['nullable', 'date'],
            'comments'   => ['nullable', 'string', 'max:3000'],
            'consent'    => ['accepted'],
        ], [
            'consent.accepted' => 'Please tick the consent box so we can contact you.',
        ]);

        $package = DesignPackage::active()->where('slug', $data['package'])->firstOrFail();
        $area    = round((float) $data['area'], 2);
        $calc    = $package->calculate($area);

        $inquiry = DesignInquiry::create([
            'reference'             => $this->newReference(),
            'package_slug'          => $package->slug,
            'package_name'          => $package->name,
            'pricing_type'          => $package->pricing_type,
            'rate'                  => $package->rate,
            'construction_rate'     => $package->construction_rate,
            'area'                  => $area,
            'house_type'            => $data['house_type'],
            'district'              => $data['district'] ?? null,
            'construction_estimate' => $calc['construction'],
            'design_fee'            => $calc['fee'],
            'calculation_basis'     => $calc['basis'],
            'addons'                => array_values(array_unique($data['addons'] ?? [])),
            'name'                  => $data['name'],
            'phone'                 => $data['phone'],
            'email'                 => $data['email'] ?? null,
            'start_date'            => $data['start_date'] ?? null,
            'comments'              => $data['comments'] ?? null,
            'status'                => 'new',
            'ip'                    => $request->ip(),
            'admin_notes'           => $flagged ? 'Spam trap field was filled - please check this enquiry.' : null,
        ]);

        return response()->json([
            'ok'           => true,
            'reference'    => $inquiry->reference,
            'design_fee'   => config('vega.public_rates') ? $inquiry->fee_label : $inquiry->fee_range_label,
            'whatsapp_url' => $inquiry->whatsappUrl(),
        ]);
    }

    private function newReference(): string
    {
        do {
            $ref = 'VH-D-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        } while (DesignInquiry::where('reference', $ref)->exists());

        return $ref;
    }
}
