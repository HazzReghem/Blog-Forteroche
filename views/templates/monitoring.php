<h2>Page de Monitoring</h2>

<div class="adminMonitoring">
    <table class="tableMonitor">
        <thead>
            <tr>
                <th class="tableHead">
                    <a href="index.php?action=showMonitoring&sort=title&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Titre <i class="fa-solid fa-sort"></i></a>
                </th>
                <th class="tableHead">
                    <a href="index.php?action=showMonitoring&sort=views&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Vues <i class="fa-solid fa-sort"></i></a>
                </th>
                <th class="tableHead">
                    <a href="index.php?action=showMonitoring&sort=comments&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Commentaires <i class="fa-solid fa-sort"></i></a>
                </th>
                <th class="tableHead">
                    <a href="index.php?action=showMonitoring&sort=date_creation&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Date de création <i class="fa-solid fa-sort"></i>
                    <!-- <?php if ($sort === 'date_creation') { ?>
                            <i class="fa-solid fa-sort-<?= $order === 'ASC' ? 'down' : 'up' ?>"></i>
                        <?php } ?> -->
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article) { ?>
                <tr>
                    <td><?= $article->getTitle() ?></td>
                    <td><?= $article->getViews() ?></td>
                    <td><?= $article->getCommentCount() ?></td>
                    <td><?= $article->getFormattedDateCreation() ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<a class="submit" href="index.php?action=admin">Retour à la page Admin</a>