<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'code',
    'name',
    'description',
    'skills',
    'certifications',
    'projects',
    'salary_range',
    'demand_status',
    'roadmap',
    'swot',
])]
class CareerPath extends Model
{
    protected function casts(): array
    {
        return [
            'skills' => 'array',
            'certifications' => 'array',
            'projects' => 'array',
            'roadmap' => 'array',
            'swot' => 'array',
        ];
    }
}
