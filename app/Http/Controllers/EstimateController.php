<?php

namespace App\Http\Controllers;

use App\Models\EstimateInquiry;
use App\Models\Package;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EstimateController extends Controller
{
    private const ALLOWED_EXTENSIONS = [
        'pdf', 'png', 'jpg', 'jpeg', 'webp', 'gif', 'bmp', 'heic', 'dwg', 'dxf', 'doc', 'docx',
    ];

    public function store(Request $request): JsonResponse
    {
        // Hidden trap field: real visitors leave it empty. Browser auto-fill can fill it by mistake,
        // so we never drop the enquiry - we only flag it for the admin.
        $flagged = $request->filled('hp_extra');

        $data = $request->validate([
            'package'         => ['required', Rule::in(Package::active()->pluck('slug')->all())],
            'floors'          => ['required', 'integer', 'between:1,3'],
            'district'        => ['required', Rule::in(config('vega.districts'))],
            'town_area'       => ['required', 'string', 'max:160'],
            'design_status'   => ['required', Rule::in(config('vega.design_statuses'))],
            'approval_status' => ['required', Rule::in(config('vega.approval_statuses'))],
            'rooms'           => ['required', 'string', 'max:30000'],
            'name'            => ['required', 'string', 'max:120'],
            'phone'           => ['required', 'string', 'max:40'],
            'email'           => ['nullable', 'email', 'max:190'],
            'land_ownership'  => ['nullable', Rule::in(config('vega.land_options'))],
            'start_date'      => ['nullable', 'date'],
            'comments'        => ['nullable', 'string', 'max:3000'],
            'consent'         => ['accepted'],
            'attachments'     => ['nullable', 'array', 'max:8'],
            'attachments.*'   => [
                'bail',
                'file',
                'max:10240', // 10 MB each
                function (string $attribute, mixed $value, Closure $fail) {
                    $ext = strtolower($value->getClientOriginalExtension());
                    if (!in_array($ext, self::ALLOWED_EXTENSIONS, true)) {
                        $fail('Only PDF, image, DWG/DXF and Word files can be uploaded.');
                    }
                },
            ],
        ], [
            'consent.accepted' => 'Please tick the consent box so we can contact you.',
        ]);

        $package = Package::active()->where('slug', $data['package'])->firstOrFail();
        [$rooms, $areas] = $this->parseRooms($data['rooms'], (int) $data['floors']);

        $total = round(array_sum($areas), 2);
        if ($total <= 0) {
            throw ValidationException::withMessages([
                'rooms' => 'Please enter at least one room with a length and width.',
            ]);
        }

        $inquiry = EstimateInquiry::create([
            'reference'        => $this->newReference(),
            'package_slug'     => $package->slug,
            'package_name'     => $package->name,
            'rate'             => $package->rate,
            'is_starting_rate' => $package->is_starting_rate,
            'floors'           => (int) $data['floors'],
            'district'         => $data['district'],
            'town_area'        => $data['town_area'],
            'design_status'    => $data['design_status'],
            'approval_status'  => $data['approval_status'],
            'ground_area'      => $areas['ground'],
            'first_area'       => $areas['first'],
            'second_area'      => $areas['second'],
            'total_area'       => $total,
            'estimated_cost'   => (int) round($total * $package->rate),
            'rooms'            => $rooms,
            'name'             => $data['name'],
            'phone'            => $data['phone'],
            'email'            => $data['email'] ?? null,
            'land_ownership'   => $data['land_ownership'] ?? null,
            'start_date'       => $data['start_date'] ?? null,
            'comments'         => $data['comments'] ?? null,
            'status'           => 'new',
            'ip'               => $request->ip(),
            'admin_notes'      => $flagged ? 'Spam trap field was filled - please check this enquiry.' : null,
        ]);

        foreach (Arr::wrap($request->file('attachments', [])) as $file) {
            $ext  = strtolower($file->getClientOriginalExtension());
            $base = Str::limit(Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'file', 60, '');
            $size = $file->getSize();
            $mime = $file->getClientMimeType();

            $stored = $file->storeAs(
                'estimates/' . $inquiry->reference,
                Str::lower(Str::random(6)) . '-' . $base . '.' . $ext
            );

            $inquiry->attachments()->create([
                'original_name' => Str::limit($file->getClientOriginalName(), 180, ''),
                'path'          => $stored,
                'mime'          => $mime,
                'size'          => $size,
            ]);
        }

        return response()->json([
            'ok'             => true,
            'reference'      => $inquiry->reference,
            'total_area'     => $inquiry->total_area,
            'estimated_cost' => config('vega.public_rates') ? $inquiry->cost_label : $inquiry->range_label,
            'whatsapp_url'   => $inquiry->whatsappUrl(),
        ]);
    }

    /**
     * Re-calculates every area on the server so the stored estimate can't be tampered with.
     *
     * @return array{0: array<int, array<string, mixed>>, 1: array<string, float>}
     */
    private function parseRooms(string $json, int $floors): array
    {
        $decoded = json_decode($json, true);
        if (!is_array($decoded)) {
            throw ValidationException::withMessages(['rooms' => 'Room details are invalid. Please try again.']);
        }

        $allowed = array_slice(['ground', 'first', 'second'], 0, $floors);
        $areas   = ['ground' => 0.0, 'first' => 0.0, 'second' => 0.0];
        $clean   = [];

        foreach (array_slice($decoded, 0, 150) as $room) {
            if (!is_array($room)) {
                continue;
            }

            $floor = $room['floor'] ?? null;
            if (!in_array($floor, $allowed, true)) {
                continue;
            }

            $type = trim(Str::limit(strip_tags((string) ($room['type'] ?? '')), 60, ''));
            $qty  = max(1, min(99, (int) ($room['qty'] ?? 1)));
            $len  = max(0.0, min(500.0, (float) ($room['length'] ?? 0)));
            $wid  = max(0.0, min(500.0, (float) ($room['width'] ?? 0)));

            if ($type === '' || $len <= 0 || $wid <= 0) {
                continue;
            }

            $area = round($qty * $len * $wid, 2);
            $areas[$floor] += $area;

            $clean[] = [
                'floor'  => $floor,
                'type'   => $type,
                'qty'    => $qty,
                'length' => $len,
                'width'  => $wid,
                'area'   => $area,
            ];
        }

        return [$clean, array_map(fn ($v) => round($v, 2), $areas)];
    }

    private function newReference(): string
    {
        do {
            $ref = 'VH-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        } while (EstimateInquiry::where('reference', $ref)->exists());

        return $ref;
    }
}
