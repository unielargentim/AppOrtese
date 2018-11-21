$(document).ready(function(){

		var r = confirm("Deseja realmente apagar esse agendamento?");
		var searchParams = new URLSearchParams(window.location.search);
		if (r == true) {
			setTimeout(location.href = 'deleteAgendaDB.php?id='+ searchParams.get("id") +'&idSetup=' + searchParams.get("idSetup"),1500);
		} else {
			setTimeout(location.href = 'setup.php?id=' + searchParams.get("id"),1500);
		}
});
