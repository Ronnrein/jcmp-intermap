<!DOCTYPE html>
<html>
<head>
	<title>Intermap</title>
	<style type="text/css">
		#canvas{
			background-image:url("map.jpg");
		}
		#chat{
			height:700px;
			border:1px solid;
		}
		#chat p{
			margin:0px;
			padding:0px;
		}
	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			var coordsMaxOld = 33000;
			var coordsMaxNew = 800;

			var rectSize = 5;
			var xTextPad = 4;
			var yTextPad = 4;
			var yTextOffset = 5;
			var xTextOffset = 5;

			var c = document.getElementById("canvas");
			var ctx = c.getContext("2d");
			ctx.font = "10px Tahoma";
			ctx.strokeStyle = "white";

			function getData(){
				$.getJSON("getnew.php", function(data){
					ctx.clearRect(0, 0, c.width, c.height);
					$.each(data.tps, function(i, tp){
						renderTp(tp.name, tp.x, tp.y);
					});
					$.each(data.players, function(i, user){
						renderPlayer(user.name, user.x, user.y);
					});
					$("#chat").empty();
					$.each(data.chat, function(i, msg){
						renderChat(msg.time, msg.name, msg.msg);
					});
				});
			}

			function renderPlayer(name, x, y){
				x = convertCoord(x);
				y = convertCoord(y);
				var txtSize = ctx.measureText(name);
				ctx.fillStyle = "green";
				ctx.fillRect(x+rectSize-xTextPad+xTextOffset, y-+rectSize-yTextPad+2, txtSize.width+xTextPad*2, yTextOffset+yTextPad*2);
				ctx.strokeRect(x+rectSize-xTextPad+xTextOffset, y-+rectSize-yTextPad+2, txtSize.width+xTextPad*2, yTextOffset+yTextPad*2);
				ctx.fillRect(x-rectSize/2, y-rectSize/2, rectSize, rectSize);
				ctx.strokeRect(x-rectSize/2, y-rectSize/2, rectSize, rectSize);
				ctx.fillStyle = "white";
				ctx.fillText(name, x+rectSize+5, y+rectSize/2);
			}

			function renderTp(name, x, y){
				x = convertCoord(x);
				y = convertCoord(y);
				var txtSize = ctx.measureText(name);
				ctx.fillStyle = "blue";
				ctx.fillRect(x-txtSize.width/2-xTextPad, y-yTextOffset*2.5-yTextPad, txtSize.width+xTextPad*2, yTextOffset+yTextPad*2);
				ctx.strokeRect(x-txtSize.width/2-xTextPad, y-yTextOffset*2.5-yTextPad, txtSize.width+xTextPad*2, yTextOffset+yTextPad*2);
				ctx.fillStyle = "white";
				x = Math.floor(x-txtSize.width/2);
				y = y - 7;
				
				ctx.fillText(name, x, y);
			}

			function addChat(){
				if($("#name").val() && $("#msg").val()){
					$.post("newchat.php", {name: $("#name").val(), msg: $("#msg").val()});
					$("#msg").val("");
				}
				else{
					alert("Fyll ut både navn og melding");
				}
			}

			$("#send").click(function(){
				addChat();
			});

			$("#msg").keypress(function(e){
				if(e.which == 13){
					addChat();
				}
			});

			function renderChat(time, name, msg){
				$("#chat").append("<p>"+name+": "+msg+"</p>");
			}

			function convertCoord(coord){
				return Math.floor(coordsMaxNew * (parseFloat(coord)+coordsMaxOld/2) / coordsMaxOld);
			}

			getData();
			setInterval(getData, 1000);
		});
	</script>
</head>
<body>
	<table><tr><td>
		<canvas id="canvas" width="800" height="800"></canvas>
	</td><td>
		Nick: <input type="text" id="name" /><br />
		<div id="chat"></div><br >
		<input type="text" id="msg" />
		<button id="send">Send</button>
	</td></tr></table>
</body>
</html>