<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="css/grafica.css" rel="stylesheet">
		<title>Vota il Prof!</title>
		<script type="text/javascript" src="jquery.js"></script>
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		
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

		<form id="insscuola" action="inserimentoScuola.php" title="" method="post">
			<div class="container">
				<div class="col-sm-12 col-xs-12">
					<div class="titolo"> Nuova scuola </div>		
					
					<?php
						$url = $_SERVER['REQUEST_URI'];						//ottengo l'url
						$id=null;
						if (strpos($url,'nome')) 								//controllo se ci sono parametri
						{
							$nome=$_REQUEST['nome'];							//get dei parametri
							$cognome=$_REQUEST['cognome'];
							$materia=$_REQUEST['materia'];
							
							
							echo"<input type='hidden' id='nome' value='".$nome."'>";
							echo"<input type='hidden' id='cognome' value='".$cognome."'>";
							echo"<input type='hidden' id='materia' value='".$materia."'>";
						}
					
					?>

						<!--input nome scuola-->
						<input type="text" name="scuolains" id="scuola" class="form-control" placeholder="Scuola..." required>
						
						<!--input tipo scuola-->
						<select name="tipoins" id="tipo" class="form-control">
						<?php
							$conn=new mysqli("localhost", "root", "", "votailprof") or die("Error");
							$query="select * from tipi";
							$res=$conn->query($query);
							while($row=$res->fetch_array())
							{
								echo "<option value='".$row[0]."'>".$row[0]."</option>";
							}
						?>
						</select>
						
						<!--input regione-->
						<select id="region" name="regioneins" class="form-control" onchange="selProvCom(this.value);">
							<?php
								$query="select * from regioni";
								$res=$conn->query($query);
								while($row=$res->fetch_array())
								{
									echo "<option value='".$row[0]."'>".$row[0]."</option>";
								}
								
							?>
						</select>
								
						<!--input provincia-->
						<select id="province" name="provinciains" class="form-control">
							<?php
								$query="select * from province where regione='abruzzo' order by provincia";
								$res=$conn->query($query);
								while($row=$res->fetch_array())
								{
									echo "<option value='".$row[0]."'>".$row[0]."</option>";
								}
								
							?>
						</select>
					</div>
				</div>
				<div style="text-align:center">
					<button type="button" data-dismiss="modal" class="btn" onclick="redirect()">Annulla</button>
					<input type="submit" id="submitButton"  name="submitButton" value="Conferma"/>				 
				</div>				
			</div>
		</form>


		<script type='text/javascript'>
			/* attach a submit handler to the form */
			 $("#insscuola").submit(function(event) {

				/* stop form from submitting normally */
				event.preventDefault();
				/* get some values from elements on the page: */
				var $form = $( this ),
					 url = $form.attr( 'action' );

				var selects = document.getElementById("province");
				var provincia = selects.options[selects.selectedIndex].text;
				selects=document.getElementById("tipo");
				var tipo=selects.options[selects.selectedIndex].text;
				var nome=document.getElementById("scuola").value;
				var nomeProf=document.getElementById("nome").value;
				var cognomeProf=document.getElementById("cognome").value;
				var materia=document.getElementById("materia").value;

				//passaggio dei dati a pagina inserimentoScuola.php e poi ritona a inserimento passando parametri via url
				$.post("inserimentoScuola.php", {prov:provincia, tipo:tipo, nome:nome}, function(res){		
						if(res>0)
						{
							//$.post("inserimento.php", {prov:provincia, tipo:tipo, nome:nome, id:res});
							window.location.href = "inserimento.php?prov="+provincia+"&tipo="+tipo+"&nomescuola="+nome+"&id="+res+"&nomeProf="+nomeProf+"&cognome="+cognomeProf+"&materia="+materia;
						}
						else
						{
							alert("Scuola già inserita");
						}
				});
			 });
		</script>
		
		
		<script>
			function redirect()
			{
				var nomeProf=document.getElementById("nome").value;
				var cognomeProf=document.getElementById("cognome").value;
				var materia=document.getElementById("materia").value;
				window.location.href = "inserimento.php?nomeProf="+nomeProf+"&cognome="+cognomeProf+"&materia="+materia;
			}
		</script>
		
		
		<script src="http://code.jquery.com/jquery.js"></script>
	 	<script src="bootstrap/js/bootstrap.min.js"></script> 
	</body>

</html>
