<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    // use HasFactory;

    // Connecting model to table (if table name not a plural of model)
    // protected $table = "patients";

    // Mass assignment with fillable [columns allowed]
    // protected $fillable = ['name', 'phone', 'address', 'status', 'in_date_at', 'out_date_at'];

    // Mass assignment with guarded [columns not allowed]
    protected $guarded = ['id'];
}
