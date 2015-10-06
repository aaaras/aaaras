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
		
			session_start();
		
			include("connessione.php");
			$conn=connessione();
		?>
		
		
		
		<?php
		
			if(isset($_POST['invia']))
			{			
				$scuola=$_POST['scuola'];											
				$idscuola=null;																					//dopo aver premuto il submit se idscuola è null la scuola non era inserita nel db
				$idscuola=$_POST['selected_id'];
				
				$nome_prof=$_POST['nome'];
				$cognome_prof=$_POST['cognome'];
				$materia=$_POST['materia'];
				
				if($idscuola!=null)
				{
					$query="	select 		prof.nome, prof.cognome, scuole.nome, prof_materie.materia, prof.id
									from 		prof, prof_scuole, prof_materie, scuole
									where 	prof.nome=\"".$nome_prof."\" 
												and cognome=\"".$cognome_prof."\" 
												and prof.id=prof_scuole.idProf
												and prof_scuole.idScuola=idScuola
												and prof_scuole.idScuola=scuole.id
												and prof_materie.idProf=prof.id";
				
					$res=$conn->query($query);
					if($res->num_rows==0)
					{
						$query="insert into prof(id, nome, cognome, inserito, eliminato) values(null, \"".$nome_prof."\", \"".$cognome_prof."\", null, 0)";			//aggiungere id di utente che ha inserito
						$res=$conn->query($query);
						$id=$conn->insert_id;
						$query="insert into prof_materie (idProf, materia) values (\"".$id."\", \"".$materia."\")";
						$res=$conn->query($query);
						
						$query="insert into prof_scuole (idProf, idScuola, annoScolastico) values (\"".$id."\", \"".$idscuola."\", \"0\")";
						$res=$conn->query($query);
						
					}
					else
					{
						$i=0;
						$trovato=0;
						while($row=$res->fetch_array())
						{
							$materie[$i]=$row[3];
							if($materie[$i]==$materia)
							{
								$trovato=1;
							}
							$i=$i+1;
							$id=$row[4];
						}
						
						
						if($trovato==0)
						{
							for($i=0; $i<count($materie); $i=$i+1)
							{
								//echo $materie[$i]."<br>";
								//il professore insegna più materie
								//con alert chiedere se si vuole collegare una nuova materia
							}
							$query="insert into prof_materie (idProf, materia) values (\"".$id."\", \"".$materia."\")";
							$res=$conn->query($query);
							
						}
						else
						{
							echo "
								<script type='text/javascript'>
								alert('Professore già inserito');
								</script>";
						}
					}
				}
				else
				{
					echo "
					<script type='text/javascript'>
					alert('La scuola scelta non è stata inserita da alcun utente. Inserire la scuola');
					</script>";
				}
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

				
				
				<?php
					
					$url = $_SERVER['REQUEST_URI'];																//ottengo l'url
					$id=null;
							
					echo"<div class='input_container'>";
				
					if (strpos($url,'nomeProf') && $_REQUEST['nomeProf']!="" && $_REQUEST['cognome']!="") 																	//controllo se ci sono parametri per nome e cognome prof
					{
						$nomeProf=$_REQUEST['nomeProf'];															//get di parametri professore
						$cognomeProf=$_REQUEST['cognome'];
					
						echo"<input type='text' id='nome' name='nome' class='form-control' placeholder='".$nomeProf."' value='".$nomeProf."' required>";
						echo"<input type='text' id='cognome' name='cognome' class='form-control' placeholder='".$cognomeProf."' value='".$cognomeProf."' required>";
					}
					else
					{
						echo"<input type='text' id='nome' name='nome' class='form-control' placeholder='Nome...' required>";
						echo"<input type='text' id='cognome' name='cognome' class='form-control' placeholder='Cognome...' required>";
					}
					
					
					
					/*input per nome scuola con autocompletamento */
					
					if (strpos($url,'tipo')) 																		//controllo se ci sono parametri
					{
						$scuola=$_REQUEST['nomescuola'];															//get dei parametri di scuola
						$tipo=$_REQUEST['tipo'];
						$prov=$_REQUEST['prov'];
						$id=$_REQUEST['id'];
						$stringa=$tipo.", ".$scuola.", ".$prov;												//stringa da impostare 
						echo"<input type='text' name='scuola' id='scuola_id' class='form-control' value='".$stringa."' placeholder='".$stringa."' onkeyup='autocomplet()' required>";
					}
					else
					{
						if (strpos($url,'idScuola'))
						{
							$id=$_REQUEST['idScuola'];
							$stringa=$_REQUEST['scuola'];
							echo"<input type='text' name='scuola' id='scuola_id' class='form-control' value='".$stringa."' placeholder='".$stringa."' onkeyup='autocomplet()' required>";
						}
						else
						{
							echo"<input type='text' name='scuola' id='scuola_id' class='form-control' placeholder='Scuola...' onkeyup='autocomplet()' required>";
						}
						
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
				
				<div style="width:100%; clear:both;">
					<button name="linkscuola" onclick="getDatiPerScuola()"> <img src="immagini/add-small.png" style="margin-top:5px; float:right"> </button> 
				</div> 
	

				<select name="materia" id="materia" class="form-control" required>
					<?php

						if (strpos($url,'materia')) 												//controllo se ci sono parametri per materia
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
					<button name="linkmateria" onclick="getDatiPerMateria()"> <img src="immagini/add-small.png" style="margin-top:5px; float:right"> </button> 
				</div>
			
				<input type="submit" name="invia" class="btn btn-primary" value='Inserisci'>
			</form>
		</div>
		
	
		
		</div>
		

		
		
		

		<script>
		function getDatiPerScuola()
		{
			var nome=document.getElementById("nome").value;
			var cognome=document.getElementById("cognome").value;
			selects=document.getElementById("materia");
			var materia=selects.options[selects.selectedIndex].text;
			window.location.href = "insscuola.php?nome="+nome+"&cognome="+cognome+"&materia="+materia;
		}
		</script>
		
	
		<script>
		function getDatiPerMateria()
		{
			event.preventDefault();
			var nome=document.getElementById("nome").value;
			var cognome=document.getElementById("cognome").value;
			var idScuola=document.getElementById("selected_id").value;
			var scuola=document.getElementById("scuola_id").value;			
			window.location.href = "insmateria.php?nome="+nome+"&cognome="+cognome+"&id="+idScuola+"&scuola="+scuola;
		}
		</script>
	
	
		<script src="http://code.jquery.com/jquery.js"></script>
	 	<script src="bootstrap/js/bootstrap.min.js"></script>
	 	<script type="text/javascript" src="nivo/jquery-1.4.3.min.js"></script>
		<script type="text/javascript" src="nivo/jquery.nivo.slider.js"></script>
	</body>

</html>


