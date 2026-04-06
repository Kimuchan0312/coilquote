<div style="max-width:480px;margin:40px auto;">
    <div style="text-align:center;margin-bottom:24px;">
        <div style="font-size:22px;font-weight:700;color:#1e293b;">CoilQuote</div>
        <div style="color:#64748b;font-size:13px;margin-top:4px;">Create your account</div>
    </div>
    <div class="card">
        <div class="card-title">Register</div>
        <form wire:submit="register">
            <div class="grid-2">
                <div class="form-group">
                    <label>Your Name</label>
                    <input type="text" wire:model="name" placeholder="John Lim">
                    @error('name') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" wire:model="company_name" placeholder="Pelangi Industries Sdn Bhd">
                    @error('company_name') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" wire:model="email" placeholder="john@pelangi.com">
                    @error('email') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Phone <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                    <input type="text" wire:model="phone" placeholder="+60 12 345 6789">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" wire:model="password" placeholder="Min 8 characters">
                    @error('password') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" wire:model="password_confirmation" placeholder="••••••••">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-full" style="margin-top:4px;" wire:loading.attr="disabled">
                <span wire:loading.remove>Create Account</span>
                <span wire:loading>Creating...</span>
            </button>
        </form>
        <div style="text-align:center;margin-top:16px;color:#64748b;font-size:13px;">
            Already have an account? <a href="/portal/login" wire:navigate>Sign in</a>
        </div>
    </div>
</div>
