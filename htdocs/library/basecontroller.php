<?php
    /**
     * BaseController provides the most basic functionality that every almost every controller needs.
     * It provides a members to access the post, get, config and session variables
     */
    abstract class BaseController
    {
        /**
         * read only Vector that allows access the configuration in /data/config.ini
         */
        protected $config;
        
        /**
         * read only Vector that allows access the GET variables posted with the http request
         */
        protected $get;
        
        /**
         * read only Vector that allows access the POST variables posted with the http request
         */
        protected $post;

        /**
         * writable vector that gives you access to the session variables
         */
        protected $session;

        /**
         * Initializes the controller.
         * \param config 
         * \param session When set to false the BaseController will not create a session and the
         *                BaseController::session vector will NOT be accessible.
         *                To create a named session pass a string with the name to this parameter.
         *                pass true (default) to start an unnamed session.
         */
        public function __construct(&$config, $session = true)
        {
            $this->config   = $config;
            $this->get      = new Vector($_GET, true);
            $this->post     = new Vector($_POST, true);
        }

        private function SessionInit($session)
        {
            if($session == false)
                return;
            
            if($session !== true)
                session_name($session);

            session_start();
        }
        
        /**
         * Children need to implement this function and make it return a string with the name of the default action
         */
        abstract public function DefaultAction();
    }
?>
