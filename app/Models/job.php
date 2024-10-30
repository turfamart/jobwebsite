<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job extends Model
{
    use HasFactory;

    public function jobType() {
        return $this->belongsTo(Jobtype::class);
    }

    public function Category() {
        return $this->belongsTo(Category::class);
    }
}
