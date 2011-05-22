<?php

class Error404 extends Error404View
{
    function Handle404()
    {
        header('HTTP/1.1 404 Not Found'); 
        $this->Draw();
    }
};

?>
