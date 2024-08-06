<?php if (!empty($errors)): ?>
    <div class="message bg-red-100 p-3 my-3">
        <?php
        foreach ($errors as $error): ?>
            <?= $error . '<br> ' ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>