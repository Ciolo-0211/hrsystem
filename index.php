<?php 
   
   include_once("connections/koneksyon.php");
  
    $con=connection();
    
   if($con->connect_error){
      echo $con->connect_error;
   }
   $sql = "SELECT tblemprecords.emp_id, tblemprecords.firstname,tblemprecords.middlename, tblemprecords.lastname, 
           tblemprecords.DOB,tblemprecords.age,tblemprecords.address,tblrank.rank_desc, tblrank.salary FROM tblemprecords 
           INNER JOIN tblrank ON tblemprecords.emp_id = tblrank.rank_id";
//    $sql = "SELECT * FROM tblemprecords";
   $emp_rec = $con->query($sql) or die($con-error);
   $row = $emp_rec->fetch_assoc();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Records</title>
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <h1>HR System</h1>
    <br/>
    <br/>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Birthday</th>
                <th>Age</th>
                <th>Address</th>
                <th>Position</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <?php do{ ?>
            <tr>
                <td><?php echo $row['emp_id']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['middlename']; ?></td>
                <td><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['DOB']; ?></td>
                <td><?php echo $row['age'] ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['rank_desc']; ?></td>
                <td><?php echo "&#8369;".number_format($row['salary'], 2); ?></td>
            </tr>
            <?php }while($row = $emp_rec->fetch_assoc()) ?>
        </tbody>
    </table>
    <h3>Verify for Pension</h3>
    <div>
        <form action="details.php" method="post">
            <label>Employee Number</label><br/>
            <input type="text" name="emprec" id="emprec" placeholder="ID No.">
            
            <button type="submit" class="btn btn-primary btn-sm" name="empsearch">Search</button>
        </form>
    </div>


 

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
    $('#example').DataTable();
});
</script>
</body>
</html>

