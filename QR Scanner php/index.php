<?php session_start();?>
<html>
    <head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>GenQ Scan</title>
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta name="viewport" content="width=device-width, initial-scale=1">

		<script type="text/javascript" src="js/instascan.min.js"></script>
		<!-- DataTables -->
		<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
		<style>
		#divvideo{
			 box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, 0.1);
		}
		</style>
    </head>
    <body >
        <nav class="navbar" style="background:rgb(244, 141, 23)">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <a class="navbar-brand" href="#" style="color: #fff"> <i class="glyphicon glyphicon-qrcode"></i> GenQ Scan</a>
			</div>
		<ul class="nav navbar-nav">
			  <li class="active"><a href="#" style="color: #fff" onMouseOver="this.style.background='black'"  onMouseOut="this.style.background='rgb(244, 141, 23)'"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" onMouseOver="this.style.background='black'"  onMouseOut="this.style.background='rgb(244, 141, 23)'" style="color: #fff"><span class="glyphicon glyphicon-cog"></span> Maintenance <span class="caret"></span></a>
				<ul class="dropdown-menu">
				  <li><a href="#" ><span class="glyphicon glyphicon-user"></span> Student</a></li>
				  <li><a href="#" ><span class="glyphicon glyphicon-plus-sign"></span> New Student</a></li>
				  <li><a href="attendance.php" ><span class="glyphicon glyphicon-calendar"></span> Entry</a></li>

				</ul>
			  </li>
			  <li><a href="#" style="color: #fff" onMouseOver="this.style.background='black'"  onMouseOut="this.style.background='rgb(244, 141, 23)'"><span class="glyphicon glyphicon-align-justify"></span> Reports</a></li>
			  <li><a href="#" style="color: #fff" onMouseOver="this.style.background='black'"  onMouseOut="this.style.background='rgb(244, 141, 23)'"><span class="glyphicon glyphicon-time"></span> Check Logs</a></li>
			  <li><a href="review.php" style="color: #fff"  onMouseOver="this.style.background='black'"  onMouseOut="this.style.background='rgb(244, 141, 23)'"><span class="glyphicon glyphicon-time"></span> Feedback</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			  <!--<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>-->
			  <li><a href="#" style="color: #fff" onMouseOver="this.style.background='black'"  onMouseOut="this.style.background='rgb(244, 141, 23)'"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			</ul>
		  </div>
		</nav>
       <div class="container">
            <div class="row">
                <div class="col-md-4" style="padding:10px;background:#5a5953;border-radius: 5px;" id="divvideo">
					<center><p class="login-box-msg" style="color:rgb(244, 141, 23)"> <i class="glyphicon glyphicon-camera"></i> GenQ</p></center>
                    <video id="preview" width="100%" height="50%" style="border-radius:10px;"></video>
					<br>
					<br>
					<?php
					if(isset($_SESSION['error'])){
					  echo "
						<div class='alert alert-danger alert-dismissible' style='background:red;color:#fff'>
						  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						  <h4><i class='icon fa fa-warning'></i> Error!</h4>
						  ".$_SESSION['error']."
						</div>
					  ";
					  unset($_SESSION['error']);
					}
					if(isset($_SESSION['success'])){
					  echo "
						<div class='alert alert-success alert-dismissible' style='background:green;color:#fff'>
						  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						  <h4><i class='icon fa fa-check'></i> Success!</h4>
						  ".$_SESSION['success']."
						</div>
					  ";
					  unset($_SESSION['success']);
					}
				  ?>

                </div>
				
                <div class="col-md-8" >
                <form action="insert.php" method="post" class="form-horizontal" style="border-radius: 5px;padding:10px;background:#5a5953;" id="divvideo" >
                     <i style="color:rgb(244, 141, 23)" class="glyphicon glyphicon-qrcode"></i> <label style="color:rgb(244, 141, 23)">SCAN QR CODE</label> <p id="time"></p>
                    <input type="text" name="text" id="text" placeholder="scan qrcode" class="form-control"   autofocus>
                </form>
				<div style="border-radius: 5px;padding:10px;background:#5a5953;" id="divvideo">
				<table id="example1" class="table table-bordered" >
                    <thead style="color:rgb(244, 141, 23)">
                        <tr style="color:rgb(244, 141, 23);font-weight:bold;">
                            <td>ID</td>
                            <td>STUDENT ID</td>
                            <td>TIME OUT</td>
                            <td>TIME IN</td>
                            <td>LOGDATE</td>
                            <td>STATUS</td>
                        </tr>
                    </thead>
                    <tbody style="color:#fff">
                        <?php
                        $server = "localhost";
                        $username="root";
                        $password="";
                        $dbname="qrcodedb";
                    
                        $conn = new mysqli($server,$username,$password,$dbname);
						$date = date('Y-m-d');
                        if($conn->connect_error){
                            die("Connection failed" .$conn->connect_error);
                        }
                           $sql ="SELECT * FROM table_attendance WHERE DATE(LOGDATE)=CURDATE()";
                           $query = $conn->query($sql);
                           while ($row = $query->fetch_assoc()){
                        ?>
                            <tr>
                                <td><?php echo $row['ID'];?></td>
                                <td><?php echo $row['STUDENTID'];?></td>
                                <td><?php echo $row['TIMEIN'];?></td>
                                <td><?php echo $row['TIMEOUT'];?></td>
                                <td><?php echo $row['LOGDATE'];?></td>
                                <td><?php echo $row['STATUS'];?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                  </table>
				  
                </div>
				
                </div>
				
            </div>
						
        </div>
		<!-- <script>
			function Export()
			{
				var conf = confirm("Please confirm if you wish to proceed in exporting the attendance in to Excel File");
				if(conf == true)
				{
					window.open("export.php",'_blank');
				}
			}
		</script>				 -->
        <script>
           let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
           Instascan.Camera.getCameras().then(function(cameras){
               if(cameras.length > 0 ){
                   scanner.start(cameras[0]);
               } else{
                   alert('No cameras found');
               }

           }).catch(function(e) {
               console.error(e);
           });

           scanner.addListener('scan',function(c){
               document.getElementById('text').value=c;
               document.forms[0].submit();
           });
        </script>
	
		<script type="text/javascript">
		var timestamp = '<?=time();?>';
		function updateTime(){
		  $('#time').html(Date(timestamp));
		  timestamp++;
		}
		$(function(){
		  setInterval(updateTime, 1000);
		});
		</script>
		
		
    </body>
</html>