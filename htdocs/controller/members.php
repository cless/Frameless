<?php

    // Controllers are the center of your application, the browser specifies what controller
    // to load, which action to run and possibly what POST/GET/COOKIE data to send with the request
    // The controller then acts upon that by using models to interact with data, and using views to
    // display the result back to the browser.

    // Your controller class extends a view class, see views/memberview.php for more about that.
    class Members extends MembersView
    {
        private $config;
        
        // Each controller should have a constructor that takes a Vector as argument. In this
        // vector you will find the contents of data/config.ini
        public function __construct(&$config)
        {
            $this->config =& $config;
        }
        
        // Each controller should export a function that returns the default action as a string
        public function DefaultAction()
        {
            return 'all';
        }
        
        // The actions are just functions with the same name, if the browser calls for
        // http://example.com/members/all/ then this function will run
        public function All()
        {
            // See models/membersmodel.php for more info on models
            $members = new MembersModel();
            $this->ViewInit();
            $this->ViewAdd('list', $members->GetAll());
            $this->ViewDraw();
        }

        // http://example.com/members/all/
        public function User()
        {
            // Create a vector from the $_GET string for sexy access
            $get = new Vector($_GET);
            $members = new MembersModel();

            $this->ViewInit();
            $this->ViewAdd('member', $members->GetUser($get->AsString('args')));
            $this->ViewDraw();
        }
    }
?>
