<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Liste des users</title>
    </head>

    <body>
        <h1>Users</h1>
        <table border="1">
            <thread>
                <tr>
                    <th>ID</th>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thread>
            <tbody>
                <?php foreach ($users as $users): ?>
                    <tr>
                        <td><?= htmlspecialchars($users['id']) ?></td>
                        <td><?= htmlspecialchars($users['first_name']) ?></td>
                        <td><?= htmlspecialchars($users['last_name']) ?></td>
                        <td><?= htmlspecialchars($users['email']) ?></td>
                        <td><?= htmlspecialchars($users['role']) ?></td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>