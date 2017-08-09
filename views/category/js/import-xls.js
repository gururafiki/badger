function repeat_import() {
	$.ajax({
			url: "/import_xls.php",
			timeout: 50000,
			success: function(data, textStatus){
						$("#progress-bar").append("I");
						if (data == "The End") {
							$("#content").html("<h2>Импорт завершен!</h2>");
						}
						else {
							$("#content").html("<p>" + data + "</p>");
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
	repeat_import();
});