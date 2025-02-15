<?php

namespace App\Controllers;

use Framework\Database;

class HomeController
{

    protected $db;
    protected $data;
    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);


    }

    public function index()
    {


        loadView('home');

    }

    public function profile()
    {


        loadView('profile');

    }

    public function test()
    {



        loadView('home', ['data' => $this->data]);





    }
}