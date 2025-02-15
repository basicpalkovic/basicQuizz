<?php

loadPartial('head');


// inspect($correct_questions);
// inspect($mistakes);



inspect($data);
if ($data->response_code == 0):
    $question = $data->results[0]->question;
    $correct_answer = $data->results[0]->correct_answer;
    $incorrect_answers = $data->results[0]->incorrect_answers;
    $all_answers = $incorrect_answers;
    array_push($all_answers, $correct_answer);
    shuffle($all_answers);

    ?>
    <form id="gameForm" action="/game/<?= $token ?>" method="POST">
        <h2><?= $question ?></h2>
        <h4><?= $mistakes ?></h4>
        <div class="input-items">

            <?php foreach ($all_answers as $answer): ?>
                <div>
                    <label for="<?= $answer ?>"><?= $answer ?></label>
                    <input type="radio" name="answer" value="<?= $answer ?>" id="<?= $answer ?>">
                </div>
            <?php endforeach ?>
        </div>
        <input type="hidden" name="correct_answer" value="<?= $correct_answer ?>">
        <input type="hidden" name="correctly_answered" value="<?= $correctly_answered ?>">
        <input type="hidden" name="mistakes" value="<?= $mistakes ?>">
        <button disabled type="submit" id="btnSubmit">Submit</button>
    </form>
    <?php inspect($correct_answer) ?>
<?php else: ?>

    <form action="/game/options" method="GET">

        <h3>Something went wrong</h3>
        <button type="submit">Go back to options page</button>
    </form>
<?php endif; ?>

<script>

    setTimeout(function () { document.getElementById("btnSubmit").disabled = false; }, 5000);


</script>

<?php loadPartial('footer'); ?>