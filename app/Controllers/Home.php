<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'controller'        => 'home',
            'title'             => 'Dashboard',
        ];

        // var_dump($data);die;

        return view('dashboard', $data);
    }
}
