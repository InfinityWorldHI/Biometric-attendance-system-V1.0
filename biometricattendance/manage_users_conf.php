<?php  
//Connect to database
require'connectDB.php';

// select passenger 
if (isset($_GET['select'])) {

    $Finger_id = $_GET['Finger_id'];

    $sql = "SELECT fingerprint_select FROM users WHERE fingerprint_select=1";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select";
        exit();
    }
    else{
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            $sql="UPDATE users SET fingerprint_select=0";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_Select";
                exit();
            }
            else{
                mysqli_stmt_execute($result);

                $sql="UPDATE users SET fingerprint_select=1 WHERE fingerprint_id=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_select_Fingerprint";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "s", $Finger_id);
                    mysqli_stmt_execute($result);

                    echo "User Fingerprint selected";
                    exit();
                }
            }
        }
        else{
            $sql="UPDATE users SET fingerprint_select=1 WHERE fingerprint_id=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_select_Fingerprint";
                exit();
            }
            else{
                mysqli_stmt_bind_param($result, "s", $Finger_id);
                mysqli_stmt_execute($result);

                echo "User Fingerprint selected";
                exit();
            }
        }
    } 
}
if (isset($_POST['Add'])) {
     
    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email= $_POST['email'];

    //optional
    $Timein = $_POST['timein'];
    $Gender= $_POST['gender'];

    //check if there any selected user
    $sql = "SELECT username FROM users WHERE fingerprint_select=1";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "SQL_Error";
      exit();
    }
    else{
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if (empty($row['username'])) {

                if (!empty($Uname) && !empty($Number) && !empty($Email)) {
                    //check if there any user had already the Serial Number
                    $sql = "SELECT serialnumber FROM users WHERE serialnumber=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "d", $Number);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {
                            $sql="UPDATE users SET username=?, serialnumber=?, gender=?, email=?, user_date=CURDATE(), time_in=? WHERE fingerprint_select=1";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_select_Fingerprint";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "sdsss", $Uname, $Number, $Gender, $Email, $Timein );
                                mysqli_stmt_execute($result);

                                echo "A new User has been added!";
                                exit();
                            }
                        }
                        else {
                            echo "The serial number is already taken!";
                            exit();
                        }
                    }
                }
                else{
                    echo "Empty Fields";
                    exit();
                }
            }
            else{
                echo "This Fingerprint is already added";
                exit();
            }    
        }
        else {
            echo "There's no selected Fingerprint!";
            exit();
        }
    }
}
//Add user Fingerprint
if (isset($_POST['Add_fingerID'])) {

    $fingerid = $_POST['fingerid'];

    if ($fingerid == 0) {
        echo "Enter a Fingerprint ID!";
        exit();
    }
    else{
        if ($fingerid > 0 && $fingerid < 128) {
            $sql = "SELECT fingerprint_id FROM users WHERE fingerprint_id=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
              echo "SQL_Error";
              exit();
            }
            else{
                mysqli_stmt_bind_param($result, "i", $fingerid );
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if (!$row = mysqli_fetch_assoc($resultl)) {

                    $sql = "SELECT add_fingerid FROM users WHERE add_fingerid=1";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                      echo "SQL_Error";
                      exit();
                    }
                    else{
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {
                            $sql = "INSERT INTO users (fingerprint_id, add_fingerid) VALUES (?, 1)";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                              echo "SQL_Error";
                              exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "i", $fingerid );
                                mysqli_stmt_execute($result);
                                echo "The ID is ready to get a new Fingerprint";
                                exit();
                            }
                        }
                        else{
                            echo "You can't add more than one ID each time";
                        }
                    }   
                }
                else{
                    echo "This ID is already exist!";
                    exit();
                }
            }
        }
        else{
            echo "The Fingerprint ID must be between 1 & 127";
            exit();
        }
    }
}
// Update an existance user 
if (isset($_POST['Update'])) {

    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email= $_POST['email'];

    //optional
    $Timein = $_POST['timein'];
    $Gender= $_POST['gender'];

    if ($Number == 0) {
        $Number = -1;
    }
    //check if there any selected user
    $sql = "SELECT * FROM users WHERE fingerprint_select=1";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "SQL_Error";
      exit();
    }
    else{
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if (empty($row['username'])) {
                echo "First, You need to add the User!";
                exit();
            }
            else{
                if (empty($Uname) && empty($Number) && empty($Email) && empty($Timein)) {
                    echo "Empty Fields";
                    exit();
                }
                else{
                    //check if there any user had already the Serial Number
                    $sql = "SELECT serialnumber FROM users WHERE serialnumber=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "d", $Number);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {

                            if (!empty($Uname) && !empty($Email) && !empty($Timein)) {

                                $sql="UPDATE users SET username=?, serialnumber=?, gender=?, email=?, time_in=? WHERE fingerprint_select=1";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    echo "SQL_Error_select_Fingerprint";
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($result, "sdsss", $Uname, $Number, $Gender, $Email, $Timein );
                                    mysqli_stmt_execute($result);

                                    echo "The selected User has been updated!";
                                    exit();
                                }
                            }
                            else{
                                if (!empty($Timein)) {
                                    $sql="UPDATE users SET gender=?, time_in=? WHERE fingerprint_select=1";
                                    $result = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($result, $sql)) {
                                        echo "SQL_Error_select_Fingerprint";
                                        exit();
                                    }
                                    else{
                                        mysqli_stmt_bind_param($result, "ss", $Gender, $Timein );
                                        mysqli_stmt_execute($result);

                                        echo "The selected User has been updated!";
                                        exit();
                                    }
                                }
                                else{
                                    echo "The User Time-In is empty!";
                                    exit();
                                }    
                            }  
                        }
                        else {
                            echo "The serial number is already taken!";
                            exit();
                        }
                    }
                }
            }    
        }
        else {
            echo "There's no selected User to update!";
            exit();
        }
    }
}
// delete user 
if (isset($_POST['delete'])) {

    $sql = "SELECT fingerprint_select FROM users WHERE fingerprint_select=1";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select";
        exit();
    }
    else{
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {
            $sql="UPDATE users SET username='', serialnumber='', gender='', email='', time_in='', del_fingerid=1 WHERE fingerprint_select=1";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_delete";
                exit();
            }
            else{
                mysqli_stmt_execute($result);
                echo "The User Fingerprint has been deleted";
                exit();
            }
        }
        else{
            echo "Select a User to remove";
            exit();
        }
    }
}
?>
