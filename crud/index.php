<?php
  require_once("inc/functions.php");
  $info = "";
  // $task = $_GET['task'] ??'report';
  // $task = isset($_GET['task']) ? $_GET['task'] : 'report';
  $task = $_GET['task'] ?? 'report';

  if ('delete' == $task){
        $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_STRING);
        if($id > 0){
            deleteStudent($id);
            header('location: /crud/index.php?task=report');
        }
        
  }

  $error = $_GET['error'] ?? '0';
  if ("seed" == $task){
    seed(DB_NAME);
    $info = "Seeding Complete.";
  }elseif("report" == $task){
    
    // $info = "Report Complete.";
  };

  $fname = '';
  $lname = '';
  $roll = '';
  if(isset($_POST['submit'])){
      // $id = 'HHH';
      $fname = filter_input(INPUT_POST,'fname', FILTER_SANITIZE_STRING);
      $lname = filter_input(INPUT_POST,'lname', FILTER_SANITIZE_STRING);
      $roll = filter_input(INPUT_POST,'roll', FILTER_SANITIZE_STRING);
      $id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_STRING);

      // echo var_dump($id);
      // die;

      if($id){
        $result = updateStudents($id,$fname, $lname, $roll);

          if($result){
              header('location: /crud/index.php?task=report');
          }else{
              $error='1';
          }

      }else{
          if($fname != '' && $lname != '' && $roll != ''){
              $result = addStudents($fname, $lname, $roll);

              if($result){
                header('location: /crud/index.php?task=report');
              }else{
                $error='1';
              }
          };
      }
      
  };
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
        <div class="row">
            <div class="col-md-6 offset-3">
                <h1>Crud Project</h1>
                <p>A simple crud project using plain data and php</p>

                <?php include_once("inc/templates/nav.php") ?>

                <hr>

                <?php if('' != $info){echo "<p>{$info}<p/>";}; ?>

            </div>
        </div>

        <?php if("1" == $error): ?>
            <div class="raw">
                <div class="col-md-6 offset-3">
                    <blockquote>Duplicate Roll number.</blockquote>
                </div>
            </div>
        <?php endif; ?>

        <?php if("report" == $task): ?>
            <div class="raw">
                <div class="col-md-6 offset-3">
                    <label for=""></label>
                    <?php generateRepotr(); ?>
                    
                </div>
            </div>
        <?php endif; ?>


        <?php if("add" == $task): ?>
            <div class="raw">
                <div class="col-md-6 offset-3">
                    <form action="/crud/index.php?task=add" method="POST">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $fname; ?>">

                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $lname; ?>">

                        <label for="roll">Roll</label>
                        <input type="number" name="roll" id="roll" class="form-control" value="<?php echo $roll; ?>">
                        <br>
                        <button type="submit" class="btn btn-primary" name="submit">Save</button>
                    </form>
                    
                </div>
            </div>
        <?php endif; ?>

        <?php 
            if("edit" == $task): 

                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

                $student = getStudent($id);

                if($student): 
              // echo var_dump($student);

              // die;
        ?>

            <div class="raw">
                <div class="col-md-6 offset-3">
                    <form action="<?php printf('/crud/index.php?task=edit&id=%s', $student['id']); ?>" method="POST">

                        <input type="hidden" name="id"  value="<?php echo $student['id']; ?>">

                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $student['fname']; ?>">

                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $student['lname']; ?>">

                        <label for="roll">Roll</label>
                        <input type="number" name="roll" id="roll" class="form-control" value="<?php echo $student['roll']; ?>">
                        <br>
                        <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    </form>
                    
                </div>
            </div>
        <?php 
                endif; 
            endif; 
        ?>

    </div>
        

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- <script src="assets/script.js" type="text/javascript"></script> -->
    <script src="assets/js/script.js" type="text/javascript"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

    <!-- <script src="crud/assets/js/script.js"></script> -->
    <!-- D:/Programming/PHP/Master-in-PHP/CRUD-Product-2/crud/assets/js/ -->
  </body>

</html>