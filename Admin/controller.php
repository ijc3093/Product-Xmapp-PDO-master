<?php 
    // DB credentials.
    // define('DB_HOST','127.0.0.1');
    // define('DB_USER','root');
    // define('DB_PASS','');
    // define('DB_NAME','shopping');

    //Xampp and phpmyadmin
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','');
    define('DB_NAME','shopping');

    // define('DB_HOST','catic21museai.mysql.database.azure.com');
    // define('DB_USER','catic21@catic21museai');
    // define('DB_PASS','Merciful#100');
    // define('DB_NAME','testDB');


    // Establish database connection.
    try{
        $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e){
        exit("Error: " . $e->getMessage());
    }
?>

<?php

    require_once '../Config/database.php';
    //require_once '../Config/config.php';

    class Controller{

        private $dbh;
        
        // private $server = "127.0.0.1";
        // private $username = "root";
        // private $password = "";
        // private $dbname = "shopping";

        //Xampp
        private $server = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "shopping";

        // private $server = "catic21museai.mysql.database.azure.com";
        // private $username = "catic21@catic21museai";
        // private $password = "Merciful#100";
        // private $dbname = "shopping";

        private $stmt;
        //Constructor
        function __construct(){
            $this->db = new Config2;
            //$this->dbh = null;
            
            try{
                $this->dbh = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->dbname, $this->username, $this->password);
                $this->dbh->exec("set names utf8");
                $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // enable exception mode
                $this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // enable exception mode

                // $options = array(
                //     PDO::MYSQL_ATTR_SSL_CA => '/var/www/html/BaltimoreCyberTrustRoot.crt.pem'
                // );
                // $this->dbh = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->dbname, $this->username, $this->password, $options);
                
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->dbh;

        }
        //////////////////////////////////////////////Register///////////////////////////////////////////////////////////////////////
        //Register insert
        function insertRegister_User($username, $password, $fullname, $upload_image, $date, $time, $role, $email){
            try{
                $password = hash("sha256", $password);
                $query = "insert into user (`username`, `password`, `fullname`, `upload_image`, `date`, `time`, `role`, `email`) values(?,?,?,?,?,?,?,?)";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $username, PDO::PARAM_STR);
                $stmt->bindParam(2, $password, PDO::PARAM_STR);
                $stmt->bindParam(3, $fullname, PDO::PARAM_STR);
                $stmt->bindParam(4, $upload_image, PDO::PARAM_STR);
                $stmt->bindParam(5, $date, PDO::PARAM_STR);
                $stmt->bindParam(6, $time, PDO::PARAM_STR);
                $stmt->bindParam(7, $role, PDO::PARAM_INT);
                $stmt->bindParam(8, $email, PDO::PARAM_INT);
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $return = 1;      
                }
                // $stmt->close();
                $this->dbh = null;
                return $return;
            }
            catch(PDOException $e){
                return $e->getMessage();
            }
        }
        //OR

        //Register insert (Create A New Account)
        public function register($data){
            $this->db->query('INSERT INTO user (username, password, fullname, upload_image, date, time, role, email) 
            VALUES (:username, :password, :fullname, :upload_image, :date, :time, :role, :email)');
            //Bind values
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':fullname', $data['fullname']);
            $this->db->bind(':upload_image', $data['upload_image']);
            $this->db->bind(':date', $data['date']);
            $this->db->bind(':time', $data['time']);
            $this->db->bind(':role', $data['role']);
            $this->db->bind(':email', $data['email']);

            //Execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }


        //Find user by email. Note, make sure that the email must be existed in database.
        public function findUserByEmailOrUsername($email, $username){
            $this->db->query('SELECT * FROM user WHERE username = :username OR email = :email');
            $this->db->bind(':username', $username);
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            //Check row
            if($this->db->rowCount() > 0){
                return $row;
            }else{
                return false;
            }
        }



        //////////////////////////////////////////////Login///////////////////////////////////////////////////////////////////////
        function login($username, $password){
            try{
                $stmt = $this->dbh->prepare("select iduser, role from user where username = ? and password = ?;");
                $password = hash("sha256", $password);

                $stmt->bindParam(1, $username, PDO::PARAM_STR);
                $stmt->bindParam(2, $password, PDO::PARAM_STR);
                $stmt->execute();
                $reply = $stmt->fetch();
                if($reply == null){
                    // $stmt->close();
                    $this->dbh = null;
                    return -1;
                }
                else{
                // User's role (userRole)
                $role = $reply['role'];
                // user id add here
                $id = $reply['iduser'];
                
                if($role == 1){
                    $_SESSION['userRole'] = 1;
                }

                else if($role == 2){
                    $_SESSION['userRole'] = 2;
                }

                else if($role == 3){
                    $_SESSION['userRole'] = 3;
                }

                if ( $role  ){
                    $_SESSION['userRole'] = 4;
                }
                $_SESSION['userRole'] = $role;

                $_SESSION['id'] = $id;
                
            }
            return 1;
            }catch(PDOException $e){
                echo $e->getMessage();
                return -1;
            }       
        }
        
        //User's session
        function userRole(){
            $username = $_SESSION['username'];
            $sql = "SELECT * from user where username = (:username);";
            $query = $this->dbh->prepare($sql);
            $query-> bindParam(':username', $username, PDO::PARAM_STR);
            $query->execute();
            $result=$query->fetch(PDO::FETCH_OBJ);
            if($result == null){
                // $stmt->close();
                $this->dbh = null;
                return -1;
            }
            $cnt=1;
        }

        ////////////////////////////////////////////////Admin///////////////////////////////////////////////////////////////////////
        //Admin delete from exactly table
        function admin_Delete($table,$id, $name){
            try{
                $query = "delete from " . $table . " where " . $name . ' = ' . $id;
                // var_dump($query);
                $stmt = $this->dbh->prepare($query);
            
                // $stmt->bindParam("i", $id);
                if($stmt->execute()){
                    // $stmt->close();
                    // dbh->close();
                    $return = 1;
                }
                else{
                    // $stmt->close();
                    // dbh->close();
                    $return = -1;
                }
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
            }
        }


        //Admin delete from exactly table
        function Delete($table, $id, $idName){
            try{
                $query = "delete from " . $table . " where " . $idName . " = ? and user = ?;";
                $stmt = $this->dbh->prepare($query);
                // TODO finish this bindParam()
                $stmt->bindParam("is", $id, $_SESSION["username"]);
                if($stmt->execute()){
                    //  $stmt->close();
                    //  $dbh->close();
                    return 1;
                }
                else{
                    // $stmt->close();
                    // dbh->close();
                    return -1;
                }
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
            }
        }

        //////////////////////////////////////////////Venue//////////////////////////////////////////////////////////////////////////
        //Update venue
        function update_Venue($name, $product, $id){
            try{
                $query = "update venue set name = ?, capacity = ? where idvenue = ?;";
                $stmt = $this->dbh->prepare($query);
                //$stmt->bindParam("sii", $name, $product, $id);
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $product, PDO::PARAM_INT);
                $stmt->bindParam(3, $id, PDO::PARAM_INT);
                return  $stmt->execute();
                //$stmt->close();
                //dbh->close();
            }catch(PDOException $pe){
                return ['failed', 'reason'=>$pe->getMessage()];
           }
        }


        //Get Venues output
        function get_Venues(){
            try{
                $data = array();
                $query = "select * from venue";
                $stmt = $this->dbh->prepare($query);
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                //dbh->close();
                return $data;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }

        //Get exact venue's information in array
        function get_Venue($id){
            try{
                $data = array();
                $query = "select * from venue where idvenue = ?;";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch();
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }


        function insert_Venue($name, $capacity){
            try{
                $query = "insert into venue (name, capacity) values(?,?)";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $capacity, PDO::PARAM_INT);
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $return = 1;      
                }
                //$stmt->close();
                //dbh->close();
                return $return;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }

        //////////////////////////////////////////////Products///////////////////////////////////////////////////////////////////////
        //Get Manager from product
        function get_Manager_products($id){
            try{
                $data = array();
                $query = "select product from manager_product where manager = " . $id. ";";
                $stmt = $this->dbh->prepare($query);
                $stmt->execute();
                if( $stmt != false ){
                    while(($row = $stmt->fetch())){
                        $query2 = "select idproduct, name, artist, whoisposted, year, datepost, time from product WHERE idproduct = " . $row['product'] . ";";
                        $stmt2 = $this->dbh->prepare($query2);
                        $stmt2->execute();
                        while($row2 = $stmt2->fetch()){
                            $data[] = $row2;
                        }
                    }
                }
                // $dbh->close();
                return $data;
            }catch(PDOException $pe){
                // echo $pe->getMessage();
                return ['failed', 'reason'=> $pe->getMessage()];
            }
        }

        //Get all products
        function get_products($productID = null){
            try{
                $data = array();
                $query = "select * from product";
                if( $productID != null ) {
                    $query .= " WHERE idproduct = " .$productID;
                }
                $stmt = $this->dbh->prepare($query);
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                //dbh->close();
                return $data;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
            }
        }

        //Get specific product with id and detail about product
        function get_product($id){
            //try and catch Avoid crash
            try{
                $data = array();
                $query = "select * from product where idproduct = ? ;";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                return $data;
            }
            catch(PDOException $pe){
                echo $pe->getMessage();
                return['failed'];
            }
        }

        //Information of products
        function getInfo_product(){
        try{
                $data = array();
                $stmt = $this->dbh->prepare("select product from manager_product where manager = '". $_SESSION["username"] . "';");
                while($row = $stmt->fetch()){
                    $stmt2 = $this->dbh->prepare("select * from product where idproduct = " .$row . ";");
                    while($row2 = $stmt->fetch()){
                        $data[] = $row2;
                    }
                }
                // dbh->close();
                return $data;
        }catch(PDOException $pe){
            echo $pe->getMessage();
            return[];
            }
        }


        //user store data in database server (insert into product and manager_product)
        function insert_product(
            $name, 
            $artist, 
            $year, 
            $datepost,
            $dateStart, 
            $dateEnd, 
            $numberAllowed, 
            $venue, 
            $description, 
            $image, 
            $location_image, 
            $video, 
            $location_video, 
            $time, 
            $qrCodeImage,
            $whoisposted,
            $role_ID
        ){
            $defaultErrorName = "error";
            try{
                $stmt = $this->dbh->prepare("insert into product(
                    name, 
                    artist, 
                    year, 
                    datepost,
                    datestart, 
                    dateend, 
                    numberallowed, 
                    venue, 
                    description, 
                    image, 
                    location_image, 
                    video, 
                    location_video,
                    time,
                    qrCodeImage,
                    whoisposted
                ) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");

                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $artist, PDO::PARAM_STR);
                $stmt->bindParam(3, $year, PDO::PARAM_STR);
                $stmt->bindParam(4, $datepost, PDO::PARAM_STR);
                $stmt->bindParam(5, $dateStart, PDO::PARAM_STR);
                $stmt->bindParam(6, $dateEnd, PDO::PARAM_STR);
                $stmt->bindParam(7, $numberAllowed, PDO::PARAM_INT);
                $stmt->bindParam(8, $venue, PDO::PARAM_INT);
                $stmt->bindParam(9, $description, PDO::PARAM_STR);
                $stmt->bindParam(10, $image, PDO::PARAM_STR);
                $stmt->bindParam(11, $location_image, PDO::PARAM_STR);
                $stmt->bindParam(12, $video, PDO::PARAM_STR);
                $stmt->bindParam(13, $location_video, PDO::PARAM_STR);
                $stmt->bindParam(14, $time, PDO::PARAM_STR);
                $stmt->bindParam(15, $qrCodeImage, PDO::PARAM_STR);
                $stmt->bindParam(16, $whoisposted, PDO::PARAM_STR);
                $stmt->execute();
        
                // retrieve newly product's ID
                // $mId = intval($this->dbh->lastInsertId());
                if($mId = intval($this->dbh->lastInsertId())){
                    $manager_ID = intval($role_ID);

                    //Insert manager

                    //echo "event ID: " . $mId . "\n";
                    //echo "manager ID: " . $role_ID . "\n";
                    $stmt1 = $this->dbh->prepare("insert into manager_product (product, manager) VALUES(?, ?);");
                    return $stmt1->execute([$mId,$manager_ID]);
                    //$last_id = $stmt1;
                }
                
                else if($mId = intval($this->dbh->lastInsertId())){
                    // retrieve newly ntid's ID
                    $ntid_ID = intval($role_ID);

                    //Insert NTID

                    //echo "event ID: " . $mId . "\n";
                    //echo "manager ID: " . $role_ID . "\n";
                    $stmt2 = $this->dbh->prepare("insert into ntid_product (product, ntid) VALUES(?, ?);");
                return $stmt2->execute([$mId,$ntid_ID]);
                }
            }catch(PDOException $pe){
                return [$defaultErrorName => $pe->getMessage()];
            }
        }

        

        //Attend product
        function attending_product($product, $user){
            try{
                //$stmt = $this->$dbh->prepare("insert into user set name = ?, password = ? role = ?;");
                $query = "insert into user_session (product, user) values(?,?)";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam("si", $product, $user);
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $return = 1;      
                }
                //$stmt->close();
                //dbh->close();
                return $return;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }



        //Update product
        function update_product(
            $name, 
            $artist, 
            $year, 
            $datepost,
            $dateStart, 
            $dateEnd, 
            $numberAllowed, 
            $venue, 
            $description, 
            $image, 
            $location_image,
            $time,  
            $id
        ){
            try{
                $data = array();
                $stmt = $this->dbh->prepare("
                update product set 
                name = ?, 
                artist = ?, 
                year = ?, 
                datepost = ?,
                datestart = ?, 
                dateend = ?, 
                numberallowed = ?, 
                venue = ?, 
                description = ?, 
                image = ?,
                location_image = ?,
                time = ? where 
                idproduct = ?;"
            );
            
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $artist, PDO::PARAM_STR);
                $stmt->bindParam(3, $year, PDO::PARAM_STR);
                $stmt->bindParam(4, $datepost, PDO::PARAM_STR);
                $stmt->bindParam(5, $dateStart, PDO::PARAM_STR);
                $stmt->bindParam(6, $dateEnd, PDO::PARAM_STR);
                $stmt->bindParam(7, $numberAllowed, PDO::PARAM_INT);
                $stmt->bindParam(8, $venue, PDO::PARAM_INT);
                $stmt->bindParam(9, $description, PDO::PARAM_STR);
                $stmt->bindParam(10, $image, PDO::PARAM_STR);
                $stmt->bindParam(11, $location_image, PDO::PARAM_STR);
                $stmt->bindParam(12, $time, PDO::PARAM_STR);
                $stmt->bindParam(13, $id, PDO::PARAM_INT);
                // TODO finish this bindParam()
                return $stmt->execute();
                // $stmt->close();
                // dbh->close();
            }catch(PDOException $pe){
                //echo $pe->getMessage(); OR
                echo "<script>alert('Data failed to update. Please require to upload same or unique image');</script>";
                return false;
            }
        }


        //Attend product
        function attending_Session($session, $user){
            try{
                //$stmt = $this->$dbh->prepare("insert into user set name = ?, password = ? role = ?;");
                $query = "insert into user_session (session, user) values(?,?)";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam("si", $session, $user);
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $return = 1;      
                }
                //$stmt->close();
                //dbh->close();
                return $return;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }


        //Output of all users as array
        function get_users($userRoleID = null){
            try{
                $data = array();
                $query = "select * from user";
                if($userRoleID != null) { 
                    $query .= " WHERE iduser = ?";
                    $stmt = $this->dbh->prepare($query);
                    $stmt->bindParam(1, $userRoleID, PDO::PARAM_INT);
                }
                else{
                    $stmt = $this->dbh->prepare($query);
                }
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                //dbh->close();
                return $data;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return ['failed','reason'=>$pe->getMessage()];
           }
        }


        //Get exact user's information in array
        function get_user($id){
            try{
                $data = array();
                $query = "select * from user where iduser = ?;";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                return $data;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }

        //Update Role
        function update_User($username, $fullname, $upload_image, $role, $id){
            try{
                $stmt = $this->dbh->prepare(
                    "update user set 
                    username = ?, 
                    fullname = ?,
                    upload_image = ?,
                    role = ? where 
                    iduser = ?;"
                );
                // TODO finish this bindParam()
                $stmt->bindParam(1, $username, PDO::PARAM_STR);
                $stmt->bindParam(2, $fullname, PDO::PARAM_STR);
                $stmt->bindParam(3, $upload_image, PDO::PARAM_STR);
                $stmt->bindParam(4, $role, PDO::PARAM_INT);
                $stmt->bindParam(5, $id, PDO::PARAM_INT);
                return $stmt->execute();
                // $stmt->close();
                // dbh->close();
            }catch(PDOException $pe){
                //echo $pe->getMessage();
                echo "<script>alert('Data failed to update. Please require to upload same or unique image');</script>";
                return ['failed','reason'=>$pe->getMessage()];
            }
        }

        //////////////////////////////////////////////Forget and Reset Password///////////////////////////////////////////////////////////////////////
        //Delete old password
        public function deleteEmail($email){
            $this->db->query('DELETE FROM pwdreset WHERE pwdResetEmail=:email');
            $this->db->bind(':email',$email);
            //Execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        //Password Reset Insert with Token for (Send the email)
        function insertToken($email, $selector, $hashedToken, $expires){
            try{
                $query = "insert into pwdreset (`pwdResetEmail`, `pwdResetSelector`, `pwdResetToken`, `pwdResetExpires`) values(?,?,?,?)";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
                $stmt->bindParam(2, $selector, PDO::PARAM_STR);
                $stmt->bindParam(3, $hashedToken, PDO::PARAM_STR);
                $stmt->bindParam(4, $expires, PDO::PARAM_STR);
    
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $return = 1;      
                }
                // $stmt->close();
                $this->dbh = null;
                return $return;
            }
            catch(PDOException $e){
                return $e->getMessage();
            }
        }
        
        //The link is no longer valid
        public function resetPasswords($selector, $currentDate){
            $this->db->query('SELECT * FROM pwdreset WHERE  pwdResetSelector=:selector AND pwdResetExpires >= :currentDate');
            $this->db->bind(':selector',$selector);
            $this->db->bind(':currentDate',$currentDate);
            //Execute
            $row = $this->db->single();
    
            //Check row
            if($this->db->rowCount() > 0){
                return $row;
            }else{
                return false;
            }
        }      
        
        //Create New Password
        public function resetPassword($newPwdHash, $tokenEmail){
            $this->db->query('UPDATE user SET password=:pwd WHERE email=:email');
            $this->db->bind(':pwd', $newPwdHash);
            $this->db->bind(':email', $tokenEmail);

            //Execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

    }
    
?>