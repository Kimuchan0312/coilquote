<?php

namespace App\Livewire\Portal;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.portal')]
#[Title('My Inquiries — CoilQuote')]
class Dashboard extends Component
{
    public function render()
    {
        $inquiries = auth()->user()
            ->inquiries()
            ->with('quote')
            ->latest()
            ->get();

        return view('livewire.portal.dashboard', compact('inquiries'));
    }
}
