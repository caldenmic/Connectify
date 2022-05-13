<?php
include("includes/connection.php");

    if(isset($_POST['sign_up'])) {
        $first_name = htmlentities(mysqli_real_escape_string($con, $_POST['firstname']));
        $last_name = htmlentities(mysqli_real_escape_string($con, $_POST['lastname']));
        $email = htmlentities(mysqli_real_escape_string($con, $_POST['email']));
        $pass = htmlentities(mysqli_real_escape_string($con, $_POST['password']));
        $country = htmlentities(mysqli_real_escape_string($con, $_POST['country']));
        $gender = htmlentities(mysqli_real_escape_string($con, $_POST['gender']));
        $birthday = htmlentities(mysqli_real_escape_string($con, $_POST['dob']));
        $status = "verified";
        $posts = "no";
        $newgid = sprintf('%05d', rand(0, 99999));

        $username = strtolower($first_name . "_" . $last_name . " " . $newgid);
        $check_username_query = "select user_name from users2 where user_email='$email'";
        $run_username = mysqli_query($con, $check_username_query);

        if(strlen($pass) < 9) {
            echo "<script>alert('Password should be minimum nine characters')</script>";
            exit();
        }

        $check_email = "select * from users2 where user_email='$email'";
        $run_email = mysqli_query($con, $check_email);

        $check = mysqli_num_rows($run_email);

        if($check == 1) {
            echo "<script>alert('Email already exists')</script>";
            echo "<script>window.open('signup.php', '_self')</script>";
            exit();
        }

        $rand = rand(1, 3);

            if($rand == 1) {
                $profile_pic = "img1.png";
            }
            else if($rand == 2) {
                $profile_pic = "img2.png";
            }
            else {
                $profile_pic = "img3.png";
            }

            $insert = "insert into users2 (f_name, l_name, user_name, 
            describe_user, Relationship, user_pass, user_email, 
            user_country, user_gender, user_birthday, user_image, 
            user_cover, user_reg_date, status, posts, recovery_account)
            values ('$first_name', '$last_name', '$username',
            'Im active', '----', '$pass', '$email', '$country', 
            '$gender', '$birthday', '$profile_pic', 'default.jpg', 
            NOW(), '$status', '$posts', '')";

            $trigger = "create trigger t before insert on users2 for each row set NEW.recovery_account = 'recovery123'";
            mysqli_query($con, $trigger);
            
            $query = mysqli_query($con, $insert);

            if($query) {
                echo "<script>alert('$first_name you are signed in successfully')</script>";
                echo "<script>window.open('signin.php', '_self')</script>";
                
            }
            else {
                echo "<script>alert('Registration failed: please try again')</script>";
                echo "<script>window.open('signup.php', '_self')</script>";
            }
    }

?>