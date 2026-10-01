<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title',
    'location',
    'employment_type',
    'salary_min',
    'salary_max',
    'description',
    'requirements',
    'status',
])]
class Job extends Model
{
    // Nama "jobs" sudah dipakai tabel queue bawaan Laravel,
    // jadi lowongan kerja disimpan di tabel job_postings.
    protected $table = 'job_postings';

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
