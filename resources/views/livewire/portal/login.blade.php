<div style="max-width:420px;margin:48px auto;">
    <div style="text-align:center;margin-bottom:24px;">
        <div style="font-size:22px;font-weight:700;color:#1e293b;">CoilQuote</div>
        <div style="color:#64748b;font-size:13px;margin-top:4px;">Customer Portal</div>
    </div>
    <div class="card">
        <div class="card-title">Sign in to your account</div>
        @if($error)
            <div class="alert alert-error">{{ $error }}</div>
        @endif
        <form wire:submit="login">
            <div class="form-group">
                <label>Email</label>
                <input type="email" wire:model="email" placeholder="you@company.com" autofocus>
                @error('email') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" wire:model="password" placeholder="••••••••">
                @error('password') <div style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-full" style="margin-top:6px;" wire:loading.attr="disabled">
                <span wire:loading.remove>Sign In</span>
                <span wire:loading>Signing in...</span>
            </button>
        </form>
        <div style="text-align:center;margin-top:16px;color:#64748b;font-size:13px;">
            Don't have an account? <a href="/portal/register" wire:navigate>Register</a>
        </div>
    </div>
</div>
