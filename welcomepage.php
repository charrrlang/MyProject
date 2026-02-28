<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Welcome Page</title> 

    <style>
        /* 1. Reset and Global Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* 2. Header Layout Fix */
        header {
            background-color: #86887c;
            display: flex;
            padding: 10px 20px; 
            align-items: center;
            justify-content: space-between; /* Pushes logo-group and auth-group apart */
            width: 100%;
            box-sizing: border-box;
        }

        /* NEW: Container to keep Logo and Title together on the left */
        .logo-group {
            display: flex;
            align-items: center;
            gap: 15px; /* Distance between logo and text */
        }

        .UC-logo {
            width: 100px;
        }

        .system-title {
            margin: 0;
            font-size: 1.3rem;
            color: #1a2fa3; /* Your blue theme color */
        }

        /* 3. Navigation Links and Dropdown */
        .auth-group {
            display: flex;
            gap: 25px; 
            align-items: center;
        }

        .nav-link, .dropbtn {
            text-decoration: none;
            color: #1a2fa3;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1000;
            border-radius: 4px;
            top: 100%; 
            left: 0;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: background 0.2s;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
            color: #1a2fa3;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Invisible bridge to fix the hover gap */
        .dropdown-content::before {
            content: "";
            position: absolute;
            top: -15px;
            left: 0;
            width: 100%;
            height: 15px;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-group">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/University_of_Cebu_Logo.png/960px-University_of_Cebu_Logo.png" alt="UC logo" class="UC-logo">
            <h1 class="system-title">College of Computer Studies Sit-in Monitoring</h1>
        </div>

        <div class="auth-group">
            <a href="welcomepage.php" class="nav-link">Home</a>

            <div class="dropdown">
                <button class="dropbtn">Community ▼</button>
                <div class="dropdown-content">
                    <a href="#">School Info</a>
                    <a href="#">Rules</a>
                    <a href="#">Contact</a>
                </div>
            </div>

            <a href="about.php" class="nav-link">About</a>
            <a href="login.php" class="nav-link">Login</a>
            <a href="register.php" class="nav-link">Register</a>
        </div>
    </header>

</body>
</html>