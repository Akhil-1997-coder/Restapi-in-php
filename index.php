<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MySQLi API Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-container {
            margin-bottom: 20px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .form-container form input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container form button {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-container form button:hover {
            background-color: #218838;
        }
        .add-form-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .add-form-button:hover {
            background-color: #0056b3;
        }
        .add-form-button i {
            margin-right: 5px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Users</h1>
        <div class="form-container">
            <button class="add-form-button" id="toggleFormButton">
                <i class="fas fa-plus"></i> Add User
            </button>
            <form id="addForm" class="hidden">
                <input type="text" name="name" id="name" placeholder="Name" required>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <button type="button" onclick="addUser()">Add User</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- Table data will go here -->
            </tbody>
        </table>
    </div>
    <script>
        document.getElementById('toggleFormButton').addEventListener('click', function(event) {
            event.preventDefault();
            var form = document.getElementById('addForm');
            form.classList.toggle('hidden');
        });

        const apiKey = '1234'; // Set your API key here

        function fetchUsers() {
            fetch('api.php', {
                headers: {
                    'API_KEY': apiKey
                }
            })
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('userTableBody');
                tableBody.innerHTML = '';
                data.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td>${user.id}</td><td>${user.name}</td><td>${user.email}</td>`;
                    tableBody.appendChild(row);
                });
            });
        }

        function addUser() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;

            fetch('api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'API_KEY': apiKey
                },
                body: JSON.stringify({ name: name, email: email })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchUsers();
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchUsers();
        });
    </script>
</body>
</html>
