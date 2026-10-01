<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// "status" tidak boleh di-mass assign: hanya company pemilik lowongan
// yang boleh mengubahnya, lewat controller (diisi eksplisit).
#[Fillable(['job_id', 'cover_letter'])]
class Application extends Model
{
    public function job(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}