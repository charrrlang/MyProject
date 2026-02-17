<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Welcome Page</title> 

    <style>
        header {
            background-color: #86887c;
            display: flex;
            padding: 18px; 
            align-items: center;
            justify-content: space-between
        }
        .UC-logo {
            width: 100px;  /* Adjust this number to make it smaller or larger */
        }
        .auth-group {
            display: flex;
            gap: 15px;
        
        }
        .nav-link {
            text-decoration: none; /* Removes underline */
            color: #1a2fa3;
            font-weight: bold;
        }
    </style>

</head>
<body>
    <header><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/University_of_Cebu_Logo.png/960px-University_of_Cebu_Logo.png" alt="UC logo" class="UC-logo">
    <div class="auth-group">
    <a href="welcomepage.php" Class="nav-link">Home</a>
    <a href="login.php" class="nav-link">Login</a>
    <a href="register.php" class="nav-link">Register</a>
    </div>



    </header>
</body>


</html>