<!--<h2 id="annales">Annales</h2>
<script>
	function full()
	{
		$( "html,body" ).scrollTop( 0 );
		pos = $('#iframe').position();
		$('#main-wrapper').css({
			height:$('#main-wrapper').height()
		});
		$('#iframe').css({
			top: pos.top,
			left: pos.left,
			"position": "fixed",
			height:$("#iframe").height(),
			width:$("#iframe").width()
		})
		$('#iframe').animate({
			left: 0,
			top: 0,
			width: $(window).width(),
			height: $(window).height()
		}, 300, function(){
			$('#iframe').css({
				"width": "100%",
				"height": "100%"
			});
			$('#less').show();
		});
		$('body').css({"overflow":"hidden"});
	}
	function less()
	{
		window.location.reload();
	}
</script>
<a href="./pages/file.php" onclick="full();return false;">Afficher en plein écran</a>
<iframe id='iframe' src="./pages/file.php" style='width:100%;height:500px;background:white;'></iframe>
<a id='less' href="./annales" onclick="less();return false;" style='position:fixed;bottom:8px;right:32px;display:none;'>Réduire</a>
-->
	  <script>window.location='https://drive.google.com/drive/folders/1GCfFZ7y_rwpN3wy3UiI-ALXzgxmeoTVA'; </script>
