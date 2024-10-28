<?php 
    // DB credentials.
    // define('DB_HOST','127.0.0.1');
    // define('DB_USER','root');
    // define('DB_PASS','');
    // define('DB_NAME','shopping');


    //Xampp and phpmyadmin
    define('DB_HOST','127.0.0.1');
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

    class Config{

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
        // private $dbname = "testDB";

        private $stmt;
        //Constructor
        function __construct(){
            $this->dbh = null;
            
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

        }//End of function constructor
    }

?>