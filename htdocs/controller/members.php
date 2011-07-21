<?php

    // Controllers are the center of your application, the browser specifies what controller
    // to load, which action to run and possibly what POST/GET/COOKIE data to send with the request
    // The controller then acts upon that by using models to interact with data, and using views to
    // display the result back to the browser.
    class Members extends BaseController
    {
        private $view;

        // Each controller should have a constructor that takes a Vector as argument. In this
        // vector you will find the contents of data/config.ini
        public function __construct(&$config, &$args)
        {
            parent::__construct($config, $args);
            
            $this->view = new SmartyView();
            $this->view->SetTemplate('members.tpl');

            // Every controller needs to set what actions it handles in its constructior
            // (or if you dont use BaseController you have to implement your own 
            //  ActionToFunction public member funtion. Every controller should have one action named 'default'
            //
            // Note that functions named here MUST be public
            //                     'actionname' => 'function name'
            $this->actions = array('list'       => 'all',
                                   'default'    => 'all',
                                   'user'       => 'user');

        }
        
        // The actions are just functions with the same name, if the browser calls for
        // http://example.com/members/all/ then this function will run
        public function All()
        {
            // See models/membersmodel.php for more info on models
            $members = new MembersModel();
            
            // Configure pagination at 3 items per page
            $pagination = new Pagination($members->Count(), 3, $this->args->AsInt(2), "/members/list/{page}/");
            
            // Get the range of items for the current page
            $limits = $pagination->GetLimits();

            // Assign the pagination and members variables to the view and render it
            $this->view->SetVar('pagination', $pagination->GetList());
            $this->view->SetVar('list', $members->GetRange($limits[0], $limits[1]));
            $this->view->Draw();
        }

        // http://example.com/members/all/
        public function User()
        {
            // Create a vector from the $_GET string for sexy access
            $get = new Vector($_GET);
            $members = new MembersModel();

            $this->view->SetVar('member', $members->GetUser($this->args->AsString(2)));
            $this->view->Draw();
        }
    }
?>
