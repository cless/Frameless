<?php
    /**
     * All views should inherit from this template. Controllers should only use these functions if
     * you want to achieve flexible and interchangable views without having to edit your controller classes.
     */
    abstract class ViewTemplate
    {
        /**
         * Initialize the view
         */
        abstract protected function ViewInit();
        
        /**
         * Assign variables to the view
         *
         * \param name Variable name
         * \param value Variable value
         */
        abstract protected function ViewAdd($name, $value);

        /**
         * Render the view based on assigned variables
         */
        abstract protected function ViewDraw();
    }
?>
