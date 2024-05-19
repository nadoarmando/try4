<?php
    require_once "config.php";
    function clean($data)
    {
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }

    $fname_err=$lname_err=$id_err=$email_err=$date_err=$phone_err=$muname_err="";
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $fname=$_POST['fname'];$lname=$_POST['lname'];$id=$_POST['id-number'];
        $email=$_POST['gmail'];$date=$_POST['date'];$phone=$_POST['tel'];
        $muname=$_POST['muname'];

        $sql = "SELECT *FROM museum WHERE id ='$id' AND museum_name='$muname'";
        $result = $conn->query($sql);
        if (($result->num_rows > 0) )
        {
            $id_err = "* هذا المتحف تم حجزه بنفس الرقم القومي من قبل";
            echo "<script>alert('هذا المتحف تم حجزه بنفس الرقم القومي من قبل');</script>";
        }


        //first name validation
        if (!preg_match("/^[a-zA-Z ]*$/", $fname))
        {
            $fname_err="مسموح فقط بالأحرف والمسافات البيضاء *";
        }
        else 
        {
            $fname=clean($fname);
        }

        //last name validation
        if (!preg_match("/^[a-zA-Z ]*$/", $lname))
        {
            $lname_err="مسموح فقط بالأحرف والمسافات البيضاء *";
        }
        else 
        {
            $lname=clean($lname);
        }

        //id number Validation
        if(!ctype_digit($id))
        {
            $id_err="الرقم القومى يجب ان يحتوى فقط على ارقام *";
        }
        else if(strlen($id)!=14)
        {
            $id_err="من فضلك ادخل الرقم القومى صحيحا* ";
        }
        else 
        {
            $id=clean($id);
        }


        //email validation
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $email_err="تنسيق البريد الإلكتروني غير صالح *";
        }
        else 
        {
            $email=clean($email);
        }
        

        //phone number validation 
        if(!preg_match('/^[0-9]{11}+$/', $phone))
        {
            $phone_err=" من فضلك ادخل رقم الهاتف صحيحا*";
        }
        else 
        {
            $phone=clean($phone);
        }

        $date=clean($date);

        //if all data is valid 
        if($fname_err==""&&$lname_err==""&&$id_err==""&&$email_err==""&&$date_err==""&&$phone_err==""&&$muname_err=="")   
        {
            $sql="INSERT INTO museum (Fname, Lname, id,email,phone_num,date,museum_name)
            VALUES ('". $fname ."', '". $lname ."', '" .$id ."','".$email."','".$phone."','".$date."','".$muname."')";
            if($conn->query($sql)===TRUE)
            {
                echo "<script>alert('تم الحجز بنجاح');</script>";
            }
            else 
            {
                echo "Error: ".$sql."<br>".$conn->error;
            }
            $conn->close();
        }

    }
?>