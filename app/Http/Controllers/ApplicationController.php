<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;


class ApplicationController extends Controller
{
    public function index()
    {
        return view('application');
    }
}
