<?php
/* Copyright (C) 2011 clueless <clueless@thunked.org>
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
     * Slight expansion of the default Exception that allows multiple messages
     * The idea is that some exceptions might want to display one message to the user
     * and log another message in an error log (e.g. 'a database error occured' vs the actual mysql error)
     */
    class FramelessException extends Exception
    {
        private $msglist;
        
        /**
         * \param $message Array of string messages OR a single string message
         * \param $code Error code for the exception (see php Exception for more info)
         */
        public function __construct($message, $code = 0, Exception $chained = null)
        {
            if(is_array($message))
                $this->msglist = $message;
            else
                $this->msglist = array($message);

            parent::__construct($this->msglist[0], $code, $chained);
        }
        
        /**
         * Fetches all the messages associated with this exception. 
         * \return An array of all the messages passed into this exception. If the exception was created with
         *         a string message instead of an array then this function will still return an array (with 1 member)
         */
        public function GetAllMessages()
        {
            return $this->msglist;
        }
    }
?>
