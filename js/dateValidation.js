$(document).ready(function(){
var start = document.getElementById('dataInicial');
var end = document.getElementById('dataFinal');

	start.addEventListener('change', function() {
		if (start.value)
			end.min = start.value;
	}, false);

		end.addEventListener('change', function() {
		if (end.value)
			start.max = end.value;
	}, false);
});