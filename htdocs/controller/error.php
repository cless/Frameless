<?php
    /**
     * Basic example of an error controller
     * Make sure that the error handling class does not itself throw exceptions
     */
    class Error implements ErrorInterface
    {
        private $exception;

        public function __construct(Exception $e)
        {
            $this->exception =& $e;
        }

        public function Handle()
        {
            if($this->exception instanceof NotFoundException)
                $this->Handle404();
            elseif($this->exception instanceof FramelessException)
                $this->HandleFrameless();
            else
                $this->HandleUnknown();
        }

        private function Handle404()
        {
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
            echo '404 page not found';
        }
        
        private function HandleUnknown()
        {
            echo 'An unknown exception occured.<br />';
        }

        private function HandleFrameless()
        {
            $msgs = $this->exception->GetAllMessages();
            foreach($msgs as $m)
            {
                echo "$m<br />";
            }
        }
    }
?>
