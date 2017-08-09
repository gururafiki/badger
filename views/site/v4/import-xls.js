function repeat_import() {
	var start =localStorage.getItem('start');
	var next =  parseInt(start)+1;
	localStorage.setItem('start',next);
	$.ajax({
			url: "UpdateDB.php",
            type: 'post',
			timeout: 180000,
			data: {'start': start},
			success: function(data){
						$("#progress-bar").append("I");
						$("#content").html("<p>" + data + "</p>");
						if (data == "end") {
							$("#content").html("<h2>success!</h2>");
						}
						else {
							repeat_import();
						}		
					},
			complete: function(xhr, textStatus){
						if (textStatus != "success") {
							$("#progress-bar").append("I");
							repeat_import();		
						}
					}
	});
}

$(function (){
	localStorage.setItem('start',0);
	repeat_import();
});