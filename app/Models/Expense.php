<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

protected $table = 'expenses';

protected $fillable = [
    'title',
    'description',
    'category',
    'amount',
    'date',
    'custom_date'
];
}
