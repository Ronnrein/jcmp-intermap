<?php

$pathPlayers = 	"G:\\Spill\\Steam\\steamapps\\common\\Just Cause 2 - Multiplayer Dedicated Server\\scripts\\intermap\\intermap.txt";
$pathTps = 		"G:\\Spill\\Steam\\steamapps\\common\\Just Cause 2 - Multiplayer Dedicated Server\\scripts\\freeroam\\spawns.txt";
$pathChat = 	"G:\\Spill\\Steam\\steamapps\\common\\Just Cause 2 - Multiplayer Dedicated Server\\scripts\\intermap\\chatout.txt";

$array = array("players" => array(), "tps" => array(), "chat" => array());

$handle = fopen($pathPlayers, "r");
if($handle){
	while(($line = fgets($handle)) !== false){
		$line = str_replace("\r\n","",$line);
		if(!empty($line)){
			$exp = explode(",", $line);
			$array["players"][] = array("name" => $exp[0], "x" => $exp[1], "y" => $exp[2]);
		}
	}
}
else{
	echo "Error";
}

$handle = fopen($pathTps, "r");
if($handle){
	while(($line = fgets($handle)) !== false){
		$line = str_replace("\r\n","",$line);
		if($line[0] == "T" && !empty($line)){
			$exp = explode(", ", substr($line,2));
			$array["tps"][] = array("name" => $exp[0], "x" => $exp[1], "y" => $exp[3]);
		}
	}
}
else{
	echo "Error";
}

$file = file($pathChat);
for($i = count($file)-36; $i < count($file); $i++){
	$line = $file[$i];
	$line = str_replace("\r\n","",$line);
	if(!empty($line)){
		$exp = explode(",", $line);
		$array["chat"][] = array("time" => $exp[0], "name" => $exp[1], "msg" => $exp[2]);
	}
}

echo json_encode($array);
?>