@extends('admin.layouts.app')

@php
    $isEdit = $project->exists;
    $existing = $project->images ?? [];
@endphp

@section('title', $isEdit ? 'Edit ' . $project->title : 'Add project')
@section('heading', $isEdit ? 'Edit project' : 'Add project')

@section('content')
    <div class="adm-crumbs"><a href="{{ route('admin.projects.index') }}">&larr; All projects</a></div>

    <form class="adm-card adm-form adm-form--wide" method="POST" enctype="multipart/form-data"
          action="{{ $isEdit ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        <div class="adm-form__grid">
            <label class="adm-field adm-span-2">
                <span>Project title *</span>
                <input name="title" value="{{ old('title', $project->title) }}" required maxlength="160" placeholder="e.g. Two-storey house, Kurunegala">
            </label>

            <label class="adm-field">
                <span>Type *</span>
                <select name="status" id="projStatus">
                    @foreach (\App\Models\Project::STATUSES as $key => $label)
                        <option value="{{ $key }}" @selected(old('status', $project->status) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label class="adm-field">
                <span>Location</span>
                <input name="location" value="{{ old('location', $project->location) }}" maxlength="160" placeholder="e.g. Kurunegala">
            </label>

            <label class="adm-field" id="progressField">
                <span>Progress (%) <small>– ongoing projects</small></span>
                <input name="progress" type="number" min="0" max="100" step="1" value="{{ old('progress', $project->progress) }}">
            </label>
            <label class="adm-field">
                <span>Display order <small>– smaller number shows first</small></span>
                <input name="sort_order" type="number" min="0" max="9999" value="{{ old('sort_order', $project->sort_order) }}">
            </label>

            <label class="adm-field">
                <span>Started on</span>
                <input name="started_on" type="date" value="{{ old('started_on', optional($project->started_on)->format('Y-m-d')) }}">
            </label>
            <label class="adm-field">
                <span>Completed on</span>
                <input name="completed_on" type="date" value="{{ old('completed_on', optional($project->completed_on)->format('Y-m-d')) }}">
            </label>

            <label class="adm-field adm-span-2">
                <span>Description</span>
                <textarea name="description" rows="4" maxlength="5000" placeholder="A short description shown with the project photos.">{{ old('description', $project->description) }}</textarea>
            </label>
        </div>

        {{-- Existing photos --}}
        @if ($isEdit && count($existing))
            <h3 class="adm-sub">Current photos <span class="adm-muted" style="text-transform:none;letter-spacing:0;font-weight:600">({{ count($existing) }}) – the cover photo is shown on the project card</span></h3>
            <div class="adm-gallery">
                @foreach ($existing as $i => $path)
                    <div class="adm-gallery__item">
                        <img src="{{ asset($path) }}" alt="" loading="lazy">
                        <label class="adm-gallery__cover"><input type="radio" name="cover" value="{{ $path }}" @checked($i === 0)> Cover</label>
                        <label class="adm-gallery__rm"><input type="checkbox" name="remove_images[]" value="{{ $path }}"> Remove</label>
                    </div>
                @endforeach
            </div>
        @endif

        <h3 class="adm-sub">{{ $isEdit ? 'Add more photos' : 'Photos' }}</h3>
        <label class="adm-drop">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <b>Choose photos</b>
            <small>JPG, PNG or WEBP · up to 6 MB each · you can select many at once{{ $isEdit ? '' : ' · the first photo becomes the cover' }}</small>
            <input type="file" name="images[]" id="projFiles" accept="image/jpeg,image/png,image/webp" multiple>
        </label>
        <div class="adm-previews" id="projPreviews"></div>

        <div class="adm-toggles">
            <label class="adm-check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $project->is_published))> <span>Show on the website</span></label>
        </div>

        <div class="adm-btn-row">
            <button class="adm-btn adm-btn--gold" type="submit"><i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'Save changes' : 'Add project' }}</button>
            <a class="adm-btn adm-btn--ghost" href="{{ route('admin.projects.index') }}">Cancel</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    (function () {
        var status = document.getElementById('projStatus');
        var prog = document.getElementById('progressField');
        function sync() { prog.style.display = status.value === 'ongoing' ? '' : 'none'; }
        status.addEventListener('change', sync); sync();

        var input = document.getElementById('projFiles');
        var box = document.getElementById('projPreviews');
        input.addEventListener('change', function () {
            box.innerHTML = '';
            Array.prototype.forEach.call(input.files, function (f) {
                if (!/^image\//.test(f.type)) { return; }
                var img = document.createElement('img');
                img.src = URL.createObjectURL(f);
                img.alt = f.name;
                box.appendChild(img);
            });
        });
    })();
</script>
@endpush
