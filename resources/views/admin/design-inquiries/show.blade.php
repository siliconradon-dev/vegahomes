@extends('admin.layouts.app')

@section('title', $inquiry->reference)
@section('heading', 'Design enquiry ' . $inquiry->reference)

@section('content')
    <div class="adm-crumbs"><a href="{{ route('admin.design-inquiries.index') }}">&larr; All design enquiries</a></div>

    <div class="adm-hero-card">
        <div>
            <span class="adm-badge adm-st-{{ $inquiry->status }}">{{ $inquiry->status_label }}</span>
            <h2>{{ $inquiry->name }}</h2>
            <p>{{ $inquiry->district ?: 'District not given' }} · received {{ $inquiry->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <div class="adm-hero-card__est">
            <span>{{ $inquiry->package_name }} design package</span>
            <strong>{{ $inquiry->fee_label }}</strong>
            <small>{{ $inquiry->calculation_basis }}</small>
        </div>
    </div>

    <div class="adm-grid-2">
        <div class="adm-stack">
            <section class="adm-card">
                <div class="adm-card__head"><h2>Project &amp; fee</h2></div>
                <dl class="adm-dl">
                    <div><dt>Package</dt><dd>{{ $inquiry->package_name }}</dd></div>
                    <div><dt>Pricing rule</dt><dd>{{ $inquiry->pricing_type === 'percent' ? rtrim(rtrim(number_format($inquiry->rate, 2), '0'), '.') . '% of construction estimate' : 'LKR ' . rtrim(rtrim(number_format($inquiry->rate, 2), '0'), '.') . ' / sq.ft.' }}</dd></div>
                    <div><dt>Proposed floor area</dt><dd>{{ $inquiry->area_label }}</dd></div>
                    <div><dt>House type</dt><dd>{{ $inquiry->house_type }}</dd></div>
                    <div><dt>District</dt><dd>{{ $inquiry->district ?: '—' }}</dd></div>
                    <div><dt>Expected design start</dt><dd>{{ $inquiry->start_date ? $inquiry->start_date->format('d M Y') : '—' }}</dd></div>
                    <div><dt>Construction estimate</dt><dd>LKR {{ number_format($inquiry->construction_estimate) }} <small class="adm-muted">(at LKR {{ number_format($inquiry->construction_rate) }}/sq.ft.)</small></dd></div>
                    <div><dt>Indicative design fee</dt><dd>{{ $inquiry->fee_label }}</dd></div>
                </dl>

                <h3 class="adm-sub">Add-on services of interest</h3>
                @if (count($inquiry->addon_titles))
                    <div class="adm-chips">
                        @foreach ($inquiry->addon_titles as $t)<span class="adm-pill">{{ $t }}</span>@endforeach
                    </div>
                @else
                    <p class="adm-muted">None selected.</p>
                @endif

                @if ($inquiry->comments)
                    <div class="adm-quote"><span>Client comments</span>{{ $inquiry->comments }}</div>
                @endif
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
                <form method="POST" action="{{ route('admin.design-inquiries.update', $inquiry) }}">
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
                        <textarea name="admin_notes" rows="5" placeholder="Call notes, proposal sent, meeting date…">{{ old('admin_notes', $inquiry->admin_notes) }}</textarea>
                    </label>
                    <button class="adm-btn adm-btn--gold adm-btn--block" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save changes</button>
                    @if ($inquiry->contacted_at)
                        <p class="adm-muted adm-small">First contacted {{ $inquiry->contacted_at->format('d M Y, h:i A') }}</p>
                    @endif
                </form>
            </section>

            <section class="adm-card adm-danger">
                <form method="POST" action="{{ route('admin.design-inquiries.destroy', $inquiry) }}"
                      onsubmit="return confirm('Delete this design enquiry permanently?');">
                    @csrf
                    @method('DELETE')
                    <button class="adm-btn adm-btn--danger adm-btn--block" type="submit"><i class="fa-solid fa-trash"></i> Delete enquiry</button>
                </form>
            </section>
        </div>
    </div>
@endsection
