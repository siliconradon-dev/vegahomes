@extends('admin.layouts.app')

@section('title', 'Design packages')
@section('heading', 'Design packages & fees')

@section('content')
    <section class="adm-card">
        <div class="adm-card__head">
            <div>
                <h2>Architectural design packages</h2>
                <p class="adm-muted adm-small">Shown on the website in the “Architectural Design Packages” section. Fees are either LKR per sq.ft. or a percentage of the construction estimate (floor area × construction rate).</p>
            </div>
            <a class="adm-btn adm-btn--gold" href="{{ route('admin.design-packages.create') }}"><i class="fa-solid fa-plus"></i> New design package</a>
        </div>

        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead><tr><th>#</th><th>Package</th><th>Fee</th><th>Construction rate</th><th>Features</th><th>Flags</th><th></th></tr></thead>
                <tbody>
                    @forelse ($packages as $p)
                        <tr>
                            <td>{{ $p->sort_order }}</td>
                            <td><b>{{ $p->name }}</b><small>{{ $p->tagline }}</small></td>
                            <td><b>{{ $p->rate_label }}</b></td>
                            <td>LKR {{ number_format($p->construction_rate) }} / sq.ft.</td>
                            <td>{{ count($p->features ?? []) }} items</td>
                            <td>
                                <span class="adm-badge {{ $p->is_active ? 'adm-st-won' : 'adm-st-lost' }}">{{ $p->is_active ? 'Visible' : 'Hidden' }}</span>
                                @if ($p->is_featured)<span class="adm-badge adm-st-quoted">Featured</span>@endif
                            </td>
                            <td class="adm-actions">
                                <a class="adm-icon" href="{{ route('admin.design-packages.edit', $p) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                <form method="POST" action="{{ route('admin.design-packages.destroy', $p) }}" onsubmit="return confirm('Delete the {{ $p->name }} design package? Past enquiries keep their data.');">
                                    @csrf @method('DELETE')
                                    <button class="adm-icon adm-icon--danger" type="submit" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="adm-empty">No design packages yet. Run <code>php artisan db:seed --class=DesignPackageSeeder</code> or add one.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
