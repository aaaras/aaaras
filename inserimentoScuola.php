<?php
	$provincia=$_POST['prov'];
	$tipo=$_POST['tipo'];
	$nomescuola=$_POST['nome'];

	$conn=new mysqli("localhost", "root", "", "votailprof") or die("Error");
	$query="select * from scuole where nome='".$nomescuola."' and tipo='".$tipo."' and provincia='".$provincia."'";
	$return=-1;
	$res=$conn->query($query);
	if($res->num_rows==0)
	{
		//aggiungere codice utente una volta che si è autenticato
		$query="insert into scuole(id, nome, provincia, tipo, inserito) values(null, \"".$nomescuola."\", \"".$provincia."\", \"".$tipo."\", \"1\")";
		$res=$conn->query($query);
		$return=mysql_insert_id;					//ritorna id dell'ultima tupla inserita
		//inserire controllo con affected rows
		
	}


	 
	 print_r($return);

?>
				