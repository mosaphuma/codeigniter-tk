<?php

namespace App\Controllers;

class Userctl extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }
}
