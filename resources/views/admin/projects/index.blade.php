@extends('admin.layouts.app')

@section('title', 'Projects')
@section('heading', 'Projects')

@section('content')
    <div class="adm-stats adm-stats--three">
        <a class="adm-stat" href="{{ route('admin.projects.index', ['status' => 'ongoing']) }}">
            <i class="fa-solid fa-helmet-safety"></i><span>Ongoing</span><strong>{{ $counts['ongoing'] ?? 0 }}</strong><small>projects under construction</small>
        </a>
        <a class="adm-stat" href="{{ route('admin.projects.index', ['status' => 'completed']) }}">
            <i class="fa-solid fa-calendar-check"></i><span>Completed</span><strong>{{ $counts['completed'] ?? 0 }}</strong><small>delivered projects</small>
        </a>
        <a class="adm-stat" href="{{ route('admin.projects.index', ['status' => 'design']) }}">
            <i class="fa-solid fa-compass-drafting"></i><span>3D designs</span><strong>{{ $counts['design'] ?? 0 }}</strong><small>design showcases</small>
        </a>
    </div>

    <section class="adm-card">
        <form class="adm-filters" method="GET" action="{{ route('admin.projects.index') }}">
            <div class="adm-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search title or location…">
            </div>
            <select name="status">
                <option value="">All types</option>
                @foreach (\App\Models\Project::STATUSES as $key => $label)
                    <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="adm-btn adm-btn--navy" type="submit"><i class="fa-solid fa-filter"></i> Filter</button>
            @if (array_filter($filters))
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.projects.index') }}">Reset</a>
            @endif
            <a class="adm-btn adm-btn--gold adm-ml-auto" href="{{ route('admin.projects.create') }}"><i class="fa-solid fa-plus"></i> Add project</a>
        </form>

        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead>
                    <tr><th>Project</th><th>Type</th><th>Progress</th><th>Photos</th><th>Website</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse ($projects as $p)
                        <tr>
                            <td>
                                <div class="adm-proj">
                                    @if ($p->cover_url)
                                        <img src="{{ $p->cover_url }}" alt="" loading="lazy">
                                    @else
                                        <span class="adm-proj__ph"><i class="fa-solid fa-image"></i></span>
                                    @endif
                                    <div>
                                        <b>{{ $p->title }}</b>
                                        <small>{{ $p->location ?: 'No location' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="adm-badge {{ ['ongoing' => 'adm-st-quoted', 'completed' => 'adm-st-won', 'design' => 'adm-st-contacted'][$p->status] ?? 'adm-st-new' }}">{{ $p->status_label }}</span>
                            </td>
                            <td style="min-width:140px">
                                @if ($p->status === 'design')
                                    <span class="adm-muted">—</span>
                                @else
                                    <div class="adm-meter"><div><span></span><b>{{ (int) $p->progress }}%</b></div><i><u style="width: {{ (int) $p->progress }}%"></u></i></div>
                                @endif
                            </td>
                            <td>{{ count($p->images ?? []) }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.projects.status', $p) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="toggle" value="publish">
                                    <button type="submit" class="adm-badge {{ $p->is_published ? 'adm-st-won' : 'adm-st-lost' }} adm-badge--btn" title="Click to {{ $p->is_published ? 'hide' : 'publish' }}">
                                        {{ $p->is_published ? 'Visible' : 'Hidden' }}
                                    </button>
                                </form>
                            </td>
                            <td class="adm-actions">
                                @if ($p->status === 'ongoing')
                                    <form method="POST" action="{{ route('admin.projects.status', $p) }}" onsubmit="return confirm('Mark “{{ $p->title }}” as completed?');">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button class="adm-icon adm-icon--ok" type="submit" title="Mark as completed"><i class="fa-solid fa-flag-checkered"></i></button>
                                    </form>
                                @endif
                                <a class="adm-icon" href="{{ route('admin.projects.edit', $p) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $p) }}" onsubmit="return confirm('Delete “{{ $p->title }}” and its uploaded photos permanently?');">
                                    @csrf @method('DELETE')
                                    <button class="adm-icon adm-icon--danger" type="submit" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="adm-empty">No projects yet. Click “Add project” to create the first one.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="adm-card__foot">
            <span class="adm-muted">{{ $projects->total() }} project{{ $projects->total() === 1 ? '' : 's' }}</span>
            {{ $projects->links('vendor.pagination.admin') }}
        </div>
    </section>
@endsection
