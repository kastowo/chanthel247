<?php
// created by : dhiar

class Calendar extends MX_Controller {

    function index()
    {
	    $this->template->write('title', 'Baciro Gateway', TRUE);
		  $data['tes'] = json_encode(getMenuList(''), true);
		  $this->template->write('breadcrumb', 'Calendar', TRUE);
	    $this->template->write_view('content', 'calendar_view', $data, TRUE);
	    $this->template->render();

	}


}
?>
