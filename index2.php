<?php 
    
    if(isset($_GET['submitbtn'])){
        // echo "yes";
        $conn = mysqli_connect('localhost','root','','ecomm_db');



        $email = mysqli_real_escape_string($conn, $_GET['email']);
        $password = mysqli_real_escape_string($conn, $_GET['password']);
        $sql = "SELECT salt FROM users_tbl WHERE email='$email'";

        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_row($result);

     
        $salt = @$row[0]; 
    

       $hash_pass = hash('sha512', $salt.$salt.$password.$salt);

      
        $sql = "SELECT * FROM users_tbl WHERE email='$email' AND password='$hash_pass'";

        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $row = mysqli_fetch_row($result);

        //var_dump($row);

        if(empty($row)){
       
            echo 'Invalid email and password';
        }else{
          
            header('Location:welcome.php');
            exit();
        }
   
        mysqli_close($conn);
    }
?>
  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="row">
        <div class="col-6 offset-3">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
                <h1 class="text-center mt-5">Login System</h1>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <button type="submit" name="submitbtn" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>