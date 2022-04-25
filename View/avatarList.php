<div class="flex avatar">
<?php
    foreach ($data as $key => $value) {
    ?>
        <a href="/index.php?c=profile&a=change-avatar&key=<?= $key ?>">
            <div class="avatar_background frame">
                <img src="/assets/img/avatar/<?= $value ?>" alt="<?= explode('.', $value)[0] ?>" class="avatar">
            </div>
        </a>
    <?php
    }
?>
</div>
