<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Company extends Model
{
    protected $fillable = ['company_name', 'description', 'address'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(JobPosting::class, 'company_id');
    }

    public function applications(): HasManyThrough
    {
        return $this->hasManyThrough(
            Application::class,
            JobPosting::class,
            'company_id',
            'job_id',
        );
    }
}
