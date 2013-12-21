<?php

$pathOut = 	"G:\\Spill\\Steam\\steamapps\\common\\Just Cause 2 - Multiplayer Dedicated Server\\scripts\\intermap\\chatout.txt";
$pathIn = 	"G:\\Spill\\Steam\\steamapps\\common\\Just Cause 2 - Multiplayer Dedicated Server\\scripts\\intermap\\chatin.txt";

if(isset($_POST['name'])){
	$name = $_POST['name'];
	$msg = $_POST['msg'];
	$time = time();

	$fileIn = file_get_contents($pathIn);
	$fileIn.= $time.",".$name.",".$msg;
	file_put_contents($pathIn, $fileIn);

	$fileOut = file_get_contents($pathOut);
	$fileOut.= "\r\n".$time.",WEB::".$name.",".$msg;
	file_put_contents($pathOut, $fileOut);
}

?>