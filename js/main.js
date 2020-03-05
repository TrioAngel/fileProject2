$(document).ready(function(){
	load_item_list();
	function load_item_list() {
		var action = "show";
		$.ajax({
			url: "../includes/action.php",
			method: "POST",
			data: {action: action},
			success: function (data) {
				$('#show_all').html(data);
			}
		})
	}
})