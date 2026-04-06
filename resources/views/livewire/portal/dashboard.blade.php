<div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <div class="page-title">My Inquiries & Quotes</div>
        <a href="/portal/inquiries/new" wire:navigate class="btn btn-primary">+ New Inquiry</a>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        @if($inquiries->isEmpty())
            <div class="empty">
                <p>No inquiries yet.</p>
                <a href="/portal/inquiries/new" wire:navigate class="btn btn-primary">Submit your first inquiry</a>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Ref</th>
                        <th>Specification</th>
                        <th>Qty</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $inquiry)
                    <tr>
                        <td style="font-weight:600;color:#475569;">INQ-{{ str_pad($inquiry->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div style="font-weight:600;">{{ $inquiry->grade }}</div>
                            <div style="color:#64748b;font-size:12px;">{{ $inquiry->width_mm }}mm · {{ $inquiry->thickness_mm }}mm</div>
                        </td>
                        <td>{{ $inquiry->quantity_coils }} coils</td>
                        <td style="color:#64748b;">{{ $inquiry->created_at->diffForHumans() }}</td>
                        <td>
                            <span class="badge badge-{{ $inquiry->status }}">
                                {{ ucfirst($inquiry->status) }}
                            </span>
                        </td>
                        <td style="font-weight:600;">
                            @if($inquiry->quote && $inquiry->quote->status !== 'draft')
                                RM {{ number_format($inquiry->quote->total_selling_price, 2) }}
                            @else
                                <span style="color:#94a3b8;">—</span>
                            @endif
                        </td>
                        <td>
                            @if($inquiry->quote && $inquiry->quote->status === 'sent')
                                <a href="/portal/inquiries/{{ $inquiry->id }}/quote" wire:navigate class="btn btn-primary" style="padding:5px 12px;font-size:12px;">Review & Approve</a>
                            @else
                                <a href="/portal/inquiries/{{ $inquiry->id }}/quote" wire:navigate class="btn btn-outline" style="padding:5px 12px;font-size:12px;">View</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
