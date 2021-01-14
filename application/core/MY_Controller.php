<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

/**
 * Description of my_controller
 *
 * @author http://www.roytuts.com
 */
class MY_Controller extends MX_Controller {

    function __construct() {
        parent::__construct();
        //default title
        $this->template->write('title', 'Roy Tutorials', TRUE);
        //default meta description
        $this->template->add_meta('description', 'An example of a page description.');
        //it is better to include header and footer here because these will be used by every page
        $this->template->write_view('header', 'templates/snippets/header');
        $this->template->write_view('footer', 'templates/snippets/footer');

        /*$this->template->write_view('header', Modules::run('layout/header'));
        $this->template->write_view('footer', Modules::run('layout/footer'));*/

    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */