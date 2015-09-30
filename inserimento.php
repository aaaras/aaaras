<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="css/grafica.css" rel="stylesheet">
		<title>Vota il Prof!</title>
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<link rel="stylesheet" href="css/style.css" />
		
		
		<script type="text/javascript">
		// Select Province e Comuni dalla Regione. 
		function selProvCom(idRegion) {
		  $.get("select_abitativa.php", { regionid: idRegion, requestItems: 'province'}, 
		  function(dataProvince){
			 $("select[id='province']").empty();
			 var options;
			 var arrayProvince = dataProvince.split( '||');
			 for (var i = 1; i < arrayProvince.length; i++) {
				var provincia = arrayProvince[i].split( /,/);
				options += '<option value="' + provincia[0] + '">' + provincia[1] + '</option>';
			 }
			 $("select[id='province']").html(options);
		  });
		}

		</script>
		
	
	</head>
	<body>
		<?php
			include("connessione.php");
			$conn=connessione();
		?>
		
		
		
		<?php
		
			if(isset($_POST['invia']))
			{
					$scuola=$_POST['scuola'];											
					$idscuola=null;															//dopo aver premuto il submit se idscuola è null la scuola non era inserita nel db
					$idscuola=$_POST['selected_id'];
					echo $scuola;
					
					$nome_prof=$_POST['nome'];
					$cognome_prof=$_POST['cognome'];
					
					echo($nome_prof." ".$cognome_prof);
					
					/** inserisce prof tabella prof */
					
					$query="insert into prof(id, nome, cognome) values(null, \"".$nome_prof."\", \"".$cognome_prof."\")";
					$res=$conn->query($query);
					$id_prof=mysql_insert_id;
					
					/** inserisce corrispondenza prof-scuola --> DA METTERE ANCHE ANNO SCOLASTICO??? 
					$query="insert into prof(id, cognome, nome) values(null, \"".$nome_prof."\", \"".$cognome_prof."\")";
					
					*/
			}
			
		?>
		
		
		
		<!-- tab menu a cui vanno aggiunti i link -->
		<ul class="nav nav-tabs" style="background-color:#C7F600;">
		  <li role="presentation" class="active"><a href="#"><img src="immagini/penna-small.png"></a></li>
		  <li role="presentation"><a href="#"><img src="immagini/pagella-small.png"></a></li>
		  <li role="presentation"><a href="#"><img src="immagini/grafico-small.png"></a></li>
		  <li role="presentation"><a href="#"><img src="immagini/blocco-notes-small.png"></a></li>
		</ul>
		
		<div class="container">
			<div class="titolo"> Nuovo professore </div>
			<form name="inserimento" action="#" method="POST">

				
				<!-- input per nome scuola con autocompletamento -->
				<?php
					echo"<div class='input_container'>";
					
					if(isSet($_POST['nome_prof']))
					{
						echo("si set");
						echo("<input type='text' name='nome' class='form-control' placeholder='Nome...' value='".$_POST['nome_prof']."' required>");
						echo("<input type='text' name='cognome' class='form-control' placeholder='Cognome...' value='".$_POST['cognome_prof']."' required>");
						
					}
					else 
					{
						echo("no set");
						echo("<input type='text' name='prof_nome' class='form-control' placeholder='Nome...' required>");
						echo("<input type='text' name='cognome' class='form-control' placeholder='Cognome...' required>");
					}
					
					
					$url = $_SERVER['REQUEST_URI'];						//ottengo l'url
					$id=null;
					if (strpos($url,'tipo')) 								//controllo se ci sono parametri
					{
						$scuola=$_REQUEST['nomescuola'];					//get dei parametri
						$tipo=$_REQUEST['tipo'];
						$prov=$_REQUEST['prov'];
						$id=$_REQUEST['id'];
						$stringa=$tipo.", ".$scuola.", ".$prov;		//stringa da impostare 
						echo"<input type='text' name='scuola' id='scuola_id' class='form-control' value='".$stringa."' placeholder='".$stringa."' onkeyup='autocomplet()' required>";
					}
					else
					{
						echo"<input type='text' name='scuola' id='scuola_id' class='form-control' placeholder='Scuola...' onkeyup='autocomplet()' required>";
					}
					echo"<ul id='lista_scuole_id'></ul></div>";
				
				
					
					//input nascosto per passare id della scuola se già inserita
				
					if($id!=null)
					{
						echo"<input type='hidden' name='selected_id' value=".$id." id='selected_id'/>";
					}
					else
					{
						echo"<input type='hidden' name='selected_id' id='selected_id'/>";
					}
				
				
				
				?>
				
				
				<!-- richiama modal dialog per inserimeto scuola. al momento preferito sviluppare in altro modo 
					
				<div style="width:100%; clear:both;">
					<a href="#" data-toggle="modal" data-target="#scuola" onclick="disabilita()"> <img src="immagini/add-small.png" style="margin-top:5px; float:right"> </a> 
				</div> 
				
				
				-->
				<div style="width:100%; clear:both;">
					<a href="insscuola.php" name="linkscuola"> <img src="immagini/add-small.png" style="margin-top:5px; float:right"> </a> 
				</div> 
				
				
				
				<!-- provincia regione e tipo scuola richieste solo in fase di inserimento scuola -->
				
				<!--
				
				<select name="tipo" id="tipo" class="form-control">
					<?php
						/*$tipo=null;
						if (strpos($url,'scuola')) {
							$tipo=$_REQUEST['tipo'];
						}
						$conn=new mysqli("localhost", "root", "", "votailprof") or die("Error");
						$query="select * from tipi";
						$res=$conn->query($query);
						while($row=$res->fetch_array())
						{
							if($row[0]==$tipo)
							{
								echo "<option value='".$row[0]."' selected>".$row[0]."</option>";
							}
							else
							{
								echo "<option value='".$row[0]."'>".$row[0]."</option>";
							}
						}*/
					?>
				</select>			
				<select id="region" name="regione" class="form-control" onchange="selProvCom(this.value);">
					<?php
						/*$query="select * from regioni";
						$res=$conn->query($query);
						while($row=$res->fetch_array())
						{
							echo "<option value='".$row[0]."'>".$row[0]."</option>";
						}*/
						
					?>
				</select>
				
		
				<select id="province" name="provincia" class="form-control" onchange="selCom(this.value);">
					<?php
						/*$query="select * from province where regione='abruzzo' order by provincia";
						$res=$conn->query($query);
						while($row=$res->fetch_array())
						{
							echo "<option value='".$row[0]."'>".$row[0]."</option>";
						}*/
						
					?>
				</select>
		
				-->
				
			
				
				<select name="materia" id="materia" class="form-control" required>
					<?php
						
						$url = $_SERVER['REQUEST_URI'];						//ottengo l'url
						$id=null;
						if (strpos($url,'materia')) 							//controllo se ci sono parametri
						{								
							$materia=$_REQUEST['materia'];
						}
				
						$query="select materia from materie";
						$res=$conn->query($query);
						while($row=$res->fetch_array())
						{
							if($materia==$row[0])
							{
								echo "<option name='".$row[0]."' selected>".$row[0]."</option>";
							}
							else
							{
								echo "<option name='".$row[0]."'>".$row[0]."</option>";
							}
						}
						
					?>
				</select>
			
				
				<!--link per inserimento materia -->
				
				<div style="width:100%; clear:both;">
					<a href="insmateria.php"> <img src="immagini/add-small.png" style="margin-top:5px; float:right"> </a> 
				</div>
			
				<input type="submit" name="invia" class="btn btn-primary" value='Inserisci'>
			</form>
		</div>
		
	
		<!--questo sarebbe il modal fade richiamato dal link commentato
		
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
			-->
		</div>
		
		
		
		<!--inutile al momento-->
		<script>
		function disabilita() 
		{
			document.getElementById('materia').disabled = true;
			document.getElementById('province').disabled = true;
			document.getElementById('region').disabled = true;
			document.getElementById('tipo').disabled = true;
		}
		</script>
	
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