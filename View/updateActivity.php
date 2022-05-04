
<section id="profile" class="flex white">
    <?php
    $value = $data['activity'];
    ?>
    <div class="flex">
        <h2>Mise à jour de l'activité</h2>
        <div id="admin" class="flex">
            <div id="add-activity">
                <h3>Modifier l'Activites : <?= $value->getName() ?></h3>
                <span>* = Champ obligatoire</span>
                <form action="/index.php?c=activity&a=upAct&id=<?= $value->getId() ?>" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="title">Titre * :</label>
                        <input type="text" id="title" name="title" value="<?= $value->getName() ?>">
                    </div>
                    <div>
                        <label for="category-type">Categorie * :</label>
                        <select name="category-type" id="category-type">
                            <option value="help">Aide de jeu</option>
                            <option value="resource">Ressource</option>
                            <option value="utils">Outils</option>
                        </select>
                    </div>
                    <div>
                        <label for="activity-type">Type * :</label>
                        <select name="activity-type" id="activity-type">
                            <option value="creat">Crèations</option>
                            <option value="info">Information</option>
                            <option value="event">Événements</option>
                        </select>
                    </div>
                    <div>
                        <label for="picture">image : </label>
                        <input type="file" id="picture" name="picture" accept=".image/jpeg, .jpg, .png">&nbsp;(Max: 3Mo)
                    </div>
                    <textarea name="content" id="content" cols="40" rows="10"><?= $value->getDescription() ?></textarea>*
                    <div>
                        <label for="url">PDF :</label>
                        <input type="file" name="url" accept="application/pdf">
                    </div>
                    <div>
                        <input type="submit" name="updateAct">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>