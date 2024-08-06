<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

class UserController
{

    protected $db;


    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Show the login page
     * @return void
     */

    public function login()
    {
        loadView('users/login');
    }


    /**
     * Show the register page
     * @return void
     */

    public function create()
    {
        loadView('users/create');
    }


    /**
     * Store user in database
     * 
     * @return void
     */

    public function store()
    {

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];


        $errors = [];
        //Validation
        if (!Validation::email($email)) {
            $errors['email'] = 'Please eneter a valid email address!';
        }

        if (!Validation::string($username, 3, 50)) {
            $errors['username'] = 'Username must be between 3 and 50 characters!';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be between 6 and 50 characters!';
        }

        if (!Validation::match($password, $password_confirmation)) {
            $errors['password_confirmation'] = 'Passwords do not match!';
        }



        if (!empty($errors)) {
            loadView('users/create', [
                'errors' => $errors,
                'user' => [
                    'username' => $username,
                    'email' => $email,
                ]
            ]);
            exit;
        } else {

            //Check if email exists
            $params = ['email' => $email];
            $user = $this->db->query("SELECT * from users WHERE email = :email", $params)->fetch();

            if ($user) {
                $errors['email'] = 'That email is already registered!';
                loadView('users/create', [
                    'errors' => $errors,
                    'user' => [
                        'username' => $username,
                        'email' => $email,
                    ]
                ]);
                exit;
            }

            $params = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];

            $this->db->query('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)', $params);

            //Get user ID
            $userId = $this->db->conn->lastInsertId();
            Session::set('user', [
                'id' => $userId,
                'username' => $username,
                'email' => $email,
            ]);
            //inspectAndDie(Session::get('user'));

            redirect('/');




        }



    }

    /**
     * Logout a user nad kill session
     * @return void
     */

    public function logout()
    {
        Session::clearAll();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);
        redirect('/');

    }

    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];


        $errors = [];

        //Validation
        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email!';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be between 6 and 60 characters!';
        }


        //Check for errors
        if (!empty($errors)) {
            loadView('users/login', [
                'errors' => $errors
            ]);
            exit();
        }


        //Check if email is correct
        $params = ['email' => $email];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if (!$user) {
            $errors['email'] = 'Incorrect Credentials';
            loadView('users/login', [
                'errors' => $errors
            ]);
            exit();
        }

        //Check if password is correct
        if (!password_verify($password, $user->password)) {
            $errors['email'] = 'Incorrect Credentials';
            loadView('users/login', [
                'errors' => $errors
            ]);
            exit();
        }


        //Set user session
        Session::set('user', [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
        ]);

        redirect('/');


    }

}