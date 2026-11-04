<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesignInquiry;
use App\Models\DesignPackage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DesignInquiryController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.design-inquiries.index', [
            'inquiries' => $this->filtered($request)->latest()->paginate(15)->withQueryString(),
            'packages'  => DesignPackage::orderBy('sort_order')->pluck('name', 'slug'),
            'filters'   => $request->only(['q', 'status', 'package']),
        ]);
    }

    public function show(DesignInquiry $inquiry)
    {
        return view('admin.design-inquiries.show', ['inquiry' => $inquiry]);
    }

    public function update(Request $request, DesignInquiry $inquiry)
    {
        $data = $request->validate([
            'status'      => ['required', Rule::in(array_keys(config('vega.inquiry_statuses')))],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($inquiry->status === 'new' && $data['status'] !== 'new' && !$inquiry->contacted_at) {
            $data['contacted_at'] = now();
        }

        $inquiry->update($data);

        return back()->with('status', 'Design enquiry ' . $inquiry->reference . ' updated.');
    }

    public function destroy(DesignInquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.design-inquiries.index')->with('status', 'Design enquiry deleted.');
    }

    public function export(Request $request)
    {
        $query = $this->filtered($request)->latest();
        $name  = 'vega-design-enquiries-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'Reference', 'Date', 'Status', 'Package', 'Calculation', 'Area (sq.ft)', 'House type', 'District',
                'Construction estimate (LKR)', 'Design fee (LKR)', 'Add-ons', 'Name', 'Phone', 'Email', 'Design start', 'Comments',
            ]);

            $query->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    fputcsv($out, [
                        $r->reference, $r->created_at->format('Y-m-d H:i'), $r->status_label, $r->package_name, $r->calculation_basis,
                        $r->area, $r->house_type, $r->district, $r->construction_estimate, $r->design_fee,
                        implode(', ', $r->addon_titles), $r->name, $r->phone, $r->email,
                        optional($r->start_date)->format('Y-m-d'), $r->comments,
                    ]);
                }
            });

            fclose($out);
        }, $name, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function filtered(Request $request): Builder
    {
        $query = DesignInquiry::query();

        $q = trim((string) $request->query('q'));
        if ($q !== '') {
            $query->where(function (Builder $w) use ($q) {
                $like = '%' . $q . '%';
                $w->where('reference', 'like', $like)
                    ->orWhere('name', 'like', $like)
                    ->orWhere('phone', 'like', $like)
                    ->orWhere('email', 'like', $like);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }
        if ($request->filled('package')) {
            $query->where('package_slug', $request->query('package'));
        }

        return $query;
    }
}
