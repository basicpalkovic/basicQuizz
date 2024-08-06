<?php

use Framework\Session;

?>


<!-- Nav -->
<header class="bg-blue-900 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
            <a href="/">Quizzler</a>
        </h1>
        <nav class="space-x-4">
            <?php if (!Session::has('user')): ?>
                <a href="/auth/login" class="text-white hover:underline">Login</a>
                <a href="/auth/register" class="text-white hover:underline">Register</a>

            <?php else: ?>
                <div class="flex justify-between items-center gap-4">
                    <div>Welcome <?= Session::get('user')['username'] ?></div>
                    <form type="submit" method="POST" action="/auth/logout">
                        <button class="text-white inline hover:underline">Logout</button>
                    </form>



                </div>


            <?php endif; ?>


        </nav>
    </div>
</header>