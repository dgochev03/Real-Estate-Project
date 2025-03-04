<html>
    <head>
        <style>
            body {
                background-color: white;
                margin: 0;
                padding: 0;
            }

            .header {
                display: flex;
                align-items: center;
                background-color: #333;
            }

            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                flex-grow: 1;
            }

            li {
                float: left;
            }

            li a, .dropbtn {
                display: inline-block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            li a:hover, .dropdown:hover .dropbtn {
                background-color: #f39c12;
            }

            li.dropdown {
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }

            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                text-align: left;
            }

            .dropdown-content a:hover {
                background-color: #f39c12;
            }

            .dropdown:hover .dropdown-content {
                display: block;
            }

            .logo {
                padding: 10px;
                height: 100px;
            }
        </style>
    </head>
    <body>

        <div class="header">
            <a href="index.php"><img src="images/logo/logo-house.svg" alt="Logo" class="logo"></a>

            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="property.php">Properties</a></li>
                <li><a href="submitproperty.php">Publish</a></li>
                <?php if (isset($_SESSION['uemail'])) { ?>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropbtn">My account</a>
                        <div class="dropdown-content">
                            <a href="profile.php">Profile</a>
                            <a href="feature.php">My properties</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item"> <a class="nav-link" href="login.php">Login/Register</a> </li>
                    <?php } ?>
            </ul>
        </div>

    </body>
</html>


