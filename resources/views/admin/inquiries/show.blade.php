@extends('admin.layouts.app')

@section('title', $inquiry->reference)
@section('heading', 'Enquiry ' . $inquiry->reference)

@section('content')
    <div class="adm-crumbs"><a href="{{ route('admin.inquiries.index') }}">&larr; All enquiries</a></div>

    <div class="adm-hero-card">
        <div>
            <span class="adm-badge adm-st-{{ $inquiry->status }}">{{ $inquiry->status_label }}</span>
            <h2>{{ $inquiry->name }}</h2>
            <p>{{ $inquiry->town_area }}, {{ $inquiry->district }} · received {{ $inquiry->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <div class="adm-hero-card__est">
            <span>{{ $inquiry->package_name }} package · {{ $inquiry->house_type }}</span>
            <strong>{{ $inquiry->cost_label }}</strong>
            <small>{{ rtrim(rtrim(number_format($inquiry->total_area, 2), '0'), '.') }} sq.ft. × LKR {{ number_format($inquiry->rate) }} / sq.ft.</small>
        </div>
    </div>

    <div class="adm-grid-2">
        <div class="adm-stack">
            <section class="adm-card">
                <div class="adm-card__head"><h2>House &amp; project</h2></div>
                <dl class="adm-dl">
                    <div><dt>Package</dt><dd>{{ $inquiry->package_name }} ({{ $inquiry->is_starting_rate ? 'from ' : '' }}LKR {{ number_format($inquiry->rate) }} / sq.ft.)</dd></div>
                    <div><dt>House type</dt><dd>{{ $inquiry->house_type }}</dd></div>
                    <div><dt>District</dt><dd>{{ $inquiry->district }}</dd></div>
                    <div><dt>Town / area</dt><dd>{{ $inquiry->town_area }}</dd></div>
                    <div><dt>Design status</dt><dd>{{ $inquiry->design_status }}</dd></div>
                    <div><dt>Plan approval</dt><dd>{{ $inquiry->approval_status }}</dd></div>
                    <div><dt>Land ownership</dt><dd>{{ $inquiry->land_ownership ?: '—' }}</dd></div>
                    <div><dt>Expected start</dt><dd>{{ $inquiry->start_date ? $inquiry->start_date->format('d M Y') : '—' }}</dd></div>
                </dl>
                @if ($inquiry->comments)
                    <div class="adm-quote"><span>Client comments</span>{{ $inquiry->comments }}</div>
                @endif
            </section>

            <section class="adm-card">
                <div class="adm-card__head">
                    <h2>Room schedule</h2>
                    <span class="adm-muted">Ground {{ number_format($inquiry->ground_area, 2) }}
                        @if ($inquiry->floors >= 2) · First {{ number_format($inquiry->first_area, 2) }} @endif
                        @if ($inquiry->floors >= 3) · Second {{ number_format($inquiry->second_area, 2) }} @endif
                        sq.ft.</span>
                </div>
                @php
                    $labels = ['ground' => 'Ground floor', 'first' => 'First floor', 'second' => 'Second floor'];
                    $grouped = collect($inquiry->rooms ?? [])->groupBy('floor');
                @endphp
                @foreach ($labels as $key => $label)
                    @if ($grouped->has($key))
                        <h3 class="adm-sub">{{ $label }}</h3>
                        <div class="adm-table-wrap">
                            <table class="adm-table adm-table--tight">
                                <thead><tr><th>Room</th><th>Qty</th><th>Length</th><th>Width</th><th>Area</th></tr></thead>
                                <tbody>
                                    @foreach ($grouped[$key] as $r)
                                        <tr>
                                            <td>{{ $r['type'] }}</td>
                                            <td>{{ $r['qty'] }}</td>
                                            <td>{{ $r['length'] }} ft</td>
                                            <td>{{ $r['width'] }} ft</td>
                                            <td><b>{{ number_format($r['area'], 2) }} sq.ft.</b></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endforeach
            </section>
        </div>

        <div class="adm-stack">
            <section class="adm-card">
                <div class="adm-card__head"><h2>Client</h2></div>
                <dl class="adm-dl adm-dl--one">
                    <div><dt>Name</dt><dd>{{ $inquiry->name }}</dd></div>
                    <div><dt>Phone</dt><dd><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></dd></div>
                    <div><dt>Email</dt><dd>@if ($inquiry->email)<a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a>@else — @endif</dd></div>
                </dl>
                <div class="adm-btn-row">
                    @if ($inquiry->client_whatsapp_url)
                        <a class="adm-btn adm-btn--wa" href="{{ $inquiry->client_whatsapp_url }}" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp client</a>
                    @endif
                    <a class="adm-btn adm-btn--ghost" href="tel:{{ $inquiry->phone }}"><i class="fa-solid fa-phone"></i> Call</a>
                </div>
            </section>

            <section class="adm-card">
                <div class="adm-card__head"><h2>Follow-up</h2></div>
                <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}">
                    @csrf
                    @method('PATCH')
                    <label class="adm-field">
                        <span>Status</span>
                        <select name="status">
                            @foreach (config('vega.inquiry_statuses') as $key => $label)
                                <option value="{{ $key }}" @selected($inquiry->status === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="adm-field">
                        <span>Internal notes</span>
                        <textarea name="admin_notes" rows="5" placeholder="Call notes, site visit date, quotation sent…">{{ old('admin_notes', $inquiry->admin_notes) }}</textarea>
                    </label>
                    <button class="adm-btn adm-btn--gold adm-btn--block" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save changes</button>
                    @if ($inquiry->contacted_at)
                        <p class="adm-muted adm-small">First contacted {{ $inquiry->contacted_at->format('d M Y, h:i A') }}</p>
                    @endif
                </form>
            </section>

            <section class="adm-card">
                <div class="adm-card__head"><h2>Attachments</h2><span class="adm-muted">{{ $inquiry->attachments->count() }}</span></div>
                @forelse ($inquiry->attachments as $file)
                    <a class="adm-file" href="{{ route('admin.inquiries.attachment', [$inquiry, $file]) }}">
                        <i class="fa-solid fa-file-arrow-down"></i>
                        <span>{{ $file->original_name }}<small>{{ $file->human_size }}</small></span>
                    </a>
                @empty
                    <p class="adm-muted">The client did not upload any files.</p>
                @endforelse
            </section>

            <section class="adm-card adm-danger">
                <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}"
                      onsubmit="return confirm('Delete this enquiry and its files permanently?');">
                    @csrf
                    @method('DELETE')
                    <button class="adm-btn adm-btn--danger adm-btn--block" type="submit"><i class="fa-solid fa-trash"></i> Delete enquiry</button>
                </form>
            </section>
        </div>
    </div>
@endsection
