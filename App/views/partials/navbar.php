<?php

use Framework\Session;

?>


<!-- Nav -->
<header>
    <h1>
        <a href="/">BasicQuizz</a>
    </h1>
    <nav>
        <?php if (!Session::has('user')): ?>
            <div class="profile-item-holder">
                <a href="/auth/login">Login</a>
                <a href="/auth/register">Register</a>
            </div>
        <?php else: ?>
            <div class="profile-item-holder">
                <a href="/profile">Profile</a>
                <form type="submit" method="POST" action="/auth/logout">
                    <button>Logout</button>
                </form>



            </div>


        <?php endif; ?>


    </nav>

</header>