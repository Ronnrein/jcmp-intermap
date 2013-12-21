<!DOCTYPE html>
<html>
<head>
	<title>Intermap</title>
	<style type="text/css">
		#canvas{
			background-image:url("map.jpg");
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

			function convertCoord(coord){
				return Math.floor(coordsMaxNew * (parseFloat(coord)+coordsMaxOld/2) / coordsMaxOld);
			}

			getData();
			setInterval(getData, 1000);
		});
	</script>
</head>
<body>
	<canvas id="canvas" width="800" height="800"></canvas>
</body>
</html>