<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        a {
            text-decoration: none;
        }

        /* 2. Basic styling for the body */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* 3. Style the form container */
        form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 4px;
            width: 300px;
            margin-top: 50px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* 4. Style the inputs */
        input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* 5. Style the Login Button */
        button {
            background-color: #1a2fa3;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        /* 6. Style the Cancel Link to look like a button */
        .btn-cancel {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            display: inline-block;
        }

        .btn-cancel:hover {
            background-color: #e2e6ea;
        }
    </style>
</head>
<body>

<h2>Login Form</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
</form>

</body>
</html>
