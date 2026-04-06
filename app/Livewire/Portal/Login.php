<?php

namespace App\Livewire\Portal;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.portal')]
#[Title('Login — CoilQuote')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public string $error = '';

    public function login(): void
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->error = 'Invalid email or password.';
            return;
        }

        session()->regenerate();
        $this->redirect('/portal/dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.portal.login');
    }
}
