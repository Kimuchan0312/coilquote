<?php

namespace App\Livewire\Portal;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.portal')]
#[Title('Register — CoilQuote')]
class Register extends Component
{
    public string $name = '';
    public string $company_name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $this->validate([
            'name'         => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'phone'        => 'nullable|string|max:20',
            'password'     => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'         => $this->name,
            'company_name' => $this->company_name,
            'email'        => $this->email,
            'phone'        => $this->phone,
            'password'     => bcrypt($this->password),
        ]);

        auth()->login($user);
        session()->regenerate();
        $this->redirect('/portal/dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.portal.register');
    }
}
