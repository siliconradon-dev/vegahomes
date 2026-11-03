@extends('admin.layouts.app')

@section('title', 'Subscribers')
@section('heading', 'Newsletter subscribers')

@section('content')
    <section class="adm-card">
        <div class="adm-card__head"><h2>{{ $subscribers->total() }} subscriber{{ $subscribers->total() === 1 ? '' : 's' }}</h2></div>
        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead><tr><th>Email</th><th>Subscribed</th><th></th></tr></thead>
                <tbody>
                    @forelse ($subscribers as $s)
                        <tr>
                            <td><a href="mailto:{{ $s->email }}">{{ $s->email }}</a></td>
                            <td>{{ $s->created_at->format('d M Y') }}<small>{{ $s->created_at->diffForHumans() }}</small></td>
                            <td class="adm-actions">
                                <form method="POST" action="{{ route('admin.subscribers.destroy', $s) }}" onsubmit="return confirm('Remove this subscriber?');">
                                    @csrf @method('DELETE')
                                    <button class="adm-icon adm-icon--danger" type="submit" title="Remove"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="adm-empty">No subscribers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="adm-card__foot">{{ $subscribers->links('vendor.pagination.admin') }}</div>
    </section>
@endsection
