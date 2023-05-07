<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        return inertia(
            'Index/Index',
            [
                'message' => 'hello from controller',
            ]
        );
    }
    
    public function show()
    {
        return inertia('Index/Show');
    }
}
