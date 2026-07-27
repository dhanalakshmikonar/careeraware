<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['question_text', 'category'])]
class Question extends Model
{
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }
}
