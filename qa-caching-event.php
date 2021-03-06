<?php
if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
    header('Location: ../../');
    exit;
}
require_once QA_PLUGIN_DIR.'q2a-caching/qa-caching-main.php';

class qa_caching_event {
	
    public function process_event ($event, $userid, $handle, $cookieid, $params) {    	
    	
        $events = QA_CACHING_EXPIRATION_EVENTS;
        $events = explode(',', str_replace(array("\r\n", "\r", "\n", " "), '', $events));
        if(in_array($event, $events)) {
            $main = new qa_caching_main;
            $main->clear_cache();
        }
        
    }
     
}

class qa_caching_session_reset_event {
	
	public function process_event ($event, $userid, $handle, $cookieid, $params) { 
	
		if ( $event == 'u_login' ) {
			$this->reset_session();
		}
		
	}
	
	// turn off the flag if login happened
    private function reset_session() {
    	
    	if ( isset( $_SESSION['cache_use_off'] )) {    		
    		unset( $_SESSION['cache_use_off'] );    		
    	}
    	
    }
	
}

/*
	Omit PHP closing tag to help avoid accidental output
*/
