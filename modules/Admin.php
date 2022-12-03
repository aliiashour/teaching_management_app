<?php 
    class Admin{
        private $con = null;
        private $tbl = 'users' ; 
        private $user_type = 'ADMIN' ; 

        protected $user_first_name ; 
        protected $user_last_name ; 
        protected $user_number ; 
        protected $user_image; 
        protected $user_status ; 
        protected $user_password ; 

        public function __construct($db)
        {
            $this->con = $db ;
        }
        // setters
        public function set_user_first_name($user_first_name)
        {
            $this->user_first_name = $user_first_name ; 
        }
        public function set_user_last_name($user_last_name)
        {
            $this->user_last_name = $user_last_name ; 
        }
        public function set_user_number($user_number)
        {
            $this->user_number = $user_number ; 
        }
        public function set_user_image($user_image)
        {
            $this->user_image = $user_image ; 
        }
        public function set_user_status($user_status)
        {
            $this->user_status = $user_status ; 
        }
        public function set_user_password($user_password)
        {
            $this->user_password = $user_password ; 
        }
        // getters
        public function get_user_first_name()
        {
            return $this->user_first_name ; 
        }
        public function get_user_last_name()
        {
            return $this->user_last_name ; 
        }
        public function get_user_number()
        {
            return $this->user_number  ; 
        }
        public function get_user_image()
        {
            return $this->user_image ; 
        }
        public function get_user_status()
        {
            return $this->user_status  ; 
        }
        public function get_user_password()
        {
            return $this->user_password ;  
        }

        public function fetch_data($user_id)
        {
            $q = "SELECT * FROM $this->tbl WHERE user_id = :user_id" ; 
            $stmt = $this->con->prepare($q) ; 
            $stmt->execute(array( ':user_id' => $user_id )) ; 
            return $stmt ; 
        }
        public function __destruct()
        {
            $this->con = null ;     
        }
    }


?>