@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    @php
        $maxMonth = max(1, collect($months)->max('value'));
        $maxPackage = max(1, (int) $byPackage->max());
        $statusLabels = config('vega.inquiry_statuses');
    @endphp

    <div class="adm-stats">
        <a class="adm-stat" href="{{ route('admin.inquiries.index', ['status' => 'new']) }}">
            <i class="fa-solid fa-bell"></i>
            <span>New enquiries</span>
            <strong>{{ $stats['new'] }}</strong>
            <small>waiting for a response</small>
        </a>
        <div class="adm-stat">
            <i class="fa-solid fa-calculator"></i>
            <span>Total enquiries</span>
            <strong>{{ $stats['total'] }}</strong>
            <small>{{ $stats['this_month'] }} this month</small>
        </div>
        <div class="adm-stat adm-stat--gold">
            <i class="fa-solid fa-sack-dollar"></i>
            <span>Open pipeline</span>
            <strong class="is-money">LKR {{ number_format($stats['pipeline']) }}</strong>
            <small>estimated value, not yet won/lost</small>
        </div>
        <div class="adm-stat">
            <i class="fa-solid fa-trophy"></i>
            <span>Won projects</span>
            <strong>{{ $stats['won'] }}</strong>
            <small>{{ $stats['messages'] }} unread messages · {{ $stats['subscribers'] }} subscribers</small>
        </div>
    </div>

    <div class="adm-stats adm-stats--design">
        <a class="adm-stat" href="{{ route('admin.design-inquiries.index', ['status' => 'new']) }}">
            <i class="fa-solid fa-compass-drafting"></i>
            <span>New design enquiries</span>
            <strong>{{ $stats['design_new'] }}</strong>
            <small>{{ $stats['design_total'] }} design enquiries in total</small>
        </a>
        <div class="adm-stat">
            <i class="fa-solid fa-pen-ruler"></i>
            <span>Open design-fee pipeline</span>
            <strong class="is-money">LKR {{ number_format($stats['design_fees']) }}</strong>
            <small>indicative design fees, not yet won/lost</small>
        </div>
    </div>

    <div class="adm-grid-3">
        <section class="adm-card">
            <div class="adm-card__head"><h2>Enquiries – last 6 months</h2></div>
            <div class="adm-bars">
                @foreach ($months as $m)
                    <div class="adm-bars__col">
                        <b>{{ $m['value'] }}</b>
                        <span style="height: {{ max(4, round($m['value'] / $maxMonth * 100)) }}%"></span>
                        <em>{{ $m['label'] }}</em>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="adm-card">
            <div class="adm-card__head"><h2>By package</h2></div>
            @forelse ($byPackage as $name => $count)
                <div class="adm-meter">
                    <div><span>{{ $name }}</span><b>{{ $count }}</b></div>
                    <i><u style="width: {{ round($count / $maxPackage * 100) }}%"></u></i>
                </div>
            @empty
                <p class="adm-muted">No enquiries yet.</p>
            @endforelse
        </section>
    </div>

    <section class="adm-card">
        <div class="adm-card__head">
            <h2>Pipeline</h2>
        </div>
        <div class="adm-pipeline">
            @foreach ($statusLabels as $key => $label)
                <a href="{{ route('admin.inquiries.index', ['status' => $key]) }}" class="adm-pipeline__item adm-st-{{ $key }}">
                    <strong>{{ $byStatus[$key] ?? 0 }}</strong>
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="adm-card">
        <div class="adm-card__head">
            <h2>Latest enquiries</h2>
            <a class="adm-link" href="{{ route('admin.inquiries.index') }}">View all →</a>
        </div>
        @include('admin.inquiries._table', ['inquiries' => $recent, 'compact' => true])
    </section>
    <section class="adm-card">
        <div class="adm-card__head">
            <h2>Latest design enquiries</h2>
            <a class="adm-link" href="{{ route('admin.design-inquiries.index') }}">View all →</a>
        </div>
        @include('admin.design-inquiries._table', ['inquiries' => $recentDesign])
    </section>
@endsection
