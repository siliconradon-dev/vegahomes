@extends('admin.layouts.app')

@php $isEdit = $package->exists; @endphp

@section('title', $isEdit ? 'Edit ' . $package->name : 'New design package')
@section('heading', $isEdit ? 'Edit design package' : 'New design package')

@section('content')
    <div class="adm-crumbs"><a href="{{ route('admin.design-packages.index') }}">&larr; All design packages</a></div>

    <form class="adm-card adm-form" method="POST"
          action="{{ $isEdit ? route('admin.design-packages.update', $package) : route('admin.design-packages.store') }}">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        <div class="adm-form__grid">
            <label class="adm-field">
                <span>Package name *</span>
                <input name="name" value="{{ old('name', $package->name) }}" required maxlength="80">
            </label>
            <label class="adm-field">
                <span>Short heading</span>
                <input name="tagline" value="{{ old('tagline', $package->tagline) }}" maxlength="255" placeholder="e.g. For budget-conscious homeowners">
            </label>
            <label class="adm-field">
                <span>Pricing type *</span>
                <select name="pricing_type">
                    <option value="per_sqft" @selected(old('pricing_type', $package->pricing_type) === 'per_sqft')>LKR per sq.ft. of floor area</option>
                    <option value="percent" @selected(old('pricing_type', $package->pricing_type) === 'percent')>% of construction estimate</option>
                </select>
            </label>
            <label class="adm-field">
                <span>Rate * <small>(LKR per sq.ft., or the percentage e.g. 3)</small></span>
                <input name="rate" type="number" min="0.01" step="0.01" value="{{ old('rate', $package->rate) }}" required>
            </label>
            <label class="adm-field">
                <span>Construction rate (LKR per sq.ft.) *</span>
                <input name="construction_rate" type="number" min="1" step="1" value="{{ old('construction_rate', $package->construction_rate) }}" required>
                <small>Used for the “estimated construction cost” (floor area × this rate). Percentage packages use it to work out the fee.</small>
            </label>
            <label class="adm-field">
                <span>Display order</span>
                <input name="sort_order" type="number" min="0" max="999" value="{{ old('sort_order', $package->sort_order) }}">
            </label>
            <label class="adm-field adm-span-2">
                <span>Description under the price</span>
                <textarea name="note" rows="2" maxlength="255">{{ old('note', $package->note) }}</textarea>
            </label>
            <label class="adm-field adm-span-2">
                <span>Included items <small>(one per line)</small></span>
                <textarea name="features" rows="9">{{ old('features', implode("\n", $package->features ?? [])) }}</textarea>
            </label>
        </div>

        <div class="adm-toggles">
            <label class="adm-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $package->is_active))> <span>Visible on website</span></label>
            <label class="adm-check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $package->is_featured))> <span>Highlight as “Most popular”</span></label>
        </div>

        <div class="adm-btn-row">
            <button class="adm-btn adm-btn--gold" type="submit"><i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'Save changes' : 'Create package' }}</button>
            <a class="adm-btn adm-btn--ghost" href="{{ route('admin.design-packages.index') }}">Cancel</a>
        </div>
    </form>
@endsection
