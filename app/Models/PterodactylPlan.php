<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PterodactylPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ram', 'disk', 'cpu', 'price'];
}
