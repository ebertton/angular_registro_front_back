<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;

    /**
     * @return BelongsToMany
     */
    public function knowledges(): BelongsToMany
    {
        return $this->belongsToMany(Knowledge::class, 'employees_knowledges', 'employees_id', 'knowledges_id');
    }
}
