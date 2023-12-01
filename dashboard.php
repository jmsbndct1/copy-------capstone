<?php
    session_start();
    if (!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: login.php");
        die();
    }

    include 'config.php';

    $query = mysqli_query($conn, "SELECT * FROM sample_form WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
     " <a href='logout.php'>Logout</a>";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Student Dashboard</title>
</head>

<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <ul class="side-menu">
            <li><a href="#" class="active"><i class='bx bxs-dashboard icon'></i>Dashboard</a></li>
            <li class="divider" data-text="main">CodeIT</li>
            <li>
                <a href="#"><i class='bx bxs-inbox icon'></i>Home<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Videos</a></li>
                    <li><a href="#">Tutorials</a></li>
                    <li><a href="compiler/ui/ide.html">IDE</a></li>

                </ul>
                <a href="quiz/index.html"><i class='bx bxs-inbox icon'></i>Challenges<i class='bx bx-chevron-right icon-right'></i></a>
        </ul>
        <div class="ads">
            <div class="wrapper">
                <a href="logout.php" class="btn-upgrade">Logout</a>
            </div>
        </div>
    </section>

    <section id="content">
        <nav>
            <i class='bx bx-menu toggle-sidebar'></i>
        </nav>
    </section>
    <script src="script/dashboard.js"></script>
</body>

</html>