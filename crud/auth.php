<?php 
session_start([
    'cookie_lifetime'=>300  // 5 min
]);
$error = false;

$fp = fopen("./data/users.txt", "r");

$data = fgetcsv($fp);

// print_r($data[1]);
// die;

$username = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); 


if($username && $password){
    
    $_SESSION['logedin'] = false;
    $_SESSION['user'] = false;
    $_SESSION['role'] = false;

    while($data = fgetcsv($fp)){
        if($username == $data[0] && sha1($password) == $data[1]){
            $_SESSION['logedin'] = true;
            $_SESSION['user'] = $username;
            $_SESSION['role'] = $data[2];
            header('location:index.php');
        }
    }
    if(!isset($_SESSION['logedin']) || !$_SESSION['logedin']){
        $error = true;
    }
    
}



if(isset($_GET['logout'])){
    $_SESSION['logedin'] = false;
    $_SESSION['user'] = false;
    $_SESSION['role'] = false;
    session_destroy();
    header('location:auth.php');
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Crud</title>
  </head>
  <body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-6 offset-3">
                <h2 class="text-center text-primary">Login</h2>
                <hr>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-md-6 offset-3">
                <?php 
                    if(isset($_SESSION['logedin']) && true == $_SESSION['logedin']){
                        printf('<h4 class="text-center text-info">Hello Admin! Welcome.</h4>');
                    }else{
                        printf('<h4 class="text-center text-info">Hello stranger! Login bellow.</h4>');
                    }

                ?>
                
            </div>
        </div>

        <div class="raw">
            <div class="col-md-6 offset-3">

                <?php 
                    if($error){
                        echo"<blockquote class='text-danger'>Username and password didn't match.</blockquote>";
                    }
                    if(!isset($_SESSION['logedin']) || $_SESSION['logedin'] == false): 
                ?>
                    <form action="<?php //printf('/crud/index.php?task=edit&id=%s', $student['id']); ?>" method="POST">
                        <label for="userName">User Name</label>
                        <input type="text" name="userName" id="userName" class="form-control" value="">

                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="">

                        <br>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-outline-primary" name="submit">Login</button>
                        </div>
                    </form>
                <?php else: ?>
                    <form action="auth.php" method="POST">
                        <div class="d-grid gap-2">
                            <input type="hidden" name="logout" value="1">
                            <button type="submit" class="btn btn-outline-primary" name="submit">Logout</button>
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>


    </div>
        

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- <script src="assets/script.js" type="text/javascript"></script> -->
    <!-- <script src="assets/js/script.js" type="text/javascript"></script> -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   

    <!-- <script src="crud/assets/js/script.js"></script> -->
    <!-- D:/Programming/PHP/Master-in-PHP/CRUD-Product-2/crud/assets/js/ -->
  </body>

</html>