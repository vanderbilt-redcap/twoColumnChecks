<script>
function twoColumnCheckboxes() {
	var checkboxes = {};
	$("tr td div.choicevert").each(function(index, ob) {
		var row = $(ob).parent().parent().attr('id');
		if (typeof checkboxes[row] == "undefined") {
			checkboxes[row] = 0;
		}
		checkboxes[row]++;
	});
	for (var row in checkboxes) {
		var done = false;
		if (checkboxes[row] > 10) {
			var checksInCol = Math.ceil(checkboxes[row] / 2);
			$("#"+row+" td div.choicevert").each(function(index, ob) {
				if (!done) {
					$(ob).parent().find("label.fl").after("<div id='"+row+"-left' class='leftCol'></div><div id='"+row+"-right' class='rightCol'></div>");
				}
				done = true;
			});
			$("#"+row+" td div.choicevert").each(function(index, ob) {
				if (index < checksInCol) {
					$(ob).appendTo("#"+row+"-left");
				} else {
					$(ob).appendTo("#"+row+"-right");
				}
			});
		}
	}
};

$(document).ready(function() {
	twoColumnCheckboxes();
});

</script>

<style>
div.leftCol { width: 50%; float: left; }
div.rightCol { width: 50%; float: right; }
</style>
