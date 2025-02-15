<?php


namespace App\Controllers;

use Framework\Database;
use Framework\Session;


class GameController
{
    protected $data;
    protected $token;
    protected $errors;





    public function getApiData($category, $difficulty, $token)
    {

        $ch = curl_init();
        $url = "https://opentdb.com/api.php?amount=1&category={$category}&difficulty={$difficulty}&type=multiple&token={$token}";


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);

        if ($e = curl_error($ch)) {
            $errors = $e;
            return $errors;
        } else {

            $data = json_decode($resp);
            curl_close($ch);

            return $data;

        }



    }



    public function create()
    {

        Session::clear('game');
        loadView('options');
    }

    public function start($params)
    {

        if (isset($_POST['category']) && isset($_POST['difficulty'])) {
            Session::set('game', [
                'category' => $_POST['category'],
                'difficulty' => $_POST['difficulty']
            ]);

            $difficulty = Session::get('game')['difficulty'];
            $category = Session::get('game')['category'];

            $this->data = $this->getApiData($category, $difficulty, $params['token']);

            loadView('game/index', [
                'data' => $this->data,
                'mistakes' => 0,
                'correctly_answered' => 0,
                'token' => $params['token']
            ]);

        } else {
            $answer = $_POST['answer'];
            $correct_answer = $_POST['correct_answer'];
            $isCorrect = $answer === $correct_answer;
            $mistakes = (int) $_POST['mistakes'];
            $correctly_answered = (int) $_POST['correctly_answered'];
            if (!$isCorrect) {
                $mistakes += 1;
            } else {
                $correctly_answered += 1;
            }
            inspect($mistakes);

            if ($mistakes <= 2) {
                $difficulty = Session::get('game')['difficulty'];
                $category = Session::get('game')['category'];
                $this->data = $this->getApiData($category, $difficulty, $params['token']);

                if ($isCorrect) {
                    loadView('game/index', [
                        'data' => $this->data,
                        'mistakes' => $mistakes,
                        'correctly_answered' => $correctly_answered,
                        'token' => $params['token']
                    ]);
                } else {
                    loadView('game/index', [
                        'data' => $this->data,
                        'mistakes' => $mistakes,
                        'correctly_answered' => $correctly_answered,
                        'token' => $params['token']
                    ]);

                }

            } else {
                loadView('game/end', [
                    'error' => 'You have answered incorrectly 3 times!',
                    'correctly_answered' => $correctly_answered
                ]);
            }

        }






    }

}