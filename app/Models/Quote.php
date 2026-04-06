<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'inquiry_id',
        // Internal (owner-only)
        'supplier_name', 'cost_per_mt', 'est_total_mt',
        'freight_cost', 'other_costs', 'total_cost',
        // Customer-facing
        'selling_price_per_mt', 'total_selling_price',
        'payment_terms', 'lead_time', 'valid_until', 'remarks', 'status',
        'approved_at',
    ];

    protected $casts = [
        'cost_per_mt' => 'decimal:2',
        'est_total_mt' => 'decimal:2',
        'freight_cost' => 'decimal:2',
        'other_costs' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'selling_price_per_mt' => 'decimal:2',
        'total_selling_price' => 'decimal:2',
        'valid_until' => 'date',
        'approved_at' => 'datetime',
    ];

    // Never expose cost fields to serialization (customer API responses)
    protected $hidden = [
        'supplier_name', 'cost_per_mt', 'est_total_mt',
        'freight_cost', 'other_costs', 'total_cost',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}
