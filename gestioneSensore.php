<?php
require("connessione.php");


$marca="";
$tipo="";
$pattern="";
$id_sensore="";


if($_POST["submitVisualizzaSensori"]){
$query = mysql_query("SELECT * FROM sensore");
}


function visualizzaSensori(){
$query = mysql_query("SELECT * FROM sensore");

}




//PREMUTO IL BOTTONE AGGIUNGI SENSORE
if($_POST["submitAggiungiSensore"]){

if(isset($_POST["id_clienteFK"]) && isset($_POST["marca"]) && isset($_POST["tipo"]) ){

$id_clienteFK = $_POST["id_clienteFK"];
$marca = $_POST["marca"];
$tipo = $_POST["tipo"];


if(aggiungiSensore($id_clienteFK, $marca, $tipo/*, $pattern*/)){
echo "<script> alert('sensore aggiunto!'); </script>";
}
else{
echo "<script> alert('Proprietario non esistente!'); </script>";
}

}
}

//PREMUTO IL BOTTONE ELIMINA SENSORE
if($_POST["submitRimuoviSensore"]){

if(isset($_POST["id_sensore"])){
$id_sensore = $_POST["id_sensore"];

if(!rimuoviSensore($id_sensore)){
echo"<script> alert('Sensore non trovato!'); </script>";
}
else{
echo"<script> alert('Sensore rimosso!'); </script>";
}

}
}






function aggiungiSensore($id_clienteFK, $marca, $tipo, $pattern){
$checkcliente = mysql_query("SELECT * FROM utente WHERE id_cliente = '".$id_clienteFK."' ");
if(mysql_num_rows($checkcliente)==0){ return false;}

$query = mysql_query("INSERT INTO sensore (id_clienteFK,marca,tipo) values('".$id_clienteFK."', '".$marca."', '".$tipo."' )") ;
if($query){
return true;
}
}




function rimuoviSensore($id_sensore){

//se esiste lo elimino
if(trovaSensore($id_sensore)){
$query = mysql_query("DELETE FROM sensore WHERE id_sensore = '".$id_sensore."' ");
return true;
}

else {
return false;
}
}



function trovaSensore($id_sensore){
//controllo l'esistenza del cliente
$query = mysql_query("SELECT * FROM sensore WHERE id_sensore = '".$id_sensore."' ");
if(mysql_num_rows($query)>0){
return true;
}
else {
return false;
}
}



?>
<!DOCTYPE html>
<html>
<head>
	<link href="stile.css" rel="stylesheet" type="text/css">
	<meta charset="utf-8" />
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>



<div id="gestioneSensori" align="center">


<h2>Gestione sensori </h2>

<h3>Menu</h3>
<div id="menu" align="center">
<div align="center" style="border: solid 2px #ff7738; border-radius:10px;"><br>
<button class="bottone" onclick="window.location.href='gestioneCliente.php'">Gestione clienti</button>
<button class="bottone" onclick="window.location.href='recuperaDati.php'">Recupera dati</button>
<button class="bottone" onclick="window.location.href='tipoSensore.php'">Inserisci tipo di sensore</button>
<button class="bottone" onclick="window.location.href='logout.php'">Logout</button>
<br><br>
</div>
</div><br><br><br>


<form action="gestioneSensore.php" method="post">
<input type="text" class="casella" name="id_clienteFK" class="AGGIUNGERE STILE CSS" placeholder="Inserisci il proprietario del sensore"><br><br>
<input type="text" class="casella" name="marca" class="AGGIUNGERE STILE CSS" placeholder="Inserisci marca"><br><br>
<input type="text" class="casella" name="tipo" class="AGGIUNGERE STILE CSS" placeholder="Inserisci tipo"><br><br>

<br><br>
<input type="submit" class="bottone" name="submitAggiungiSensore" value="Aggiungi sensore">

</form><br><br><br><br>

<form action="gestioneSensore.php" method="post">
<input type="submit" class="bottone" value="Visualizza sensori" name="submitVisualizzaSensori">
</form>

<div id="visualizza">
<table>

<?php
if($query){
echo"<tr>";
echo"<th class='th'>ID SENSORE</th>";
echo"<th class='th'>ID PROPRIETARIO</th>";
echo"<th class='th'>MARCA</th>";
echo"<th class='th'>TIPO</th>";
}

while ($row = mysql_fetch_assoc($query)) {
		echo"<tr>";
        echo "<td class='td'> ". $row['id_sensore']."</td> ";
        echo "<td class='td'> ". $row['id_clienteFK']." </td>";
        echo "<td class='td'> ". $row['marca']." </td> ";
        echo "<td class='td'> ". $row['tipo']." </td> ";
        echo "</tr>";
        }

?>
</table>
</div>
<br><br>

<form action="gestioneSensore.php" method="post">

<input type="text" class="casella" name="id_sensore" class="AGGIUNGERE STILE CSS" placeholder="Inserisci id sensore da eliminare"><br><br>
<input type="submit" class="bottone" name="submitRimuoviSensore" value="Rimuovi sensore">

</form><br><br>
</div>
</body>
</html>