<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'company_id'];

    public function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
