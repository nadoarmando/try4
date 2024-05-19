<?php
    session_start();
    //صفحة الاتصال بقاعدة البيانات
    require_once "config.php";

    //لتنظيف البيانات
    function test_input ($data)
    {
        $data = trim($data);//remvo whitespace 
        $data = stripslashes ($data);// 
        $data = htmlspecialchars ($data);//converts spciel characters into html entites
        return $data;
    }

    //الاسم
    $pattern = "/^[a-zA-Z ,.'-]+$/";
    //رقم الهاتف
    $pattern3 = "/^[0-9]{11}$/";
    //الرقم القومى
    $pattern4 = "/^[0-9]{14}$/";

    $Name = $Email = $Password = $good = $ConfPassword = $Age = $Town = $Id = $Phone = "";
    $Name_err = $Email_err = $Password_err = $Id_err = $Phone_err = "";



    // POST فحص إذا كانت الطلبات من نوع 
    // if($_SERVER["REQUEST_METHOD"] == "POST")
    if(isset($_POST['sub']))
    {

        $sql="SELECT * FROM users WHERE email='". $_POST["email"] ."';";
        $result = $conn->query($sql);

        // (,.-)التحقق من ان الاسم يحتوي فقط على أحرف و العلامات 
        if (preg_match($pattern, $_POST["name"]))
        {
            //الحصول علي الاسم من الفورم وتنظيفه من اى زيادات
            $Name = test_input($_POST["name"]);
        }else
        {
            $Name_err =  "مسموح فقط بالأحرف والمسافات البيضاء *";
        }

        if (($result->num_rows > 0) )
        {
            $Email_err = "هذا البريد مسجل بالفعل";
            echo "<script>alert('هذا البريد مسجل بالفعل');</script>";
        }else
        {
            if(filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
            {
                //الحصول علي البريد الالكترونى من الفورم وتنظيفة من اى زيادات
                $Email = test_input($_POST["email"]);
            }else
            {
                $Email_err = "تنسيق البريد الإلكتروني غير صالح *";
            }
        }
        

        //  التحقق من ان الرقم القومى يحتوي فقط على ارقام و  مكون من14 رقم 
        if (preg_match($pattern4, $_POST["id"]))
        {
            //الحصول علي الرقم القومى من الفورم وتنظيفة من اى زيادات
            $Id = test_input($_POST["id"]);
        }else
        {
            $Id_err ="من فضلك ادخل رقم القومى صحيحا* ";
        }
        
        //  التحقق من ان رقم الهاتق يحتوي فقط على ارقام و  مكون من11 رقم 
        if (preg_match($pattern3, $_POST["phone"]))
        {
            //الحصول علي رقم الهاتف من الفورم وتنظيفة من اى زيادات
            $Phone = test_input($_POST["phone"]);
        }
        else
        {
            $Phone_err = " من فضلك ادخل رقم هاتف صحيحا*";
        }

        $Password = $_POST["password"];
        $ConfPassword = $_POST["conf-password"];
        $Age = $_POST["age"];
        $Town = $_POST["town"];

        if($Password!=$ConfPassword)
        {
            $Password_err="كلمة المرور غير متطابقة";
        }
        
        //if(empty($name_err)&&empty($id_err)&&empty($phone_err)&&empty($email_err)&&empty($addr_err)&&empty($DR_err))
        //if(isset($name_err)||isset($id_err)||isset($phone_err)||isset($email_err)||isset($addr_err)||isset($DR_err))
        if($Name_err=="" && $Email_err=="" && $Id_err=="" && $Phone_err=="" && $Password_err=="")
        {
            // sql
            $sql="INSERT INTO users (Name, Age , email , Governorate , password , Id , Phone )
            VALUES('". $Name ."', '". $Age ."', '". $Email ."', '" . $Town ."' , '". $Password ."' ,'". $Id ."' , '". $Phone ."')";
            if ($conn->query($sql) === TRUE)
            {
                $good="تم التسجيل بنجاح";
            } 
        }
    }
?>