<?php
require("class/badge.class.php");
require("class/manager.class.php");
require("tpdf/tfpdf.php");

$manager = new Manager();

$manager->addType(1, "images/admin.jpg", array(255,255,255), false);//Admin
$manager->addType(15, "images/csgo.jpg", array(255,255,255), true);//CSGO
$manager->addType(14, "images/lol.jpg", array(255,255,255), true);//LoL
$manager->addType(10, "images/sc2.jpg", array(255,255,255), true);//StraCraft2
$manager->addType(13, "images/mc.jpg", array(255,255,255), true);//Minecraft
$manager->addType(6, "images/staff_consoles.jpg", array(0,0,0), false);//Stand

$manager->addBadge(new Badge("Didip","STAFF","absooiqosdsqklkl",1));
$manager->addBadge(new Badge("Jêrome","STAFF","absooiqosdsqklkl",6));

$datas = json_decode(file_get_contents('datas.json'),true);
foreach($datas as $data){
	$manager->addBadge(new Badge($data['pseudo'], $data['team'], $data['pseudo']."...",$data['game']));
}

$manager->generatePDF();
?>