function ajaxPost(url, params, callback){
	var f = callback || function(data){};
	var request = new XMLHttpRequest();

	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');
	params += "&_token=" + token
	
	request.onreadystatechange = function(){
		if (request.readyState==4){
			hideWaitingModal();

			if (request.status == 200) {
				var myObj = request.response;
				f(myObj);
			} else {
				console.log(request.status);
				console.log(request.statusText);
				f(request.status);
			}
		} else {
			document.querySelector("#modalWaitingServer").className = "modal fade show";
			$('#modalWaitingServer').modal('show');
		}
	}

	request.open('POST', url);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(params);
}

function ajaxGet(url, callback){
	var f = callback || function(data){};
	var request = new XMLHttpRequest();
	
	request.onreadystatechange = function(){
		if (request.readyState==4){
			hideWaitingModal();

			if (request.status == 200) {
				var myObj = request.response;
				f(myObj);
			} else {
				console.log(request.status);
				console.log(request.statusText);
				f(request.status);
			}
		} else {
			$('#modalWaitingServer').modal('show');
		}
	}
	
	request.open('GET', url);
	//request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send();
}

function hideWaitingModal() {
	$("#modalWaitingServer").removeClass("in");
	$(".modal-backdrop").remove();
	document.querySelector("#modalWaitingServer").className = "modal fade";
	//$("#modalWaitingServer").hide();
	$("#modalWaitingServer").modal('hide');
	$('body').removeClass('modal-open');
}