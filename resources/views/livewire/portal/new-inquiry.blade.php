<div style="max-width:640px;">
    <div class="page-header">
        <div class="page-title">New Coil Inquiry</div>
        <a href="/portal/dashboard" wire:navigate class="btn btn-outline">← Back</a>
    </div>
    <div class="card">
        <p style="color:#64748b;margin-bottom:20px;font-size:13px;">Fill in your requirements. We'll review and send you a quote within 1 business day.</p>
        <form wire:submit="submit">
            <div class="form-group">
                <label>Steel Grade / Specification *</label>
                <input type="text" wire:model="grade" placeholder="e.g. SS304, GI AZ150, HR A36, CR DC01">
                @error('grade') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
            </div>

            <div class="grid-3">
                <div class="form-group">
                    <label>Width (mm) *</label>
                    <div class="input-suffix">
                        <input type="number" wire:model="width_mm" placeholder="1219" step="0.1">
                        <span>mm</span>
                    </div>
                    @error('width_mm') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Thickness (mm) *</label>
                    <div class="input-suffix">
                        <input type="number" wire:model="thickness_mm" placeholder="1.5" step="0.001">
                        <span>mm</span>
                    </div>
                    @error('thickness_mm') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Est. Coil Weight (kg)</label>
                    <div class="input-suffix">
                        <input type="number" wire:model="coil_weight_kg" placeholder="3000">
                        <span>kg</span>
                    </div>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Quantity (coils) *</label>
                    <input type="number" wire:model="quantity_coils" placeholder="5" min="1">
                    @error('quantity_coils') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Delivery Terms *</label>
                    <select wire:model="delivery_terms">
                        <option value="">-- Select --</option>
                        <option>CIF Port Klang</option>
                        <option>FOB Origin</option>
                        <option>Ex-Works</option>
                        <option>DAP (your warehouse)</option>
                    </select>
                    @error('delivery_terms') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Preferred Origin <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                <input type="text" wire:model="preferred_origin" placeholder="e.g. Japan, Korea — or leave blank for no preference">
            </div>

            <div class="form-group">
                <label>Required Documents</label>
                <div class="checkbox-list">
                    <label class="checkbox-item">
                        <input type="checkbox" wire:model="required_documents" value="mill_cert"> Mill Certificate (3.1B)
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" wire:model="required_documents" value="packing_list"> Packing List
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" wire:model="required_documents" value="co"> Certificate of Origin (CO)
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" wire:model="required_documents" value="invoice"> Commercial Invoice
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Additional Remarks <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                <textarea wire:model="remarks" rows="3" placeholder="Any specific tolerance, surface finish, or packaging requirements..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-full" style="margin-top:8px;" wire:loading.attr="disabled">
                <span wire:loading.remove>Submit Inquiry</span>
                <span wire:loading>Submitting...</span>
            </button>
        </form>
    </div>
</div>
