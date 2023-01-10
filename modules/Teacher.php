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
        // get teacher student count
        public function fetch_student_count($teacher_id){
            $q = "SELECT COUNt(*) as number FROM `enrollments` WHERE enrollment_subject_id IN (SELECT subject_id FROM subjects WHERE subject_publisher = :teacher_id)" ; 
            $stmt = $this->con->prepare($q) ; 
            $stmt->execute(array( ':teacher_id' => $teacher_id )) ; 
            $row = $stmt->fetch() ; 
            return $row['number']; 
        }
        // get teacher subjects
        public function get_subject_title($teacher_id)
        {
            $q = "SELECT * FROM `subjects` WHERE subject_status = 'ACTIVE' AND subject_publisher = :teacher_id" ; 
            $stmt = $this->con->prepare($q) ; 
            $stmt->execute(array(':teacher_id' => $teacher_id )) ; 
            return $stmt ; 
        }
        
        // get teacher subject details
        public function get_subject_details($subject_id, $teacher_id)
        {
            $q = "SELECT subject_title, subject_status, subject_code, COUNT(enrollments.enrollment_student_id) AS students_num 
                    FROM `subjects` LEFT JOIN enrollments 
                    ON subject_id= enrollments.enrollment_subject_id 
                    WHERE subject_publisher = :teacher_id
                    AND subject_id = :subject_id
                    GROUP BY(subject_title)" ; 
            $stmt = $this->con->prepare($q) ; 
            $stmt->execute(array(
                ':teacher_id' => $teacher_id,
                ':subject_id' => $subject_id
                )) ; 
            return $stmt ; 
        }
        
        public function __destruct()
        {
            $this->con = null ;     
        }
    }


?>