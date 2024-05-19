<?php
    require_once "config.php";
    $fnameErr = $lnameErr = $gmailErr = $idnumberErr = $telErr= "";
    $fname = $lname = $gmail = $idnumber = $date = $tel = $muname = $msg = "";


    if(isset($_POST['ارسال']))
    {
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $idnumber=$_POST['idnumber'];
        $gmail=$_POST['gmail'];
        $date=$_POST['date'];
        $tel=$_POST['tel'];
        $muname=$_POST['muname'];

    
        $sql = "SELECT *FROM places_of_visit WHERE id ='$idnumber' AND 	place='$muname'";
        $result = $conn->query($sql);
        if (($result->num_rows > 0) )
        {
            $idnumberErr = "* هذا المعبد تم حجزه بنفس الرقم القومي من قبل";
            echo "<script>alert('هذا المعبد تم حجزه بنفس الرقم القومي من قبل');</script>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $fname = test_input($_POST["fname"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
                $fnameErr = "مسموح فقط بالأحرف والمسافات البيضاء *" ;
            }

            $lname = test_input($_POST["lname"]);

            if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
                $lnameErr = "مسموح فقط بالأحرف والمسافات البيضاء *"  ;
            }

            $gmail = test_input($_POST["gmail"]);
            if (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
                $gmailErr = "تنسيق البريد الإلكتروني غير صالح *";
            }
            $idnumber = test_input($_POST["idnumber"]);

            if (!preg_match('/^[0-9]{14}+$/', $idnumber)) 
            {
            $idnumberErr ="من فضلك ادخل الرقم القومى صحيحا* ";
        
            }

            $tel = test_input($_POST["tel"]);

            if (!preg_match('/^[0-9]{11}+$/', $tel)) {
                $telErr =" من فضلك ادخل رقم الهاتف صحيحا*";
            }
        }

        if($fnameErr=="" && $lnameErr=="" && $gmailErr=="" && $idnumberErr=="" && $telErr=="")
        {
            $query="INSERT INTO places_of_visit(Fname , Lname , id  , email	 ,date, phone_num , place) 
            VALUES ('$fname' , '$lname' , '$idnumber' , '$gmail' , '$date' , '$tel' , '$muname' )";
    
            if(mysqli_query($conn, $query))
            {
                $msg="تم التسجيل بنجاح";
                echo "<script>alert('تم الحجز بنجاح');</script>";
            } 
            else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }
            mysqli_close($conn);
        }
        
    }

    


?>