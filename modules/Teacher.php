<?php 
    class Teacher{
        private $con = null;
        private $tbl = 'users' ; 
        private $user_type = 'TEACHER' ; 

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
        public function get_main_category()
        {

            $data = array(
                "categores" => ['home', 'students', 'subjects', 'quizes', 'change password'],
                "icons" => ['<i class="fa-solid fa-house"></i>', '<i class="fa-solid fa-users"></i>', '<i class="fa-solid fa-list"></i>','<i class="fa-solid fa-pen-to-square"></i>','<i class="fa-solid fa-gear"></i>']

            ) ;
            return $data ; 
        }
        // get teacher data
        public function fetch_data($teacher_id)
        {
            $q = "SELECT * FROM $this->tbl WHERE user_id = :user_id" ; 
            $stmt = $this->con->prepare($q) ; 
            $stmt->execute(array( ':user_id' => $teacher_id )) ; 
            return $stmt ; 
        }
        // get teache subject count
        public function fetch_subject_count($teacher_id){
            $q = "SELECT COUNT(*) FROM subjects WHERE subject_publisher = :teacher_id" ; 
            $stmt = $this->con->prepare($q) ; 
            $stmt->execute(array( ':teacher_id' => $teacher_id )) ; 
            return $stmt->rowCount() ; 
        }
        // get teache student count
        public function fetch_student_count($teacher_id){
            $q = "SELECT COUNt(*) as number FROM `enrollments` WHERE enrollment_subject_id IN (SELECT subject_id FROM subjects WHERE subject_publisher = :teacher_id)" ; 
            $stmt = $this->con->prepare($q) ; 
            $stmt->execute(array( ':teacher_id' => $teacher_id )) ; 
            $row = $stmt->fetch() ; 
            return $row['number']; 
        }
        
        public function __destruct()
        {
            $this->con = null ;     
        }
    }


?>