@extends('admin.layouts.app')

@section('title', 'Contact messages')
@section('heading', 'Contact messages')

@section('content')
    <section class="adm-card">
        <div class="adm-card__head"><h2>Messages from the contact form</h2></div>

        @forelse ($messages as $m)
            @php $wa = preg_replace('/\D+/', '', (string) $m->phone); if (str_starts_with($wa, '0')) { $wa = '94' . substr($wa, 1); } @endphp
            <article class="adm-msg {{ $m->is_read ? '' : 'is-unread' }}">
                <div class="adm-msg__head">
                    <div>
                        <b>{{ $m->name }}</b>
                        @unless ($m->is_read)<span class="adm-badge adm-st-new">New</span>@endunless
                        <small>{{ $m->created_at->format('d M Y, h:i A') }} · {{ $m->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="adm-actions">
                        @if ($wa)
                            <a class="adm-icon adm-icon--wa" href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        @endif
                        <form method="POST" action="{{ route('admin.messages.toggle', $m) }}">@csrf @method('PATCH')
                            <button class="adm-icon" type="submit" title="{{ $m->is_read ? 'Mark unread' : 'Mark read' }}"><i class="fa-solid {{ $m->is_read ? 'fa-envelope' : 'fa-envelope-open' }}"></i></button>
                        </form>
                        <form method="POST" action="{{ route('admin.messages.destroy', $m) }}" onsubmit="return confirm('Delete this message?');">@csrf @method('DELETE')
                            <button class="adm-icon adm-icon--danger" type="submit" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                <p class="adm-msg__meta">
                    <a href="mailto:{{ $m->email }}"><i class="fa-solid fa-envelope"></i> {{ $m->email }}</a>
                    <a href="tel:{{ $m->phone }}"><i class="fa-solid fa-phone"></i> {{ $m->phone }}</a>
                </p>
                @if ($m->message)<div class="adm-quote">{{ $m->message }}</div>@endif
            </article>
        @empty
            <p class="adm-empty">No messages yet.</p>
        @endforelse

        <div class="adm-card__foot">{{ $messages->links('vendor.pagination.admin') }}</div>
    </section>
@endsection
