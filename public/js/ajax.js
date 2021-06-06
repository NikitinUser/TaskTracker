function ajaxPost(url, params, callback){
	var f = callback || function(data){};
	var request = new XMLHttpRequest();
	
	request.onreadystatechange = function(){
		if (request.readyState==4){
			if (request.status == 200) {
				var myObj = request.response;
				f(myObj);
			} else {
				console.log(request.status);
				console.log(request.statusText);
				f(request.status);
			}
			
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
		if (request.readyState==4 && request.response != ''){
			var myObj = request.response;
			f(myObj);
		}
	}
	
	request.open('GET', url);
	//request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send();
}