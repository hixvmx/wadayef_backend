<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;

class SalaryController extends Controller
{
    public function get() {
        return Salary::select('id','token','name')->get();
    }
}
