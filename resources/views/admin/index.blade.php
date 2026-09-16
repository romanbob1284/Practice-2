<!DOCTYPE html>

<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Адмін-панель</title>


</head>

<body>


<h1>Адмін-панель</h1>

<p id="message">Перевірка авторизації...</p>

<div id="admin-content" style="display: none;">

    <h2>Вітаємо, адміністраторе!</h2>

    <p>
        Ім'я:
        <strong id="name"></strong>
    </p>

    <p>
        Електронна пошта:
        <strong id="email"></strong>
    </p>

    <p>
        Роль:
        <strong id="role"></strong>
    </p>

    <button id="logout">Вийти</button>

</div>


<script>

    async function loadAdminPanel()
    {
        const token = localStorage.getItem('jwt');


        // JWT відсутній
        if (!token)
        {
            window.location.href = '/login';
            return;
        }


        try
        {
            const response = await fetch('/api/admin', {
                method: 'GET',

                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });


            // JWT недійсний або відсутній
            if (response.status === 401)
            {
                localStorage.removeItem('jwt');

                window.location.href = '/login';

                return;
            }


            // Користувач авторизований,
            // але не має ролі Admin
            if (response.status === 403)
            {
                document.getElementById('message').textContent =
                    'У вас немає доступу до адмін-панелі.';

                return;
            }


            // Інша помилка сервера
            if (!response.ok)
            {
                document.getElementById('message').textContent =
                    'Помилка при завантаженні адмін-панелі.';

                return;
            }


            // Отримуємо JSON від AdminController
            const data = await response.json();


            // Ховаємо повідомлення про перевірку
            document.getElementById('message').style.display = 'none';


            // Показуємо адмін-панель
            document.getElementById('admin-content').style.display = 'block';


            // Виводимо дані користувача
            document.getElementById('name').textContent = data.name;

            document.getElementById('email').textContent = data.email;

            document.getElementById('role').textContent = data.role;
        }
        catch (error)
        {
            console.error(error);

            document.getElementById('message').textContent =
                'Не вдалося підключитися до сервера.';
        }
    }


    // Logout
    document.getElementById('logout').addEventListener('click', async function ()
    {
        const token = localStorage.getItem('jwt');


        try
        {
            await fetch('/api/auth/logout', {
                method: 'POST',

                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
        }
        finally
        {
            // Видаляємо JWT з браузера
            localStorage.removeItem('jwt');

            // Повертаємося на сторінку входу
            window.location.href = '/login';
        }
    });


    // Завантажуємо адмін-панель
    loadAdminPanel();

</script>


</body>

</html>
