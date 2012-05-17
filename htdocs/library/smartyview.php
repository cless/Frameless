<?php
/* Copyright (C) 2011-2012 clueless <clueless@thunked.org
 * Copyright (C) 2012 Oishi (https://gitorious.org/~oishi)
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
    /**
     * Implement a Smarty view with the desired interface. To use SmartyView /data/compile has to be
     * writable by the webserver.
     */
    class SmartyView implements ViewInterface
    { 
        private $smarty;
        private $template;
        
        /**
         * Initializes the SmartyView object
         */
        function __construct()
        {
            $this->smarty = new Smarty;
            $this->smarty->setTemplateDir(dirname(__FILE__) . '/../view/');
            $this->smarty->setCompileDir(dirname(__FILE__)  . '/../data/compile');
            $this->smarty->setCacheDir(dirname(__FILE__)    . '/../data/cache');
            $this->smarty->setConfigDir(dirname(__FILE__)   . '/../data/config');
        }
        
        /**
         * Sets a template to use for rendering
         *
         * \param template This is the filename or path of a template. template
         *                 directory is /data/view/
         */
        public function SetTemplate($template)
        {
            $this->template = $template;
        }
        
        /**
         * Assign a variable in the template (pretty much the same as the Smarty::Assign function)
         * \param name Variable name
         * \param value Desired value, see the smarty manual for more info
         */
        public function SetVar($name, $value)
        {
            $this->smarty->Assign($name, $value);
        }
 
        /**
        * Clear the assignment of a previously assigned variable by SetVar
        * \param name Variable name
        */
        public function UnsetVar($name)
        {
            $this->smarty->clearAssign($name);
        }       
        
        /**
         * Renders the output based on the template and assigned variables
         */
        public function Draw()
        {
            $this->smarty->Display($this->template);
        }
    }
?>
