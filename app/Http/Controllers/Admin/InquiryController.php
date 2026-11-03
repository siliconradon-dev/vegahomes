<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstimateAttachment;
use App\Models\EstimateInquiry;
use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $inquiries = $this->filtered($request)
            ->withCount('attachments')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.inquiries.index', [
            'inquiries' => $inquiries,
            'packages'  => Package::orderBy('sort_order')->pluck('name', 'slug'),
            'filters'   => $request->only(['q', 'status', 'package', 'district']),
        ]);
    }

    public function show(EstimateInquiry $inquiry)
    {
        $inquiry->load('attachments');

        return view('admin.inquiries.show', ['inquiry' => $inquiry]);
    }

    public function update(Request $request, EstimateInquiry $inquiry)
    {
        $data = $request->validate([
            'status'      => ['required', Rule::in(array_keys(config('vega.inquiry_statuses')))],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($inquiry->status === 'new' && $data['status'] !== 'new' && !$inquiry->contacted_at) {
            $data['contacted_at'] = now();
        }

        $inquiry->update($data);

        return back()->with('status', 'Enquiry ' . $inquiry->reference . ' updated.');
    }

    public function destroy(EstimateInquiry $inquiry)
    {
        Storage::deleteDirectory('estimates/' . $inquiry->reference);
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('status', 'Enquiry deleted.');
    }

    public function attachment(EstimateInquiry $inquiry, EstimateAttachment $attachment)
    {
        abort_unless($attachment->estimate_inquiry_id === $inquiry->id, 404);
        abort_unless(Storage::exists($attachment->path), 404, 'File not found on disk.');

        return Storage::download($attachment->path, $attachment->original_name);
    }

    public function export(Request $request)
    {
        $query = $this->filtered($request)->latest();
        $name  = 'vega-enquiries-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel opens it correctly

            fputcsv($out, [
                'Reference', 'Date', 'Status', 'Package', 'Rate (LKR/sq.ft)', 'House type', 'Total area (sq.ft)',
                'Estimated cost (LKR)', 'District', 'Town/Area', 'Design status', 'Approval status',
                'Name', 'Phone', 'Email', 'Land', 'Expected start', 'Comments',
            ]);

            $query->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    fputcsv($out, [
                        $r->reference, $r->created_at->format('Y-m-d H:i'), $r->status_label, $r->package_name,
                        $r->rate, $r->house_type, $r->total_area, $r->estimated_cost, $r->district, $r->town_area,
                        $r->design_status, $r->approval_status, $r->name, $r->phone, $r->email, $r->land_ownership,
                        optional($r->start_date)->format('Y-m-d'), $r->comments,
                    ]);
                }
            });

            fclose($out);
        }, $name, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function filtered(Request $request): Builder
    {
        $query = EstimateInquiry::query();

        $q = trim((string) $request->query('q'));
        if ($q !== '') {
            $query->where(function (Builder $w) use ($q) {
                $like = '%' . $q . '%';
                $w->where('reference', 'like', $like)
                    ->orWhere('name', 'like', $like)
                    ->orWhere('phone', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('town_area', 'like', $like);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }
        if ($request->filled('package')) {
            $query->where('package_slug', $request->query('package'));
        }
        if ($request->filled('district')) {
            $query->where('district', $request->query('district'));
        }

        return $query;
    }
}
