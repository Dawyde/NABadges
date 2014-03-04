<?php
$edition = "14.1";

mysql_connect('localhost', 'root', '');
mysql_select_db('nantarena_drupal');

$object = array();

//Récupération des tournois
$tournaments = array();
$query = mysql_query("SELECT * FROM na_tournaments WHERE na_edition='".$edition."'");
while($data = mysql_fetch_array($query)){
	$tournaments[$data['idTournament']] = $data;
}

//Récupération des teams
$teams = array();
$query = mysql_query("SELECT * FROM na_teams WHERE na_edition='".$edition."'");
while($data = mysql_fetch_array($query)){
	$name = trim($data['teamName']);
	if($name[0] == '*'){
		$data['teamName'] = trim(substr($name,1));
	}
	//else continue;
	$teams[$data['idTeam']] = $data;
}



//Récupération des équipes pour chaque tournois
foreach($tournaments as $id=>$game){
	$query = mysql_query("SELECT na_players.* FROM na_players LEFT JOIN na_player_tournament ON na_player_tournament.idPlayer = na_players.idPlayer WHERE na_players.na_edition='".$edition."' AND na_player_tournament.idTournament = '".$id."'") or die(mysql_error());
	while($player = mysql_fetch_array($query)){
		if(!array_key_exists($player['idTeam'], $teams)) continue;
		$object[] = array(
			'pseudo' => $player['playerName'],
			'team' => $teams[$player['idTeam']]['teamName'],
			'shortTeam' => $teams[$player['idTeam']]['tag'],
			'game' => $game['idGame'],
			'paye' => $player['paye'],
		);
	}
	
}

$f = fopen('datas.json','w+');
fwrite($f, json_encode($object));
fclose($f);