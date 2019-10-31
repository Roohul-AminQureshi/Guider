 <?php
 date_default_timezone_set("Asia/Colombo");
 $m_id=7;
 
include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/usermodel.php';  //user queries
include '../common/functions.php';

$role_id=$userInfo['role_id'];

$countm= checkModuleRole($m_id, $role_id);

if ($countm==0){ // check user priviledges
   $msg= base64_encode("You dont have permission to access.") ;
   header("Location:../view/login.php?msg=$msg");
   
}

$obuser = new user(); //to create an object

$result=$obuser->viewUserLog();

?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>SOS</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" type="text/css"/>
        <link rel="stylesheet" href="../css/style.css" type="text/css"/>
   
        <link href="../css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="../css/semantic.min.css" rel="stylesheet">
        <link href="../css/dataTables.semanticui.min.css" rel="stylesheet">
        <link href="../css/buttons.semanticui.min.css" rel="stylesheet">
  
      
    
        <script src="../JQuery/jquery-1.12.4.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap4.min.js"></script>

   
        <script src="../js/dataTables.semanticui.min.js"></script>
        <script src="../js/dataTables.buttons.min.js"></script>
        <script src="../js/pdfmake.min.js"></script>
        <script src="../js/vfs_fonts.js"></script>
        <script src="../js/buttons.html5.min.js"></script>
    
        <script src="../js/jszip.min.js"></script>
        <script src="../js/buttons.semanticui.min.js"></script>
    
        <script src="../js/buttons.colVis.min.js"></script>
        <script src="../js/buttons.print.min.js"></script>
    
    <script>
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf','print','csv','colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( $('div.eight.column:eq(0)', table.table().container()) );
    } );
    
    </script>
    
    
    
    </head>
    <body>
        <div id="main">
            <div id="heading">
                <?php include '../common/header.php'; ?>
                <!-- to display name and image beside logout -->
            </div>
            <div id="navi" style="background: #f5f5f5">
                <div class="row">
                    <div class="col-md-4 col-sm-6 paddinga">
                    <img class="style1" src="<?php echo $iname; ?>" />
                    <?php echo $userInfo['role_name']; ?>
                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li><a href="../view/dashboard.php">Dashboard</a></li>
                            <li class="active">User Tracking</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div id="contents">
                <div class="row">
                    
                  
                    <div class="col-md-12 col-sm-6">
                        <h3 class="alig">User Tracking</h3>
                    </div>
                </div>
                
           
                
           
                
                 <div class="row container-fluid">
                    <div class="col-md-12 col-sm-6">
                        <table class=" ui celled table" id="example">
                            <thead>
                                <tr>
                                    <th>Log ID &nbsp;</th>
                                    <th>User Name</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>IP Address</th>
                                    <th>Elapse Time</th>
                                    <th>Status</th>
                               
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row=$result->fetch(PDO::FETCH_BOTH)){ 
                               
                                $st1= strtotime($row['log_in_date']);
                                $st2= strtotime($row['log_out_date']);
                                
                                $date1= date_create($row['log_in_date']);
                               
                                
                            ?>
                            <tr>
                                <td><?php echo $row['log_id']; ?>
                                </td> 
                                
                                <td><?php echo $row['user_fname']." ".$row['user_lname']; ?></td>
                                <td><?php echo $row['log_in_date']; ?></td>
                                <td><?php echo $row['log_out_date']; ?></td>
                                <td><?php echo $row['log_ip']; ?></td>
                                <td>
                                    <?php 
                                        if ($row['log_status']=="logout"){
                                             $date2= date_create($row['log_out_date']);
                                             
                                        }else{
                                             $date2= date_create(date("Y-m-d H:i:s"));
                                             
                                        }
                                        //echo date("Y-m-d H:i:s");
                                         $diff= date_diff($date1, $date2);
                                         $stime=$diff->format("%a").":".$diff->format("%H").":".$diff->format("%I").":".$diff->format("%S");
                                        echo $stime;
                                    ?>
                                </td>
                                <td><?php echo $row['log_status']; ?></td>
                                
                            </tr>
                            <?php } ?>
                            </tbody>                           
                        </table>
                  
                 </div>
                </div>
        </div>
            <div id="footer"> <?php include '../common/footer.php';?> </div>
            
        </div>
    </body>
    
</html>
