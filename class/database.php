<?
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(-1);

session_start();
include('jdf.php');
date_default_timezone_set("Asia/Tehran");

class MyDB
{

    protected $_DB_HOST = 'localhost';
    protected $_DB_USER = 'root';
    protected $_DB_PASS = '';
    protected $_DB_NAME = 'hamitech';
    protected $_conn;

    public function __construct()
    {
        $this->_conn = mysqli_connect($this->_DB_HOST, $this->_DB_USER, $this->_DB_PASS);
        if ($this->_conn) {
            $this->_conn->query("SET NAMES 'utf8'");
            $this->_conn->query("SET CHARACTER SET 'utf8'");
            $this->_conn->query("SET character_set_connection = 'utf8'");

        }
        date_default_timezone_set("Asia/Tehran");
    }

    public function connect()
    {
        if (!mysqli_select_db($this->_conn, $this->_DB_NAME)) {
            die("1st time failed<br>");
        }
        date_default_timezone_set("Asia/Tehran");
        return $this->_conn;
    }
}

class Action
{

    protected $_conn;

    public function __construct()
    {
        $db = new MyDB();
        $this->_conn = $db->connect();
        date_default_timezone_set("Asia/Tehran");
    }


    public function dbconnect()
    {
        $db = new MyDB();
        $this->connect = $db->connect();
        date_default_timezone_set("Asia/Tehran");
    }

    //This is a HORRIBLE way to check your login. Please change your logic here. I am just kind of re-using what you got
    public function ownerlog($username, $password)
    {
        $result = $this->_conn->query("SELECT * FROM tbl_admin WHERE username ='$username' AND password='$password'");

        if (!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return false;
        }

        return $result->fetch_row() > 0;
    }

    public function cleansql($string)
    {
        $string = htmlspecialchars($string);
        $string = stripslashes($string);
        $string = strip_tags($string);
        $string = mysqli_real_escape_string($this->_conn, $string);
        return $string;
    }

    public function condate($date)
    {
        $pieces = explode("/", $date);
        $day = $pieces[2];
        $month = $pieces[1];
        $year = $pieces[0];
        $b = jalali_to_gregorian($year, $month, $day, $mod = '-');
        $f = $b[0] . '-' . $b[1] . '-' . $b[2];
        return $f;
    }

    public function condatesh($date)
    {
        $pieces = explode("-", $date);
        $year = $pieces[0];
        $month = $pieces[1];
        $day = $pieces[2];
        $b = gregorian_to_jalali($year, $month, $day, $mod = '-');
        $f = $b[0] . '/' . $b[1] . '/' . $b[2];
        return $f;
    }

    public function send_sms($mobile, $textMessage)
    {

        $webServiceURL = "";
        $webServiceSignature = "";
        $webServiceNumber = "";

        $textMessage = mb_convert_encoding($textMessage, "UTF-8"); // encoding to utf-8

        $parameters['signature'] = $webServiceSignature;
        $parameters['toMobile'] = $mobile;
        $parameters['smsBody'] = $textMessage;
        $parameters['retStr'] = ""; // return reference send status and mobile and report code for delivery

        try {
            $con = new SoapClient($webServiceURL);
            $responseSTD = (array)$con->Send($parameters);
            $responseSTD['retStr'] = (array)$responseSTD['retStr'];
        } catch (SoapFault $ex) {
            echo $ex->faultstring;
        }

    }

    public function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[rand(0, $max - 1)];
        }

        return $token;
    }

    public function adminlogin($user, $pass)
    {

        $result = $this->_conn->query("SELECT * FROM tbl_admin WHERE username='$user' AND password='$pass'");

        if (!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 1;
        }
        $rowcount = mysqli_num_rows($result);
        $rowd = mysqli_fetch_assoc($result);
        if ($rowcount > 0) {
            $_SESSION['adminlog'] = $rowd['id'];
            return 1;
        } else {
            return 0;
        }
    }

    public function add_user($name, $phone, $code, $bdate, $status)
    {

        $datenow = strtotime(date('Y-m-d H:i:s'));

        $result = $this->_conn->query("INSERT INTO `tbl_user`(`name`, `phone`, `codemeli`, `bdate`, `status`, `cdate`) 
		VALUES ('$name','$phone','$code','$bdate','$status','$datenow')");

        if (!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }

        return 1;

    }

    public function edit_user($id, $name, $phone, $code, $bdate, $status)
    {

        $result = $this->_conn->query("UPDATE `tbl_user` SET 
          `name`='$name',
          `phone`='$phone',
          `codemeli`='$code',
          `bdate`='$bdate',
          `status`='$status'
        WHERE id='$id'");

        if (!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }

        return 1;
    }

    public function remove_user($id)
    {

        $result = $this->_conn->query("DELETE FROM tbl_user WHERE id=$id");

        if (!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }

        return 1;
    }


}


