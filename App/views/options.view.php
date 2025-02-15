<?php

Framework\Session::clear('game');

$chToken = curl_init();
$urlToken = "https://opentdb.com/api_token.php?command=request";

curl_setopt($chToken, CURLOPT_URL, $urlToken);
curl_setopt($chToken, CURLOPT_RETURNTRANSFER, true);
$respToken = curl_exec($chToken);




if ($e = curl_error($chToken)) {
    $errors = $e;
} else {

    $token = json_decode($respToken);
    curl_close($chToken);


}

?>


<form action="/game/<?= $token->token ?>" method="POST">

    <div>
        <label for="difficulty">Choose a difficulty:</label>

        <select name="difficulty" id="difficulty">
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
    </div>


    <div>
        <label for="category">Choose a category:</label>

        <select name="category" id="category">
            <option value="">Any Category</option>
            <option value="9">General Knowledge</option>
            <option value="10">Entertainment: Books</option>
            <option value="11">Entertainment: Film</option>
            <option value="12">Entertainment: Music</option>
            <option value="13">Entertainment: Books</option>
            <option value="14">Entertainment: Musicals & Theaters</option>
            <option value="15">Entertainment: Video Games</option>
            <option value="16">Entertainment: Board Games</option>
            <option value="17">Science & Nature</option>
            <option value="18">Science: Computers</option>
            <option value="19">Science: Mathematics</option>
            <option value="20">Mythology</option>
            <option value="21">Sports</option>
            <option value="22">Geography</option>
            <option value="23">History</option>
            <option value="24">Politics</option>
            <option value="25">Art</option>
            <option value="26">Celebrities</option>
            <option value="27">Animals</option>
            <option value="28">Vehicles</option>
            <option value="29">Entertainment: Comics</option>
            <option value="30">Science: Gadgets</option>
            <option value="31">Entertainment: Japanese Anime & Manga</option>
            <option value="32">Entertainment: Cartoon & Animations</option>
        </select>



    </div>
    <button type="submit">Start Game</button>

</form>