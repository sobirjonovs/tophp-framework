<?php

namespace App\Controllers;

use App\Models\User;
use Exception;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        User::delete(['id' => 1]);
        return view('welcome');
    }
}