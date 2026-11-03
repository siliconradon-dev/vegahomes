@extends('admin.layouts.app')

@section('title', 'Estimate enquiries')
@section('heading', 'Estimate enquiries')

@section('content')
    <section class="adm-card">
        <form class="adm-filters" method="GET" action="{{ route('admin.inquiries.index') }}">
            <div class="adm-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search name, phone, reference, town…">
            </div>
            <select name="status">
                <option value="">All statuses</option>
                @foreach (config('vega.inquiry_statuses') as $key => $label)
                    <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="package">
                <option value="">All packages</option>
                @foreach ($packages as $slug => $name)
                    <option value="{{ $slug }}" @selected(($filters['package'] ?? '') === $slug)>{{ $name }}</option>
                @endforeach
            </select>
            <select name="district">
                <option value="">All districts</option>
                @foreach (config('vega.districts') as $d)
                    <option @selected(($filters['district'] ?? '') === $d)>{{ $d }}</option>
                @endforeach
            </select>
            <button class="adm-btn adm-btn--navy" type="submit"><i class="fa-solid fa-filter"></i> Filter</button>
            @if (array_filter($filters))
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.inquiries.index') }}">Reset</a>
            @endif
            <a class="adm-btn adm-btn--ghost adm-ml-auto" href="{{ route('admin.inquiries.export', array_filter($filters)) }}">
                <i class="fa-solid fa-file-csv"></i> Export CSV
            </a>
        </form>

        @include('admin.inquiries._table', ['inquiries' => $inquiries])

        <div class="adm-card__foot">
            <span class="adm-muted">{{ $inquiries->total() }} enquir{{ $inquiries->total() === 1 ? 'y' : 'ies' }}</span>
            {{ $inquiries->links('vendor.pagination.admin') }}
        </div>
    </section>
@endsection
