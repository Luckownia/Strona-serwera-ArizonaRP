<?php
  if(isset($_POST["reset-password-submit"])){
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];
     
    if (empty($password) || empty($passwordRepeat)){
        header("createNewPassword.php?newpwd=empty");
        exit();
    } else if ($password != $passwordRepeat){
        header("createNewPassword.php?newpwd=pwdnotsame");
        exit();
    }

    $currentDate = date("U");
    require 'database.php';

    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "blad";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_fetch_assoc($result)){
          echo "Spróbuj ponownie";
          exit();
        } else{

            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

            if($tokenCheck === false){
                echo "Spróbuj ponownie";
                exit();
            } else if($tokenCheck === true){

                $tokenEmail = $row['pwdResetEmail'];

                $sql = "SELECT * FROM users WHERE email=?;";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "blad";
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if(!$row = mysqli_fetch_assoc($result)){
                        echo "Błąd";
                        exit();
                    } else{
                        $sql = "UPDATE users SET password=? WHERE email=?";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            echo "błąd";
                            exit();
                        } else{
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                             echo "blad";
                             exit();
                            }else{
                              mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                              mysqli_stmt_execute($stmt);
                              header("Location: login.php?newpwd=passwordupdated");
                             }
                        }
                    }
                }
            }
        }
    }



  }else{
    header("login.php");
  }


?>