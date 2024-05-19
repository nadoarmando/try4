<?php

    //صفحة الاتصال بقاعدة البيانات
    require_once 'config.php';
   // include('mt_rand.php'); 
    
        //دلة لتنظيف البيانات
        function test_input ($data)
        {
            $data = trim($data);
            $data = stripslashes ($data); 
            $data = htmlspecialchars ($data);
            return $data;
        }
        // start code regist
       
    
    $fname=$lname=$ycolleg=$email=$phone=$nation_id=$birthdate=$msg=$inter_date=$inter_result="";
    $fname_err= $lname_err=$ycolleg_err = $email_err =$phone_err =$nation_id_err ="";
    if(isset($_POST['Registeration'])){
        if (preg_match("/^[a-zA-Z ,.'-]+$/", $_POST["fname"]))
                {
                    //الحصول علي الاسم من الفورم وتنظيفه من اى زيادات
                    $fname = test_input($_POST["fname"]);
                }else
                {
                    $fname_err =  "مسموح فقط بالأحرف والمسافات البيضاء *";
                }
        
        if (preg_match("/^[a-zA-Z ,.'-]+$/", $_POST["lname"]))
            {
                //الحصول علي الاسم من الفورم وتنظيفه من اى زيادات
                $lname = test_input($_POST["lname"]);
            }else
            {
                $lname_err =  "مسموح فقط بالأحرف والمسافات البيضاء *";
            }
        
        if (preg_match("/^[a-zA-Z ,.'-]+$/", $_POST["YourCollege"]))
            {
                //الحصول علي الاسم من الفورم وتنظيفه من اى زيادات
                $ycolleg= test_input($_POST["YourCollege"]);
            }else
            {
                $ycolleg_err = "من فضلك ادخل المؤهل صحيح و لا يحتوى علي ارقام او علامات مميزة";
            }
        
        if(filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
            {
                //الحصول علي البريد الالكترونى من الفورم وتنظيفة من اى زيادات
                $email = test_input($_POST["email"]);
            }else
            {
                $email_err = "تنسيق البريد الإلكتروني غير صالح *";
            }
        
        //  التحقق من ان رقم الهاتق يحتوي فقط على ارقام و  مكون من11 رقم 
        if (preg_match("/^[0-9]{11}$/", $_POST["phone"]))
            {
                //الحصول علي رقم الهاتف من الفورم وتنظيفة من اى زيادات
                $phone = test_input($_POST["phone"]);
            }
            else
            {
                $phone_err = " من فضلك ادخل رقم هاتف صحيحا*";
            }
            
        
        //  التحقق من ان الرقم القومى يحتوي فقط على ارقام و  مكون من14 رقم 
        if (preg_match("/^[0-9]{14}$/", $_POST["id"]))
            {
                //الحصول علي الرقم القومى من الفورم وتنظيفة من اى زيادات
                $nation_id = test_input($_POST["id"]);
            }else
            {
                $nation_id_err = "من فضلك ادخل رقم القومى صحيحا* ";
            }
            //  enter the birthday 
        $birthdate=$_POST["start"];
        
        $inter_result=mt_rand(0,1);

    
        $minTimestamp = strtotime('today'); // Today's date
        $maxTimestamp = strtotime('+1 month'); // 10 years from today

        $randomTimestamp = mt_rand($minTimestamp, $maxTimestamp);
        $inter_date = date('Y-m-d', $randomTimestamp);



       
    
        $sql="select id from jobs where id='$nation_id'";
        $sql1="select email from jobs where email='$email'";
        $result = $conn->query($sql);
        $result1 = $conn->query($sql1);
        if($result->num_rows > 0)
        {
            echo "<script>alert('Nation id already exist with another account. Please try with other nation id');</script>";
        }else if($result1->num_rows > 0)
        {
            echo "<script>alert('This Email  already exist with another account. Please try with other email');</script>";
        }
        
        else{
            if($fname!=""&&$lname!=""&&$ycolleg!=""&&
            $email!=""&&$phone!=""&&$nation_id!="")
            {
                $msg="INSERT INTO jobs (Fname,Lname,Educational_Qualification,email,phone_num,id,date_of_birth,interview_date,result)
                VALUES('". $fname ."', '". $lname ."', '". $ycolleg ."', '" .$email ."' ,
                '". $phone ."' ,'".$nation_id."',' ". $birthdate ."',' ". $inter_date ."',' ". $inter_result ."')";
                $conn->query($msg);
            }
        }
        if($msg)
        {
            echo "<script>alert('تم التسجيل بنجاح');</script>";
            echo "<script type='text/javascript'> document.location = 'المرشدين.php'; </script>";
        }
    }
    
    // end code regist
    // ****************************************










    // start code interview
    if(isset($_POST['search_interview'])){
    
        $Sname=$Snation="";
        $Sname_err=$Snation_err="";
        if (preg_match("/^[a-zA-Z ,.'-]+$/", $_POST["sname"]))
        {
            //الحصول علي الاسم من الفورم وتنظيفه من اى زيادات
            $Sname = test_input($_POST["sname"]);
        }else
        {
            $Sname_err = "من فضلك ادخل الاسم صحيح و لا يحتوى علي ارقام او علامات مميزة";
        }
        
        //  التحقق من ان الرقم القومى يحتوي فقط على ارقام و  مكون من14 رقم 
        if (preg_match("/^[0-9]{14}$/", $_POST["sid"]))
        {
            //الحصول علي الرقم القومى من الفورم وتنظيفة من اى زيادات
            $Snation = test_input($_POST["sid"]);
        }else
        {
            $Snation_err = "من فضلك ادخل رقم قومى صحيح مكون من 14 رقم";
        }
        
        //استخراج البيانات من قاعدة البيانات 
        $sql = "SELECT * FROM  jobs WHERE id = '".$Snation."' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            if( $row["Fname"]." ".$row["Lname"]!=$Sname){
                //التاكد من ان هناك بيانات باسم هذا 
                $Sname_err = "name is not correct";
            }else{
                $xx=$row["interview_date"];
                echo "<script>alert('موعد المقابلة الخاص بك يوم $xx');</script>";
                echo "<script type='text/javascript'> document.location = 'المرشدين.php'; </script>";
             }
        }else
        {
           // $err="لا توجد نتائج لهذه البيانات";
            if($Snation_err==""&& $Sname_err=="")
            echo "<script>alert('لا توجد نتائج لهذه البيانات');</script>";
        }
    
    
    }
    // end code interview
    // *************************************


    
    // start code requst
    if(isset($_POST['requst'])){
    
        $Rname=$Rnation="";
        $Rname_err=$Rnation_err="";
        if (preg_match("/^[a-zA-Z ,.'-]+$/", $_POST["rname"]))
        {
            //الحصول علي الاسم من الفورم وتنظيفه من اى زيادات
            $Rname = test_input($_POST["rname"]);
        }else
        {
            $Rname_err = "من فضلك ادخل الاسم صحيح و لا يحتوى علي ارقام او علامات مميزة";
        }
        
        //  التحقق من ان الرقم القومى يحتوي فقط على ارقام و  مكون من14 رقم 
        if (preg_match("/^[0-9]{14}$/", $_POST["rid"]))
        {
            //الحصول علي الرقم القومى من الفورم وتنظيفة من اى زيادات
            $Rnation = test_input($_POST["rid"]);
        }else
        {
            $Rnation_err = "من فضلك ادخل رقم قومى صحيح مكون من 14 رقم";
        }
        //استخراج البيانات من قاعدة البيانات 
        $sql = "SELECT * FROM  jobs WHERE id = '".$Rnation."' ";
        $result = $conn->query($sql);
        //التاكد من ان هناك بيانات باسم هذا الدكتور
        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            if( $row["Fname"]." ".$row["Lname"]!=$Rname){
                //التاكد من ان هناك بيانات باسم هذا 
                $Rname_err = "name is not correct";
            }else{

                $xx2=$row["result"];
                if($xx2==0)
                {
                    echo "<script>alert('حظ اوفر فى المره القادمة');</script>";
                    echo "<script type='text/javascript'> document.location = 'المرشدين.php'; </script>";
                }else
                {
                    echo "<script>alert('استعد للرحلة جديدة معنا');</script>";
                    echo "<script type='text/javascript'> document.location = 'المرشدين.php'; </script>";
                }
               
            }
        }else
        {
           // $err="لا توجد نتائج لهذه البيانات";
            if($Rnation_err==""&& $Rname_err=="")
            echo "<script>alert('لا توجد نتائج لهذه البيانات');</script>";
        }
        
        }
    // end code requst
    
        