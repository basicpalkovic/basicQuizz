<?php

loadPartial('head');
loadPartial('navbar');



?>

<section class="mt-huge">
    This is the home page
</section>

<h1>Hello</h1>

<form action="/game/options" method="GET">
    <button type="submit">Start Game</button>

</form>

<?php

loadPartial('footer');
?>