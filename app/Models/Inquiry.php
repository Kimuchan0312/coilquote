<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'user_id', 'grade', 'width_mm', 'thickness_mm', 'coil_weight_kg',
        'quantity_coils', 'delivery_terms', 'preferred_origin',
        'required_documents', 'remarks', 'status',
    ];

    protected $casts = [
        'required_documents' => 'array',
        'width_mm' => 'decimal:2',
        'thickness_mm' => 'decimal:3',
        'coil_weight_kg' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quote()
    {
        return $this->hasOne(Quote::class);
    }
}
