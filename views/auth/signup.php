<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Signup</title>
    </head>

    <body>
        <h1>Signup</h1>
        <?php if (!empty($error)): ?>
            <p style="Color: red"> <?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="/signup" method="POST">
            <label>
                <input type="first_name" name="first_name" placeholder="First name" required>
            </label>
            <br>
            <label>
                <input type="last_name" name="last_name" placeholder="Last name" required>
            </label>
            <br>
            <label>
                <input type="email" name="email" placeholder="Email" required>
            </label>
            <br>
            <label>
                <input type="password" name="password" placeholder="Password" required>
            </label>
            <br>
            <label>
                <select name="role" id="role">
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                </select>
            </label>
            <br>
            <button type="submit">Submit</button>
        </form> 
    </body>
</html>