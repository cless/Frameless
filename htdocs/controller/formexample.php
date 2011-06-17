<?php
    // formexample.php shows how to use the Form class
    // For all other information check members.php
    class FormExample extends BaseController
    {
        private $view;

        public function __construct(&$config, &$args)
        {
            parent::__construct($config, $args);

            $this->view = new SmartyView();
            $this->view->SetTemplate('formexample.tpl');
            $this->actions = array('default'    => 'test',
                                   'test'       => 'test');
        }
        

        // Static function used as custom verification for a form field
        static function VerifyFunction($value)
        {
            if($value % 2 == 1 && $value > 10)
                return true;
            else
                return false;
        }
        

        public function test()
        {
            // Create a new form class and describe the form's fields
            $form = new Form;
            $form->AddField('a', Form::VTYPE_ARRAY, array('one', 'two'), 'Please enter \'one\' or \'two\'');
            $form->AddField('b', Form::VTYPE_REGEX, '/^[0-9]+$/', 'Please enter some numbers, no other characters are allowed');
            $form->AddField('c', Form::VTYPE_VALUE, null, 'This field can\'t be empty');
            $form->AddField('d', Form::VTYPE_NONE);
            $form->AddField('e', Form::VTYPE_EQUAL, 'b', 'This field bust be equal to the second field');
            $form->AddField('f', Form::VTYPE_FUNCTION, 'FormExample::VerifyFunction', 'This field must be an odd number larger than 10');
            $form->AddField('g', Form::VTYPE_TOKEN, null, 'Form error, please try again');
            $form->AddField('submit', Form::VTYPE_EXISTS);
            
            // Forms using tokens need to have their name described early on (before CreateToken or Verify)
            $form->TokenName('token');
            
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

            // if verification happens on the same page as the form is then we have to set the token variable
            // after verification is completed, otherwise it will always verify correctly
            $this->view->SetVar('token', $form->CreateToken());
            $this->view->Draw();
        }
    }
