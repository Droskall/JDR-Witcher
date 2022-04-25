<section id="userList">
    <h2>Liste des utilisateurs</h2>
    <div class="flex">
        <?php
        foreach ($data as $item) {
            ?>
            <div class="frame flex white">
                <img src="/assets/img/avatar/<?= $item->getAvatar() ?>" width="50px" alt="user logo">
                <div>
                    <p>Nom : <?= $item->getUsername() ?></p>
                    <p>Email : <?= $item->getEmail() ?></p>
                    <p>Role : <?= $item->getRole() ?></p>
                    <div>
                        <form action="/index.php?c=user&a=update" method="post">
                            <input type="hidden" name="id" value="<?= $item->getId() ?>">
                            <select name="userRole" id="userRole">
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                            <input type="submit" name="update" value="Valider">
                        </form>
                        <form action="/index.php?c=user&a=delete" method="post">
                            <input type="hidden" name="id" value="<?= $item->getId() ?>">
                            <input type="submit" name="suppr" value="Supprimer l'utilisateur">
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

</section>