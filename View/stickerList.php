<div class="flex linkContainer">
<?php
foreach ($data as $value) {
?>
    <a href="/index.php?c=activity&a=show-activity&id=<?= $value->getActivity()->getId() ?>">
        <div class="frame white profile_color">
            <span><?= $value->getActivity()->getName() ?></span>
        </div>
    </a>
<?php
}
?>
</div>
