<?php
    class Error404View
    {
        public function Draw()
        {
            $smarty = new Smarty();
            
            $smarty->setTemplateDir(dirname(__FILE__) . '/templates/');
            $smarty->setCompileDir(dirname(__FILE__) . '/../data/compile');
            $smarty->setCacheDir(dirname(__FILE__) . '/../data/cache');
            $smarty->setConfigDir(dirname(__FILE__) . '/../data/config');
            
            $smarty->Display('404.tpl');
            
        }
    };
?>
