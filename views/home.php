
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($title) ?></h1>

    <?php if (!$_SESSION['user_id']): ?>
        <a href="login">Login</a>
        <a href="signup">Signup</a>
    <?php else: ?>
        <a href="userPage">User page</a>
    <?php endif; ?>
</body>

</html>