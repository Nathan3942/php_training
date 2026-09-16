<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>User Page</title>
    </head>

    <body>
        <h1>User Page</h1>
        <h2>Info</h2>
        <li>First name : <?= htmlspecialchars($user['first_name']) ?></li>
        <li>Last name : <?= htmlspecialchars($user['last_name']) ?></li>
        <li>Email : <?= htmlspecialchars($user['email']) ?></li>
        <li>Role : <?= htmlspecialchars($user['role']) ?></li>
        <br>
        <form action="/users/<?= htmlspecialchars($user['id']) ?>/delete" method="POST">
            <button type="submit">Delete acount</button>
        </form>
        <form action="/logout">
            <button type="submit">Logout</button>
        </form>
    </body>
</html>