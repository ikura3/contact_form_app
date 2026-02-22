<?php
    class ContactForm
    {
        private $name;
        private $email;
        private $body;

        public function __construct($name, $email, $body){
            $this->name = $name;
            $this->email = $email;
            $this->body = $body;
        }

        public function getName() {
            return $this->name;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getBody() {
            return $this->body;
        }
    }