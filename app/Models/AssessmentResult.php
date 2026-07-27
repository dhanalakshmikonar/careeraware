<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'awareness_session_id', 'top_careers', 'career_scores'])]
class AssessmentResult extends Model
{
    protected function casts(): array
    {
        return [
            'top_careers' => 'array',
            'career_scores' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function awarenessSession(): BelongsTo
    {
        return $this->belongsTo(AwarenessSession::class);
    }
}
