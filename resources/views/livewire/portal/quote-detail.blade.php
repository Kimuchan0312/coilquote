<div style="max-width:640px;">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <div>
            <div class="page-title">INQ-{{ str_pad($inquiry->id, 3, '0', STR_PAD_LEFT) }}</div>
            <div style="color:#64748b;font-size:13px;margin-top:2px;">Submitted {{ $inquiry->created_at->format('d M Y') }}</div>
        </div>
        <a href="/portal/dashboard" wire:navigate class="btn btn-outline">← Back</a>
    </div>

    {{-- Coil Specs --}}
    <div class="card">
        <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px;">Coil Specification</div>
        <div class="spec-grid">
            <div class="spec-item"><div class="spec-key">Grade</div><div class="spec-val">{{ $inquiry->grade }}</div></div>
            <div class="spec-item"><div class="spec-key">Width</div><div class="spec-val">{{ $inquiry->width_mm }} mm</div></div>
            <div class="spec-item"><div class="spec-key">Thickness</div><div class="spec-val">{{ $inquiry->thickness_mm }} mm</div></div>
            <div class="spec-item"><div class="spec-key">Coil Weight</div><div class="spec-val">{{ $inquiry->coil_weight_kg ? number_format($inquiry->coil_weight_kg) . ' kg' : '—' }}</div></div>
            <div class="spec-item"><div class="spec-key">Quantity</div><div class="spec-val">{{ $inquiry->quantity_coils }} coils</div></div>
            <div class="spec-item"><div class="spec-key">Delivery</div><div class="spec-val">{{ $inquiry->delivery_terms }}</div></div>
        </div>
        @if($inquiry->remarks)
            <div style="font-size:12px;color:#64748b;background:#f8fafc;border:1px solid #e2e8f0;border-radius:5px;padding:10px 12px;margin-top:4px;">
                <strong>Your remarks:</strong> {{ $inquiry->remarks }}
            </div>
        @endif
    </div>

    {{-- Quote --}}
    @if(!$inquiry->quote || $inquiry->quote->status === 'draft')
        <div class="card" style="text-align:center;padding:40px;">
            <div style="font-size:32px;margin-bottom:12px;">⏳</div>
            <div style="font-weight:600;margin-bottom:6px;">Quote in preparation</div>
            <div style="color:#64748b;font-size:13px;">We're reviewing your inquiry and sourcing the best pricing. You'll be notified when your quote is ready.</div>
        </div>
    @else
        @php $quote = $inquiry->quote; @endphp
        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;">Your Quote</div>
                <span class="badge badge-{{ $quote->status }}">{{ ucfirst($quote->status) }}</span>
            </div>

            <div class="price-row"><span style="color:#64748b;">Unit Price</span><span style="font-weight:600;">RM {{ number_format($quote->selling_price_per_mt, 2) }} / MT</span></div>
            <div class="price-row"><span style="color:#64748b;">Freight & Delivery</span><span>Included</span></div>
            <div class="price-total"><span>Total</span><span>RM {{ number_format($quote->total_selling_price, 2) }}</span></div>

            <div style="margin-top:20px;margin-bottom:4px;">
                <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">Terms</div>
                <div class="price-row"><span style="color:#64748b;">Payment</span><span>{{ $quote->payment_terms }}</span></div>
                <div class="price-row"><span style="color:#64748b;">Lead Time</span><span>{{ $quote->lead_time }}</span></div>
                <div class="price-row"><span style="color:#64748b;">Valid Until</span><span>{{ $quote->valid_until->format('d M Y') }}</span></div>
            </div>

            @if($quote->remarks)
                <div style="font-size:13px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:5px;padding:12px;margin-top:12px;">
                    <strong>Remarks:</strong> {{ $quote->remarks }}
                </div>
            @endif

            @if($quote->status === 'sent')
                <div style="margin-top:20px;">
                    <button wire:click="approve" class="btn btn-success btn-full" style="padding:12px;font-size:15px;" wire:loading.attr="disabled"
                        wire:confirm="Approve this quote and proceed with the order?">
                        <span wire:loading.remove>Approve Quote</span>
                        <span wire:loading>Approving...</span>
                    </button>
                    <div style="text-align:center;font-size:12px;color:#94a3b8;margin-top:8px;">
                        Approving confirms your intent to proceed. We'll contact you with a proforma invoice.
                    </div>
                </div>
            @elseif($quote->status === 'approved')
                <div style="margin-top:16px;background:#dcfce7;border:1px solid #86efac;border-radius:6px;padding:12px;text-align:center;color:#166534;font-weight:600;">
                    ✓ Approved on {{ $quote->approved_at->format('d M Y, H:i') }}
                </div>
            @endif
        </div>
    @endif
</div>
