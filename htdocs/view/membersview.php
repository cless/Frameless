<?php
    // A view in Frameless is a class that ultimately inherits from ViewTemplate. This template
    // exports a few functions that controllers can call to render the view. SmartyView is a
    // more specialized version of the template that implements all the functions to work with
    // the smarty template engine.
    class MembersView extends SmartyView
    {
        // To use the SmartyView you should re-implement the ViewInit function and set a template
        // Make sure to also call the ViewInit function.
        //
        // In theory you can just call this function from your controller and not have a separate
        // view class but this is discouraged because your view cant be replaced without editing
        // the controller, you lose the benefit modularity.
        protected function ViewInit()
        {
            parent::ViewInit();
            $this->ViewSetTemplate('members.tpl'); // See smarty documentation for information about template files
        }
    };
?>
