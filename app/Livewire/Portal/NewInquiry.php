<?php

namespace App\Livewire\Portal;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.portal')]
#[Title('New Inquiry — CoilQuote')]
class NewInquiry extends Component
{
    public string $grade = '';
    public string $width_mm = '';
    public string $thickness_mm = '';
    public string $coil_weight_kg = '';
    public string $quantity_coils = '';
    public string $delivery_terms = '';
    public string $preferred_origin = '';
    public array  $required_documents = [];
    public string $remarks = '';

    public function submit(): void
    {
        $this->validate([
            'grade'            => 'required|string|max:100',
            'width_mm'         => 'required|numeric|min:1',
            'thickness_mm'     => 'required|numeric|min:0.01',
            'coil_weight_kg'   => 'nullable|numeric|min:1',
            'quantity_coils'   => 'required|integer|min:1',
            'delivery_terms'   => 'required|string|max:100',
            'preferred_origin' => 'nullable|string|max:100',
            'remarks'          => 'nullable|string|max:1000',
        ]);

        auth()->user()->inquiries()->create([
            'grade'              => $this->grade,
            'width_mm'           => $this->width_mm,
            'thickness_mm'       => $this->thickness_mm,
            'coil_weight_kg'     => $this->coil_weight_kg ?: null,
            'quantity_coils'     => $this->quantity_coils,
            'delivery_terms'     => $this->delivery_terms,
            'preferred_origin'   => $this->preferred_origin ?: null,
            'required_documents' => $this->required_documents ?: null,
            'remarks'            => $this->remarks ?: null,
            'status'             => 'new',
        ]);

        session()->flash('success', 'Inquiry submitted. We\'ll review and send you a quote within 1 business day.');
        $this->redirect('/portal/dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.portal.new-inquiry');
    }
}
