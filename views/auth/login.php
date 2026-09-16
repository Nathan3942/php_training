<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
    </head>

    <body>
        <h1>Connexion</h1>
        
        <?php if (!empty($error)): ?>
            <p style="Color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

		<form action="/login" method="POST">
			<label>
				<input type="email" name="email" placeholder="Email" required>
			</label>
			<br>
			<label>
				<input type="password" name="password" placeholder="Password" required>
			</label>
			<br>
			<button type="submit">Se connecter</button>
		</form>
    </body>
</html>