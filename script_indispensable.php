<script src="./assets/js/konami.js"></script>
<script>
	function getRandomInt(min, max) {
	  min = Math.ceil(min);
	  max = Math.floor(max);
	  return Math.floor(Math.random() * (max - min)) + min;
	}
	var k = new Konami(function() { 
		var nb = getRandomInt(0,9);/*Borne sup NON incluse*/
		if (nb==0)alert("You're a wizzard Harry");
		else if (nb==1)alert("Luke, je suis ton père");
		else if (nb==2)alert("La vie c’est comme une boîte de chocolats, on ne sait jamais sur quoi on va tomber");
		else if (nb==3)alert("All your base are belong to us");
		else if (nb==4)alert("The answer to life the universe and everything is 42");
		else if (nb==5)alert("Pokeball GO");
		else if (nb==6){alert("Whololo");$('*').css({"background":"blue"});}
		else if (nb==7)alert("I am the batman");
		else alert("LA QUOI ? LA PIERRE PHILOSOPHALE !");
	});
</script>
