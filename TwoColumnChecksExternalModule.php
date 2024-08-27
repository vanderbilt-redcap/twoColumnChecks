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

        function hook_survey_page ($project_id, $record,$instrument,$event_id, $group_id, $survey_hash,$response_id, $repeat_instance) {
            if (version_compare(REDCAP_VERSION, '12.0.0', '<')) {
                $line = "$(ob).parent().find('label.fl').after(\"<div id='\"+row+\"-left' class='leftCol'></div><div id='\"+row+\"-right' class='rightCol'></div>\");";
            } else {
                $line = "$('#'+row).find('div[data-kind=field-value]').append(\"<div id='\"+row+\"-left' class='leftCol'></div><div id='\"+row+\"-right' class='rightCol'></div>\");";
            }
            echo "
<script>
        function twoColumnCheckboxes() {
            const checkboxes = {};
	        $('tr td').each(function(index, ob) {
                if ($(ob).find('div.choicevert').length > 0) {
        	        const row = $(ob).closest('tr').attr('id');
        	        if (typeof checkboxes[row] == 'undefined') {
        		        checkboxes[row] = 0;
        	        }
        	        checkboxes[row]++;
                }
            });
            for (let row in checkboxes) {
        	    let done = false;
        	    if (checkboxes[row] > 10) {
                    const checksInCol = Math.ceil(checkboxes[row] / 2);
                    $('#'+row+' td').find('div.choicevert').each(function(index, ob) {
                        if (!done) {
                            $line
                        }
                        done = true;
                    });
                    $('#'+row+' td').find('div.choicevert').each(function(index, ob) {
                        if (index < checksInCol) {
                            $(ob).appendTo('#'+row+'-left');
                        } else {
                            $(ob).appendTo('#'+row+'-right');
                        }
                    });
                }
            }
        }
        $(document).ready(function() {
            twoColumnCheckboxes();
        });
</script>
<style>
    div.leftCol { width: 50%; float: left; }
    div.rightCol { width: 50%; float: right; }
</style>";
	}
}
