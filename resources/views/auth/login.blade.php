<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Вхід</title>
</head>

<body>
    <h1>Увійти</h1>

    <form id="login">
        <label for="email">Електронна пошта:</label>
        <input type="email" id="email" name="email" placeholder="example@mail.com" required>
        <br>
        <label for="password">Електронна пошта:</label>
        <input type="password" id="password" name="password" placeholder="abcd1234" required>
        <br><br>
        <button type="submit">Увійти</button>
    </form>

    <h3 id="message"></h3>

     <script>
        document.getElementById('login').addEventListener('submit', async function (event)
        {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch('/api/auth/login', {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });

            const data = await response.json();

            if (response.ok)
            {
                localStorage.setItem('jwt', data.access_token);

                document.getElementById('message').textContent =
                    'Ви увійшли до особистого кабінету !';

                window.location.href = '/dashboard';
            } else
            {
                document.getElementById('message').textContent =
                    'Невірний пароль чи електронна пошта.';
            }
        });
    </script>

</body>
</html>