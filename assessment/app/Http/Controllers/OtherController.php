<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\ApiResponser;
use Illuminate\Routing\Controller;

class OtherController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $companies = Company::with('services', 'user')->get();
        return $this->showOne($companies, 200);
    }
}
