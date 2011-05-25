<?php
    /**
     * Form represents a form and its fields and allows you to easily verify the submitted contents.
     */
    class Form
    {
        private $fields;
        private $post;
        private $errors;

        public function __construct()
        {
            $this->fields = array();
            $this->errors = array();
            $this->post = new Vector($_POST);
        }
        
        /**
         * Adds a field description to the form, these are then used to verify if the form was submitted correctly
         *
         * \param name Name of the field that is to be verified
         * \param verification When set to false, no verification at all will be done on this field.
         *                     When set to true, the field will need to be submitted and have a value, but the value does not matter.
         *                     When set to an array, the field will only verify if its value is contained in the array
         *                     When set to a regular expression (string), the field will only verify if the regular exrpession is matched
         * \param error This is the error string that will be set when this field fails verification
         */
        public function AddField($name, $verification = true, $error = 'Invalid value')
        {
            if(is_bool($verification) || is_string($verification) || is_array($verification))
            {
                $this->fields[$name] = array('verification' => $verification,
                                             'error'        => $error);
            }
            else
                throw Exception('Invalid type for verification parameter');
        }
        
        /**
         * Verify a single field known to the form. You most likely need Form::Verify instead of Form::VerifyField.
         * \param name The name of the field to verify. This field has to be described by Form::AddField before you can verify it
         * \return true when the field verification succeeds, false otherwise.
         */
        public function VerifyField($name)
        {
            if (!isset($this->fields[$name]))
                throw Exception('There is no known description for a field named `' . $name . '`');

            $field =& $this->fields[$name];
            if ($field['verification'] === false)
                return true;
            
            // Verify if the field is present
            if($field['verification'] === true && $this->post->Exists($name) && $this->post->AsDefault($name) != '')
                return true;
            elseif($field['verification'] === true)
                return false;
                
            // Verification is a list of valid values
            if (is_array($field['verification']) && in_array($this->post->AsDefault($name), $field['verification']))
                return true;
            else if(is_array($field['verification']))
                return false;
            
            // Verification is a regular expression
            if (is_string($field['verification']))
                return preg_match($field['verification'], $this->post->AsDefault($name)) === 1 ? true : false;
        }

        /**
         * Verify all fields known to the form and set the error values (if any). You can call
         * Form::GetErrors after this function te get the actual error values.
         * \return true when all fields pass verification, false otherwise.
         */
        public function Verify()
        {
            $verdict = true;
            $this->errors = array();
            foreach ($this->fields as $name => $field)
            {
                if($this->VerifyField($name) === false)
                {
                    $verdict = false;
                    $this->errors[$name] = $field['error'];
                }
            }
            return $verdict;
        }

        /**
         * Fetch the submitted values (if any) of all fields described with Form::AddField
         * \return Returns an array of key=>value pairs where key is the form field name and value is the contents.
         */
        public function GetValues()
        {
            $values = array();
            foreach ($this->fields as $name => $field)
            {
                if ($this->post->Exists($name))
                    $values[$name] = $this->post->AsDefault($name);
            }
            return $values;
        }

        /**
         * Fetch all errors, note that if you haven't called Form::Verify that no errors will be returned.
         * \return an array of all errors, key => value is form field name => error  (e.g. array('age' => 'Invalid age range'))
         */
        public function GetErrors()
        {
            return $this->errors;
        }

    }
?>
