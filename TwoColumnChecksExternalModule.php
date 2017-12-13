<?php
namespace Vanderbilt\TwoColumnChecksExternalModule;

use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;

require_once APP_PATH_DOCROOT.'Classes/Files.php';


class TwoColumnChecksExternalModule extends AbstractExternalModule
{
        private $email_requested = false;

        public function __construct(){
                parent::__construct();
                $this->disableUserBasedSettingPermissions();
        }

        function hook_survey_page ($project_id,$record = NULL,$instrument,$event_id, $group_id, $survey_hash,$response_id, $repeat_instance) {
		echo "<script>\n";
		echo "function twoColumnCheckboxes() {\n";
		echo "	var checkboxes = {};\n";
		echo "	$('tr td div.choicevert').each(function(index, ob) {\n";
		echo "		var row = $(ob).parent().parent().attr('id');\n";
		echo "		if (typeof checkboxes[row] == 'undefined') {\n";
		echo "			checkboxes[row] = 0;\n";
		echo "		}\n";
		echo "		checkboxes[row]++;\n";
		echo "	});\n";
		echo "	for (var row in checkboxes) {\n";
		echo "		var done = false;\n";
		echo "		if (checkboxes[row] > 10) {\n";
		echo "			var checksInCol = Math.ceil(checkboxes[row] / 2);\n";
		echo "			$(\"#\"+row+\" td div.choicevert\").each(function(index, ob) {\n";
		echo "				if (!done) {\n";
		echo "					$(ob).parent().find('label.fl').after(\"<div id='\"+row+\"-left' class='leftCol'></div><div id='\"+row+\"-right' class='rightCol'></div>\");\n";
		echo "				}\n";
		echo "				done = true;\n";
		echo "			});\n";
		echo "			$(\"#\"+row+\" td div.choicevert\").each(function(index, ob) {\n";
		echo "				if (index < checksInCol) {\n";
		echo "					$(ob).appendTo(\"#\"+row+\"-left\");\n";
		echo "				} else {\n";
		echo "					$(ob).appendTo(\"#\"+row+\"-right\");\n";
		echo "				}\n";
		echo "			});\n";
		echo "		}\n";
		echo "	}\n";
		echo "}\n";
		echo "$(document).ready(function() {\n";
		echo "	twoColumnCheckboxes();\n";
		echo "});\n";
		echo "</script>\n";
		echo "<style>\n";
		echo "div.leftCol { width: 50%; float: left; }\n";
		echo "div.rightCol { width: 50%; float: right; }\n";
		echo "</style>\n";
	}
}
