@extends('admin.layouts.app')

@section('title', 'Packages & rates')
@section('heading', 'Packages & rates')

@section('content')
    <section class="adm-card">
        <div class="adm-card__head">
            <div>
                <h2>Construction packages</h2>
                <p class="adm-muted adm-small">These appear under “Our Services” on the website. Rates are indicative selling rates in LKR per sq.ft. – changes go live immediately for new estimates.</p>
            </div>
            <a class="adm-btn adm-btn--gold" href="{{ route('admin.packages.create') }}"><i class="fa-solid fa-plus"></i> New package</a>
        </div>

        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead>
                    <tr><th>#</th><th>Package</th><th>Rate (LKR / sq.ft.)</th><th>Features</th><th>Flags</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse ($packages as $p)
                        <tr>
                            <td>{{ $p->sort_order }}</td>
                            <td><b>{{ $p->name }}</b><small>{{ $p->tagline }}</small></td>
                            <td><b>{{ $p->rate_label }}</b></td>
                            <td>{{ count($p->features ?? []) }} items</td>
                            <td>
                                <span class="adm-badge {{ $p->is_active ? 'adm-st-won' : 'adm-st-lost' }}">{{ $p->is_active ? 'Visible' : 'Hidden' }}</span>
                                @if ($p->is_featured)<span class="adm-badge adm-st-quoted">Featured</span>@endif
                            </td>
                            <td class="adm-actions">
                                <a class="adm-icon" href="{{ route('admin.packages.edit', $p) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                <form method="POST" action="{{ route('admin.packages.destroy', $p) }}" onsubmit="return confirm('Delete the {{ $p->name }} package? Past enquiries keep their data.');">
                                    @csrf @method('DELETE')
                                    <button class="adm-icon adm-icon--danger" type="submit" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="adm-empty">No packages yet. Run <code>php artisan db:seed --class=PackageSeeder</code> or add one.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
