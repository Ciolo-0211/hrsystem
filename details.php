<?php
   session_start();
   include_once("connections/koneksyon.php");
     $con=connection();
        
    if(isset($_POST['empsearch'])){
        $emprec = $_POST['emprec'];
        $sql = "SELECT tblemprecords.emp_id, tblemprecords.firstname,tblemprecords.middlename, tblemprecords.lastname, 
           tblemprecords.DOB,tblemprecords.age,tblemprecords.address,tblrank.rank_desc, tblrank.salary,
           tblrank.dependent,tblrank.datehired FROM tblemprecords 
           INNER JOIN tblrank ON tblemprecords.emp_id = '$emprec'";
        // $sql = "Select * From tblemprecords Where emp_id = '$emprec'";
        $emp_search = $con->query($sql) or die ($con->error);
        $row = $emp_search->fetch_assoc();
        $total = $emp_search->num_rows;
        
        $fname = $row['firstname'];
        $midname = $row['middlename'];
        $lname = $row['lastname'];

        //Compute for the age and update the table
        $bday = new DateTime($row['DOB']); // Your date of birth
        $today = new Datetime(date('m.d.y'));
        $age_diff = $today->diff($bday);
        // printf(' Your age : %d years', $age_diff->y);
        $datehired = new DateTime($row['datehired']);
        $monthdiff = $today->diff($datehired);
        // echo ($monthdiff->y) * 12;
        $sql ="UPDATE tblemprecords 
               SET age = '$age_diff->y' 
               WHERE emp_id = '$emprec'";
        $con->query($sql) or die($con->error);
    
        
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
    </head>
    <body>
        <?php
            if($total > 0){
                $_SESSION['empID'] = $row['emp_id'];
                
                if($row['age']>=56){
                    echo "<h2>" . "CONGRATULATIONS!" . "</h2>";
                    echo "<h3>" . $fname . " " . $midname . " " . $lname ."</h3>";
                    ECHO "You are now eligible for pension" . "<br/>";
    
                    $sql = "Select * From tblrank Where rank_id = '$emprec'";
                    $emp_search = $con->query($sql) or die ($con->error);
                    $row = $emp_search->fetch_assoc();
                    
                    $lumpsum = $row['salary'] * 18;
                    $dependent = $row['dependent'];
                    $tax = 0;
                    echo "Lump Sum Pension: " . "<strong>" .  "&#8369;". number_format($lumpsum,2) . "</strong>";
                    echo "<br/>";
                    if($dependent>=4){
                        $tax = $lumpsum * .10;
                        echo "Your Tax is : ". "<strong>" . "&#8369;" . number_format($tax,2) . "</strong>" . "<br/>"; 
                        $BMP = (($row['salary'] * .025) * ($monthdiff->y * 12)/12);
                        echo "Your Basic Monthly Pension is : "  . "<strong>" .  "&#8369;". number_format($BMP,2) . "</strong>";
                    }else{
                        $tax = $lumpsum * .12;
                        echo "Your Tax is : ". "<strong>" . "&#8369;". number_format($tax,2) . "</strong>" . "<br/>"; 
                        $BMP = (($row['salary'] * .025) * ($monthdiff->y * 12)/12);
                        echo "Your Basic Monthly Pension is : " . "<strong>" .  "&#8369;". number_format($BMP,2) . "</strong>";
                    }
                }else{
                       
                       echo "<h2>You are not yet eligible for a pension.</h2>";
                    }    
                
                // echo $_SESSION['empID']." ". $row['firstname'];
                
            }else{
                echo header("location: index.php");
                // echo "Employee Number does not exist.";
            }   
            }
            
        ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    </body>
    </html>