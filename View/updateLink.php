<section id="profile" class="flex white">
    <?php
    $value = $data['link'];
    ?>
    <div class="flex">
        <h2>Mise à jour du lien : </h2>
        <div id="admin" class="flex">
            <div>
                <h3><?=$value->getTitle()?></h3>
                <span>* = champ obligatoire</span>
                <form action="/Index.php?c=toolbox&a=up-link&id=<?=$value->getId()?>" method="post">
                    <div>
                        <label for="link-type">Type</label>
                        <select name="link-type" id="link-type">
                            <option value="health">Sante</option>
                            <option value="mobility">Mobilité</option>
                            <option value="help">Aide</option>
                            <option value="training">Formation</option>
                        </select>
                    </div>
                    <div>
                        <input type=text name="title" value="<?=$value->getTitle()?>" >
                    </div>
                    <div>
                        <input type="url" id="newUrl" name="new-url" value="<?=$value->getUrl()?>">
                    </div>
                    <div>
                        <input type="submit" name="add-link">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
?>
</section>