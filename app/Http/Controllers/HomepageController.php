<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @class HomepageController
 */
class HomepageController extends Controller
{

    public function index()
    {
        return view('homepage.index');
    }


    public function store()
    {

    }

}
