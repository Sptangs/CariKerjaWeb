<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobSeekerProfile extends Model
{
    protected $fillable = ['phone', 'address', 'education', 'cv_path'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
