<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Особистий кабінет</title>
</head>

<body>
    <h1>Особистий кабінет</h1>

    <div id="message">
        Завантаження...
    </div>

    <div id="userData" style="display: none;">
        <p>
            <strong>Ім'я:</strong>
            <span id="name"></span>
        </p>

        <p>
            <strong>Email:</strong>
            <span id="email"></span>
        </p>

        <p>
            <strong>Роль:</strong>
            <span id="role"></span>
        </p>
    </div>

    <button id="logout">Вийти</button>

    <script>
        function createOrdersAndDishes(orders)
        {
            const translation =
            {
                en: ['status', 'payment_method', 'cash',
                'card', 'total_price', 'created_at',
                'updated_at', 'title', 'description',
                'price', 'quantity', 'ingredients'],

                ua: ['Статус', 'Спосіб оплати', 'Готівка',
                'Карта', 'Чек', 'Створено',
                'Оновлено', 'Назва', 'Опис',
                'Вартість', 'Кількість', 'Інгредієнти'],
            }

            const ul = document.createElement('ul');
            ul.id = 'orders';

            order_num = 0;

            for (const order of orders)
            {
                const li = document.createElement('li');
                ul.appendChild(li);
                
                ++order_num;

                const header = document.createElement('h1');
                header.textContent = `Замовлення №${order_num}`;
                li.appendChild(header);

                const ul_order = document.createElement('ul');
                ul_order.style.listStyleType = 'none';
                ul_order.id = `order${order_num}`;
                li.appendChild(ul_order);
                
                for (const [key, value] of Object.entries(order))
                {
                    if (translation.en.indexOf(key) !== -1 || key === 'dishes')
                    {
                        const li_order = document.createElement('li');
                        ul_order.appendChild(li_order);

                        if(key !== 'dishes')
                            {
                                if (key === 'created_at' || key === 'updated_at')
                                {
                                    const date_value = new Date(value).toLocaleString('uk-UA');

                                    li_order.textContent = `${translation.ua[translation.en.indexOf(key)]}: ${date_value}`;
                                }
                                else { li_order.textContent = `${translation.ua[translation.en.indexOf(key)]}: ${value}`; }
                            }
                        else {
                            const ul_dishes = document.createElement('ul');
                            ul_dishes.style.listStyleType = 'none';
                            li_order.appendChild(ul_dishes);

                            for (const dish of order.dishes)
                            {
                                
                                const li_dishes = document.createElement('li');
                                ul_dishes.appendChild(li_dishes);
                                
                                const ul_dish = document.createElement('ul');
                                ul_dish.style.listStyleType = 'none';
                                ul_dish.appendChild(document.createElement('br'));
                                li_dishes.appendChild(ul_dish);

                                for (const [dish_key, dish_value] of Object.entries(dish))
                                {
                                    if (translation.en.indexOf(dish_key) !== -1) 
                                    {
                                        const li_dish = document.createElement('li');
                                        ul_dish.appendChild(li_dish);

                                        if (dish_key !== 'ingredients')
                                        {
                                            if (dish_key === 'created_at' || dish_key === 'updated_at')
                                            {
                                                 const dish_date_value = new Date(dish_value).toLocaleString('uk-UA');
                                                li_dish.textContent = `${translation.ua[translation.en.indexOf(dish_key)]}: ${dish_date_value}`;
                                            }
                                            else { li_dish.textContent = `${translation.ua[translation.en.indexOf(dish_key)]}: ${dish_value}`; }
                                        } else {
                                            li_dish.textContent = `${translation.ua[translation.en.indexOf(dish_key)]}: ${dish_value.join(', ')}`;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            ul.style.listStyleType = 'none';
            return ul;
        }

        async function loadUser()
        {
            const token = localStorage.getItem('jwt');

            if (!token)
            {
                window.location.href = '/login';
                return;
            }

            const response = await fetch('/api/auth/me', {
                method: 'POST',

                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            if (response.ok)
            {
                const data = await response.json();

                document.getElementById('name').textContent =
                    data.name;

                document.getElementById('email').textContent =
                    data.email;

                document.getElementById('role').textContent =
                    data.role;

                document.getElementById('message').style.display =
                    'none';

                document.getElementById('userData').style.display =
                    'block';

                document.body.appendChild(createOrdersAndDishes(data.orders));
            }
            else
            {
                localStorage.removeItem('jwt');

                window.location.href = '/login';
            }
        }

        loadUser();


        document.getElementById('logout').addEventListener('click', async function ()
        {
            const token = localStorage.getItem('jwt');

            await fetch('/api/auth/logout', {
                method: 'POST',

                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            localStorage.removeItem('jwt');

            window.location.href = '/login';
        });
    </script>

</body>
</html>