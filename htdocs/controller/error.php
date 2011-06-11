<?php
    /**
     * Basic example of an error controller
     * Make sure that the error handling class does not itself throw exceptions
     */
    class Error implements ErrorInterface
    {
        private $exception;

        public function __construct(FramelessException $e)
        {
            $this->exception =& $e;
        }

        public function Handle()
        {
           if($this->exception->GetCode() == ErrorCodes::E_404)
                $this->Handle404();
            elseif($this->exception->GetCode() == ErrorCodes::E_CHAINED)
                $this->HandleChained();
            else
                $this->HandleUnknown();
        }

        private function Handle404()
        {
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
            echo '404 page not found';
        }
        
        private function HandleChained()
        {
            echo $this->exception->getPrevious()->GetMessage() . '<br />';
        }

        private function HandleUnknown()
        {
            $msgs = $this->exception->GetAllMessages();
            foreach($msgs as $m)
            {
                echo "$m<br />";
            }
        }
    }
?>
