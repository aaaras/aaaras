<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="css/grafica.css" rel="stylesheet">
		<title>Vota il Prof!</title>
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<link rel="stylesheet" href="css/style.css" />
</head>
<body>

    <div style="width:100%; clear:both;">
		<a href="#" data-toggle="modal" data-target="#scuola"> <img src="immagini/add-small.png" style="margin-top:5px; float:right"> </a> 
	</div> 


	
	
	
	<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Modal header</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>
  </div>
</div>
	
	
	
	<div id="scuola" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="titolo"> Nuova scuola </div>
					</div>
					<div class="container">
						<div class="col-sm-12 col-xs-12">
							<input type="text" name="scuolains" class="form-control" placeholder="Scuola..." required>
							<select name="tipoins" class="form-control">
							<?php
								/*$conn=new mysqli("localhost", "root", "", "votailprof") or die("Error");
								$query="select * from tipi";
								$res=$conn->query($query);
								while($row=$res->fetch_array())
								{
									echo "<option value='".$row[0]."'>".$row[0]."</option>";
								}*/
							?>
							</select>
						</div>
					</div>
					<div class="modal-footer" id='mailresponsefooter'>
						 <button type="button" data-dismiss="modal" class="btn">Close</button>
	   					 <input type="submit" class="btn btn-primary" value='Send'> 
					</div>
					</form>
				</div>
			</div>

	<?php
		echo"
<script type=\"text/javascript\">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>";


echo" <script type=\"text/javascript\">
        $('#scuola').modal('show');
</script>";




?>






<script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="vendors/easypiechart/jquery.easy-pie-chart.js"></script>
    <script src="assets/scripts.js"></script>


	
	
	
	<script src="http://code.jquery.com/jquery.js"></script>
	 	<script src="bootstrap/js/bootstrap.min.js"></script>
	 	<script type="text/javascript" src="nivo/jquery-1.4.3.min.js"></script>
		<script type="text/javascript" src="nivo/jquery.nivo.slider.js"></script>
	
	
	
</body>
</html>
