<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'payroll_month', 'year', 'basic_salary', 
        'overtime_hours', 'overtime_pay', 'deductions', 'total_salary'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}