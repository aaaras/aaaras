<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="css/grafica.css" rel="stylesheet">
		<title>Vota il Prof!</title>
		<script type="text/javascript" src="jquery.js"></script>	
	</head>
	<body>
	
		<?php
		
			echo("Dati...");
			
			$nome=$_POST['prof_nome'];
			if(isSet($_POST['nome']))
			{
				$nome=$_POST['nome'];
				echo("Nome prof:".$nome);
			}
			
			if(isSet($_POST['cognome']))
			{
				$cognome=$_POST['cognome'];
				echo($cognome);
			}
		
			/*
			$url = $_SERVER['REQUEST_URI'];						
			$id=null;
			if (strpos($url,'nome')) 							
			{
				$nome=$_POST['nome'];
				echo ("<input type='hidden' name='nome_prof' value'".$nome."'/>");
			}
			
			if (strpos($url,'cognome'))
			{
				$cognome=$_POST['cognome'];
				echo ("<input type='hidden' name='cognome_prof' value'".$cognome."'/>");
			}*/
			
			if(isset($_POST['insmateria']))
			{
				$materia=$_POST['materiains'];
				
				/** nome e cognome del prof da inserire */
				
				
				$conn=new mysqli("localhost", "root", "", "votailprof") or die("Error");
				$query="select * from materie where materia='".$materia."'";
				$res=$conn->query($query);
				
				if($res->num_rows==0)
				{
					//aggiungere codice utente una volta che si è autenticato
					$query="insert into materie(materia, inserito) values(\"".$materia."\", \"1\")";
					$res=$conn->query($query);				
					
					if($conn->affected_rows>0)
					{
						echo"
						<script type='text/javascript'>
							window.location.href = \"inserimento.php?materia=".$materia."\";
						</script>";
						
					}
					
					
				}
				else
				{
					echo "
					<script type='text/javascript'>
					alert('Materia già inserita');
					</script>";
				}
			}
			
		?>
	
	
		<form name="insmateria" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="container">
				<div class="col-sm-12 col-xs-12">
					<div class="titolo"> Nuova materia </div>		
					<input type="text" name="materiains" class="form-control" placeholder="Materia..." required>
				</div>
					<div style="text-align:center">
						<button type="button" data-dismiss="modal" class="btn" onclick="redirect()">Annulla</button>
						<input type="submit" name="insmateria" class="btn btn-primary" value='Conferma'> 
					</div>
			</div>
		</form>

		<script>
			function redirect()
			{
				window.location.href = "inserimento.php";
			}
		</script>

		<script src="http://code.jquery.com/jquery.js"></script>
	 	<script src="bootstrap/js/bootstrap.min.js"></script>
	 	<script type="text/javascript" src="nivo/jquery-1.4.3.min.js"></script>
		<script type="text/javascript" src="nivo/jquery.nivo.slider.js"></script>
	</body>

</html>
