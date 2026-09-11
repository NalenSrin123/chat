<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillCategory extends Model
{
    protected $table = 'skill_categories';
    protected $guarded = [];

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
}
