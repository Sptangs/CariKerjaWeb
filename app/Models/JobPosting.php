<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPosting extends Model
{
    protected $fillable = ['title',
    'location',
    'employment_type',
    'salary_min',
    'salary_max',
    'description',
    'requirements',
    'status'];
    
    protected function casts(): array
    {
        return [
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
        ];
    }

    public function company(): BelongsTo
{
    return $this->belongsTo(Company::class, 'company_id');
}

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_id');
    }
}
