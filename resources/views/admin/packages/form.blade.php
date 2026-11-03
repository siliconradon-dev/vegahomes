@extends('admin.layouts.app')

@php $isEdit = $package->exists; @endphp

@section('title', $isEdit ? 'Edit ' . $package->name : 'New package')
@section('heading', $isEdit ? 'Edit package' : 'New package')

@section('content')
    <div class="adm-crumbs"><a href="{{ route('admin.packages.index') }}">&larr; All packages</a></div>

    <form class="adm-card adm-form" method="POST"
          action="{{ $isEdit ? route('admin.packages.update', $package) : route('admin.packages.store') }}">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        <div class="adm-form__grid">
            <label class="adm-field">
                <span>Package name *</span>
                <input name="name" value="{{ old('name', $package->name) }}" required maxlength="80">
            </label>
            <label class="adm-field">
                <span>Rate (LKR per sq.ft.) *</span>
                <input name="rate" type="number" min="1" step="1" value="{{ old('rate', $package->rate) }}" required>
            </label>
            <label class="adm-field adm-span-2">
                <span>Short description</span>
                <input name="tagline" value="{{ old('tagline', $package->tagline) }}" maxlength="255">
            </label>
            <label class="adm-field adm-span-2">
                <span>Feature bullets <small>(one per line)</small></span>
                <textarea name="features" rows="6">{{ old('features', implode("\n", $package->features ?? [])) }}</textarea>
            </label>
            <label class="adm-field">
                <span>Display order</span>
                <input name="sort_order" type="number" min="0" max="999" value="{{ old('sort_order', $package->sort_order) }}">
            </label>
        </div>

        <div class="adm-toggles">
            <label class="adm-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $package->is_active))> <span>Visible on website</span></label>
            <label class="adm-check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $package->is_featured))> <span>Highlight as “Most popular”</span></label>
            <label class="adm-check"><input type="checkbox" name="is_starting_rate" value="1" @checked(old('is_starting_rate', $package->is_starting_rate))> <span>Rate is a “starting from” price</span></label>
        </div>

        <div class="adm-btn-row">
            <button class="adm-btn adm-btn--gold" type="submit"><i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'Save changes' : 'Create package' }}</button>
            <a class="adm-btn adm-btn--ghost" href="{{ route('admin.packages.index') }}">Cancel</a>
        </div>
    </form>
@endsection
