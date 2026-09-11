<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonials';
    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_approved' => 'boolean'];
    }
}
