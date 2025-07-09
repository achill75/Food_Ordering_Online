<header id="header" class="header-scroll top-header headrom headerBg">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
            <a class="navbar-brand" href="index.php">Online Food Order</a>

            <div class="collapse navbar-toggleable-md float-lg-right d-flex align-items-center" id="mainNavbarCollapse">
                <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="restaurants.php">Restaurants</a></li>
                    <?php
                        if (empty($_SESSION["user_id"])) {
                            // Belum login
                            echo '
                                <li class="nav-item"><a href="login.php" class="nav-link active">Login</a></li>
                                <li class="nav-item"><a href="registration.php" class="nav-link active bgGreen">Signup</a></li>
                            ';
                        } else {
                            // Ambil nama dan gambar, bisa dari login manual atau login Google
                            $username = htmlspecialchars($_SESSION['username'] ?? 'User');
                            $picture = !empty($_SESSION['picture']) 
                                ? $_SESSION['picture'] 
                                : 'https://i0.wp.com/dianisa.com/wp-content/uploads/2022/08/7.-Profil-WA-Kosong.jpg?resize=1000%2C580&ssl=1';

                            echo '
                                <li class="nav-item"><a href="your_orders.php" class="nav-link active">Your Orders</a></li>
                                <li class="nav-item d-flex align-items-center" style="margin-left: 100px; margin-top: 7px;">
                                    <div class="d-flex align-items-center">
                                    <img src="' . $picture . '" alt="Profile" width="35" height="35" style="border-radius: 50%; object-fit: cover;">
                                        <span class="text-white">Hi, ' . $username . '</span>
                                    </div>
                                </li>
                                <li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a></li>
                            ';
                        }
                        ?>


                </ul>
            </div>
        </div>
    </nav>
</header>
