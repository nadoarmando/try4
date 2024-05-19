<?php
    require "config.php";
    function printError($errors, $field)
    {
        if (isset($errors[$field])) {
            echo '<span style="color: red;">' . $errors[$field] . '</span>';
        }
    }
    $errors = [];
    $firstName = $lastName = $idNumber = $gmail = $eventName = $tel ="";
    if (isset($_POST["submit"])) 
    {
        $firstName = $_POST['fname'];
        $lastName = $_POST['lname'];
        $idNumber = $_POST['id-number'];
        $gmail = $_POST['gmail'];
        $eventName = $_POST['muname'];
        $tel = $_POST['tel'];
        


        // *******Name Validation*******//   

        if (empty($firstName)) {
            $errors[$firstName] = "* يرجى ملء جميع حقول البيانات المطلوبة ";
        } else if (!empty($firstName) && !preg_match('/^[a-zA-Z\s]+$/', $firstName)) {
            $errors[$firstName] = "* من فضلك ادخل الاسم صحيح ولا يحتوي علي ارقام او علامات مميزة";
        }
        if (empty($lastName)) {
            $errors[$lastName] = "* يرجى ملء جميع حقول البيانات المطلوبة ";
        } else if (!empty($lastName) && !preg_match('/^[a-zA-Z\s]+$/', $lastName)) {
            $errors[$lastName] = "* من فضلك ادخل الاسم صحيح ولا يحتوي علي ارقام او علامات مميزة";
        }


        // *******Gmail Validation*******//
        if (empty($gmail)) {
            $errors[$gmail] = "* يرجى ملء جميع حقول البيانات المطلوبة ";
        } else if (!empty($gmail) && !filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
            $errors[$gmail] = "* من فضلك ادخل بريد الكتروني صالح الاستخدام ";
        }
        // *******ID Validation*******//
        if (empty($idNumber)) 
        {
            $errors[$idNumber] = "* يرجى ملء جميع حقول البيانات المطلوبة ";
        } else if (!empty($idNumber) && !ctype_digit($idNumber) or strlen($idNumber) != 14) {
            $errors[$idNumber] = "* من فضلك ادخل رقم قومي صحيح مكون من 14 رقم ";
        }
        // *******Phone Number Validation*******//
        if (empty($tel)) {
            $errors[$tel] = "* يرجى ملء جميع حقول البيانات المطلوبة ";
        } else if (!empty($tel) && (!ctype_digit($tel) or strlen($tel) != 11 or (substr($tel, 0, 3) != '010' && substr($tel, 0, 3) != '011' && substr($tel, 0, 3) != '012' && substr($tel, 0, 3) != '015'))) {
            $errors[$tel] = "* من فضلك ادخل رقم هاتف مصري صحيح مكون من 11 رقم ";
        }
                // *******Event Name Validation*******//
        if ($eventName == '') {
            $errors[$eventName] = "* يرجى ملء جميع حقول البيانات المطلوبة ";
        }
        //check if an event is reserved before 
        else if ($eventName != '') 
        {
            $sql = "SELECT *FROM event WHERE id ='$idNumber' AND event_name='$eventName'";
            $result = mysqli_query($conn, $sql);

            $rowcount = mysqli_num_rows($result);
            if ($rowcount > 0) 
            {
                $errors[$eventName] = "* هذا الحدث تم حجزه بنفس الرقم القومي من قبل";
                echo "<script>alert('هذا الحدث تم حجزه بنفس الرقم القومي من قبل');</script>";
            }
        }
        //////**Print ERRORS //////////*/
        if (empty($errors)) 
        {
            $sql = "INSERT INTO event (	Fname ,	Lname ,id  ,phone_num ,email ,event_name) VALUES(?,?,?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            $preparestmt = mysqli_stmt_prepare($stmt, $sql);
            if ($preparestmt) {
                mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $idNumber, $tel, $gmail, $eventName);
                mysqli_stmt_execute($stmt);
                echo "<script>alert('تم الحجز بنجاح');</script>";
            }
        }

    }  
?>
  
     
    

