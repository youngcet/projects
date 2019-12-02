<?php

    require_once('Utils.php');

    class SendMail
    {
        use Utils;

        private $_logName;
        private $_msg;

        public function __construct($msg)
        {
            $this->_logName = 'logs/'. get_class($this).'.log';
            $this->_msg = $msg;

            try
            {
                $this->sendMail();
            }
            catch (Exception $e)
            {
                $this->logEvent($this->_logName, 'Caught exception: '.  $e->getMessage());
                # if an exception is thrown, die
                die('Caught exception: '.  $e->getMessage()); 
            }
        }

        public function sendMail()
        {
            # check that values are provided
            if (empty($this->_msg['recipient']) || empty($this->_msg['subject']) || empty($this->_msg['message']) || empty($this->_msg['from']) 
                || empty($this->_msg['replytoName']) || empty($this->_msg['replyto']))
            {
                throw new Exception('1 or more values passed is empty');
            }

            // set the headers
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = 'Reply-To: '.$this->_msg['replytoName'].' <'.$this->_msg['replyto'].'>';
            $headers[] = 'From: '.$this->_msg['replytoName'].' <'.$this->_msg['from'].'>';

            # split the recipients (incase there's multiple recipients)
            $recipients = preg_split('/\,/', $this->_msg['recipient']);

            foreach ($recipients as $recipient)
            {
                // send the email
                if (!mail(trim($recipient), $this->_msg['subject'], $this->_msg['message'], implode("\r\n", $headers), "-odb -f ".$this->_msg['from']))
                {
                    $this->logEvent($this->_logName, "Failed to send mail to $recipient: ".error_get_last()['message']);
                }
                else
                {
                    $this->logEvent($this->_logName, "Mail sent to $recipient");
                }
            }
        }
    }
?>