<div class="adm-table-wrap">
    <table class="adm-table">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Client</th>
                <th>Package</th>
                <th>Area</th>
                <th>Estimate</th>
                @unless ($compact ?? false)<th>Location</th>@endunless
                <th>Status</th>
                <th>Received</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($inquiries as $i)
                <tr>
                    <td><a class="adm-ref" href="{{ route('admin.inquiries.show', $i) }}">{{ $i->reference }}</a>
                        @if (($i->attachments_count ?? 0) > 0)<i class="fa-solid fa-paperclip adm-muted" title="{{ $i->attachments_count }} attachment(s)"></i>@endif
                    </td>
                    <td><b>{{ $i->name }}</b><small>{{ $i->phone }}</small></td>
                    <td><span class="adm-pill">{{ $i->package_name }}</span><small>{{ $i->house_type }}</small></td>
                    <td>{{ rtrim(rtrim(number_format($i->total_area, 2), '0'), '.') }} sq.ft.</td>
                    <td><b>{{ $i->cost_label }}</b></td>
                    @unless ($compact ?? false)<td>{{ $i->town_area }}<small>{{ $i->district }}</small></td>@endunless
                    <td><span class="adm-badge adm-st-{{ $i->status }}">{{ $i->status_label }}</span></td>
                    <td>{{ $i->created_at->format('d M Y') }}<small>{{ $i->created_at->diffForHumans() }}</small></td>
                    <td class="adm-actions">
                        <a class="adm-icon" href="{{ route('admin.inquiries.show', $i) }}" title="Open"><i class="fa-solid fa-eye"></i></a>
                        @if ($i->client_whatsapp_url)
                            <a class="adm-icon adm-icon--wa" href="{{ $i->client_whatsapp_url }}" target="_blank" rel="noopener" title="WhatsApp client"><i class="fa-brands fa-whatsapp"></i></a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="adm-empty">No enquiries found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
