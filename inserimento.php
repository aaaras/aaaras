<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="css/grafica.css" rel="stylesheet">
		<title>Vota il Prof!</title>
	</head>
	<body>
		<?php
			include("connessione.php");
			$conn=connessione();
		?>
		<ul class="nav nav-tabs" style="background-color:#C7F600;">
		  <li role="presentation" class="active"><a href="#"><img src="immagini/penna-small.png"></a></li>
		  <li role="presentation"><a href="#"><img src="immagini/pagella-small.png"></a></li>
		  <li role="presentation"><a href="#"><img src="immagini/grafico-small.png"></a></li>
		  <li role="presentation"><a href="#"><img src="immagini/blocco-notes-small.png"></a></li>
		</ul>
		
		<div class="container">
			<div class="titolo"> Nuovo professore </div>
			<form name="inserimento" action="" method="POST">
				<input type="text" name="nome" class="form-control" placeholder="Nome..." required>
				<input type="text" name="cognome" class="form-control" placeholder="Cognome..." required>	
				<input type="text" name="scuola" class="form-control" placeholder="Scuola..." required>
				<!-- <div style="width:100%; clear:both;">
					<a href="login.php"> <img src="immagini/add-small.png" style="margin-top:5px; float:right"> </a> 
				</div> -->
				<select name="regione" class="form-control">
					<?php
						$conn=new mysqli("localhost", "root", "", "votailprof") or die("Error");
						$query="select * from regioni";
						$res=$conn->query($query);
						while($row=$res->fetch_array())
						{
							echo "<option name='".$row[0]."'>".$row[0]."</option>";
						}
						
					?>
				</select>
				<select name="provincia" class="form-control">
				<?php
						/*http://www.mrwebmaster.it/ajax/select-dinamiche-jquery-php_7478_3.html*/
						/*$query="select * from province where regione=";
						$res=$conn->query($query);
						while($row=$res->fetch_array())
						{
							echo "<option name='".$row[0]."'>".$row[0]."</option>";
						}*/
						
					?>
				</select>
				<select name="materia" class="form-control" required>
					<?php
						$query="select materia from materie";
						$res=$conn->query($query);
						while($row=$res->fetch_array())
						{
							echo "<option name='".$row[0]."'>".$row[0]."</option>";
						}
						
					?>
				</select>
			
				<input type="submit" name="invia" class="btn btn-primary" value='Inserisci'>
			</form>
		</div>
		
		
		
		<script src="http://code.jquery.com/jquery.js"></script>
	 	<script src="bootstrap/js/bootstrap.min.js"></script>
	 	<script type="text/javascript" src="nivo/jquery-1.4.3.min.js"></script>
		<script type="text/javascript" src="nivo/jquery.nivo.slider.js"></script>
	</body>

</html>




<!--
<div class="input-group input-group-lg">
					<span class="input-group-addon" style="background-color:#0633AE" id="sizing-addon1"></span>					<input type="password" class="form-control" placeholder="Cognome" aria-describedby="sizing-addon1" required>
				</div>
				<br>
				<div class="input-group input-group-lg">
					<span class="input-group-addon" style="background-color:#0633AE" id="sizing-addon1"></span>
					<input type="password" class="form-control" placeholder="Scuola" aria-describedby="sizing-addon1" required>
				</div>
				<div style="width:100%; clear:both;">
					<a href="login.php"> <img src="immagini/add-small.png" style="margin-top:5px; float:right"> </a>
				</div>
				
				-->