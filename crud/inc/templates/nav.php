<?php 
session_start([
    'cookie_lifetime'=>300  // 5 min
]);

?>

<!-- <div>
    <div class="float-left">
        <p>
            <a href="/crud/index.php?task=report" class="btn">All Students</a> |
            <a href="/crud/index.php?task=add" class="text-decoration-none">Add New Students</a> |
            <a href="/crud/index.php?task=seed" class="text-decoration-none">Seed</a>
        </p>
    </div>
    <div class="float-right">
        <a href="/crud/auth.php" class="btn">login</a>
    </div>
</div> -->


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/crud/index.php?task=report">All Students</a>
                </li>

                <?php if(hasPrivilege()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/crud/index.php?task=add">Add New Students</a>
                    </li>
                <?php endif; ?>

                <?php if(isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/crud/index.php?task=seed">Seed</a>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav me-0 mb-2 mb-lg-0">
                <?php if(!isset($_SESSION['logedin']) || $_SESSION['logedin'] == false): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/crud/auth.php">Login</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/crud/auth.php?logout=true">Logout-<?php if(isset($_SESSION['role'])){echo $_SESSION['role'];} ?></a>
                    </li>
                <?php endif; ?>
            </ul>
            <!-- <span class="navbar-text">
                <a class="nav-link" href="/crud/auth.php">Login</a>
            </span> -->
        </div>
    </div>
</nav>
