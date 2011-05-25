<?php
    // formexample.php shows how to use the Form class
    // For all other information check members.php
    class FormExample extends BaseController
    {
        private $view;

        public function __construct(&$config)
        {
            parent::__construct($config);

            $this->view = new SmartyView();
            $this->view->SetTemplate('formexample.tpl');
        }

        public function DefaultAction()
        {
            return 'test';
        }

        public function test()
        {
            // Create a new form class and describe the form's fields
            $form = new Form;
            $form->AddField('a', array('one', 'two'), 'Please enter \'one\' or \'two\'');
            $form->AddField('b', '/^[0-9]+$/', 'Please enter some numbers, no other characters are allowed');
            $form->AddField('c', true, 'This field can\'t be empty');
            $form->AddField('d', false);
            // Describe the submit button so we can use it to verify if the form was submitted
            $form->AddField('submit');
            
            // Verify if the submit button was clicked
            if($form->VerifyField('submit'))
            {
                // Run form validation
                $form->Verify();
                // And assign the form errors (if any) to the view
                $this->view->SetVar('form_error', $form->GetErrors());
                // Also assign the values that were submitted
                $this->view->SetVar('form_values', $form->GetValues());
            }
            $this->view->Draw();
        }
    }
