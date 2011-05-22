<?php
    /**
     * Base class for views based on the smarty template engine. To keep your view
     * interchangeable with any view that follows the interface set in ViewTemplate
     * you should inherit the SmartyView::ViewInit() class and call
     * SmartyView::ViewSetTemplate() from there. See view examples for clarification.
     */
    abstract class SmartyView extends ViewTemplate
    { 
        private $smarty;
        private $template;
        
        /**
         * Initializes the SmartyView object
         */
        protected function ViewInit()
        {
            $this->smarty = new Smarty;
            $this->smarty->setTemplateDir(dirname(__FILE__) . '/../view/templates/');
            $this->smarty->setCompileDir(dirname(__FILE__)  . '/../data/compile');
            $this->smarty->setCacheDir(dirname(__FILE__)    . '/../data/cache');
            $this->smarty->setConfigDir(dirname(__FILE__)   . '/../data/config');
        }
        
        /**
         * Sets a template to use for rendering
         *
         * \param template This is the filename or path of a template. template
         *                 directory is /data/view/templates/.
         */
        protected function ViewSetTemplate($template)
        {
            $this->template = $template;
        }
        
        /**
         * Assign a variable in the template (pretty much the same as the Smarty::Assign function)
         * \param name Variable name
         * \param value Desired value, see the smarty manual for more info
         */
        protected function ViewAdd($name, $value)
        {
            $this->smarty->Assign($name, $value);
        }
        
        /**
         * Renders the output based on the template and assigned variables
         */
        protected function ViewDraw()
        {
            $this->smarty->Display($this->template);
        }
    }
?>
