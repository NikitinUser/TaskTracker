function hideWaitingModal() {
	$("#modalWaitingServer").removeClass("in");
	$(".modal-backdrop").remove();
	document.querySelector("#modalWaitingServer").className = "modal fade";
	document.querySelector("#modalWaitingServer").style.display = "none";
	$("#modalWaitingServer").modal('hide');
	$('body').removeClass('modal-open');
}

function startWaitingModal() {
	document.querySelector("#modalWaitingServer").className = "modal fade show";
	document.querySelector("#modalWaitingServer").style.display = "block";
	$('#modalWaitingServer').modal('show');
}