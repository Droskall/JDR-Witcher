<section id="profile" class="white flex">
        <div class="flex profile_color">
            <h2>PROFIL</h2>
            <div id="profile-content" class="flex">
                <div class="flex">
                    <h2>Utilisateur</h2>
                    <div id="user-data">
                        <h3>Vos informations personnelles</h3>
                        <div>
                            <img class="avatar" src="/assets/img/avatar/<?= $data['avatar'] ?>" alt="user's avatar">
                        </div>
                        <button class="change_avatar"><a href="/index.php?c=profile&a=avatar-list">changer d'avatar</a></button>

                        <p>Nom / Pseudo : <?= $_SESSION['user']->getUsername() ?></p>
                        <p>Email : <?= $_SESSION['user']->getEmail() ?></p>
                        <p>Role : <?= $_SESSION['user']->getRole() ?></p>
                        <a href="/index.php?c=profile&a=user-info" class="change_info">Modifier les informations personnelles</a>
                    </div>
                    <div id="user-reaction" class="flex">
                        <h3>Vos interractions</h3>
                        <div class="flex">
                            <a href="/index.php?c=profile&a=sticker-list&type=heart">
                                <img src="/assets/img/emojis/heart_colored.png" alt="heart">
                                <span>Coup de coeur</span>
                            </a>
                            <a href="/index.php?c=profile&a=sticker-list&type=epic">
                                <img src="/assets/img/emojis/epic_colored.png" alt="epic">
                                <span>Epique</span>
                            </a>
                            <a href="/index.php?c=profile&a=sticker-list&type=success">
                                <img src="/assets/img/emojis/success_colored.png" alt="success">
                                <span>Réussite critique</span>
                            </a>
                            <a href="/index.php?c=profile&a=sticker-list&type=fail">
                                <img src="/assets/img/emojis/fail_colored.png" alt="fail">
                                <span>Echec critique</span>
                            </a>
                            <a href="/index.php?c=profile&a=sticker-list&type=dead">
                                <img src="/assets/img/emojis/dead_colored.png" alt="dead">
                                <span>Mort</span>
                            </a>
                        </div>

                        <?php if($_SESSION["user"]->getRole() === "admin"){?>
                            <div class="button">
                                <a href="/index.php?c=user" id="listUser">Liste Utilisateurs</a>
                            </div>
                        <?php }?>

                        <div class="buttonDelete">
                            <input type="hidden" name="id" value="<?= $_SESSION['user']->getId() ?>">
                            <a href="/index.php?c=user&a=deleteself" id="deleteUser">Supprimer son compte</a>
                        </div>
                    </div>
                </div>

                <?php if($_SESSION["user"]->getRole() === "admin"){?>
                <div id="admin" class="flex">
                    <h2>Administrateur</h2>
                    <div>
                        <div id="add-activity">
                            <h3  id="contains">Ajouter un article</h3>
                            <span>* = Champ obligatoire</span>
                            <form action="/index.php?c=activity&a=add" method="post" enctype="multipart/form-data">
                                <div>
                                    <label for="title">Titre * :</label>
                                    <input required type="text" id="title" name="title">
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
                                    <label for="picture">Image : </label>
                                    <input type="file" id="picture" name="picture" accept=".image/jpeg, .jpg, .png">&nbsp;(Max: 3Mo)
                                </div>
                                <textarea name="content" id="content" cols="40" rows="10"></textarea>*
                                <div>
                                    <label for="url">PDF :</label>
                                    <input type="file" name="url" accept="application/pdf">
                                </div>
                                <div>
                                    <input id="addActBtn" type="submit" name="addAct">
                                </div>
                            </form>
                        </div>
                        <div id="add-link">
                            <h3>Ajouter un lien utile</h3>
                            <form action="/index.php?c=toolbox&a=add-link" method="post">
                                <div>
                                    <label for="link-type">Type</label>
                                    <select name="link-type" id="link-type">
                                        <option value="discord">Discord</option>
                                        <option value="useful">Liens utiles</option>
                                        <option value="video">Vidéos et Stream</option>
                                        <option value="notice">Mentions Légales</option>
                                    </select>
                                </div>
                                <div>
                                    <input required type=text name="title" placeholder="titre *">
                                </div>
                                <div>
                                    <input required type="url" id="newUrl" name="new-url" placeholder="lien *">
                                </div>
                                <div>
                                    <input id="linkBtn" type="submit" name="add-link">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </section>
