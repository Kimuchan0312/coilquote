<?php

namespace App\Livewire\Portal;

use App\Models\Inquiry;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.portal')]
#[Title('Quote — CoilQuote')]
class QuoteDetail extends Component
{
    public Inquiry $inquiry;

    public function mount(Inquiry $inquiry): void
    {
        // Ensure the inquiry belongs to the logged-in user
        abort_unless($inquiry->user_id === auth()->id(), 403);
        $this->inquiry = $inquiry->load('quote');
    }

    public function approve(): void
    {
        $quote = $this->inquiry->quote;
        abort_unless($quote && $quote->status === 'sent', 403);

        $quote->update([
            'status'      => 'approved',
            'approved_at' => now(),
        ]);

        $this->inquiry->update(['status' => 'approved']);

        session()->flash('success', 'Quote approved. We will contact you with a proforma invoice shortly.');
        $this->redirect('/portal/dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.portal.quote-detail', ['inquiry' => $this->inquiry]);
    }
}
