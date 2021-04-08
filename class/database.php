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

    public function cleansql($string)
    {
        $string = htmlspecialchars($string);
        $string = stripslashes($string);
        $string = strip_tags($string);
        $string = mysqli_real_escape_string($this->_conn, $string);
        return $string;
    }


    public function cleantext($string) {
        $string = stripslashes($string);
        $string = mysqli_real_escape_string($this->_conn,$string);
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

    public function tbl_counter($tbl) {
        $result = $this->_conn->query("SELECT * FROM $tbl");
        if(!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }
        return mysqli_num_rows($result);
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

    public function admin_login($user,$pass) {
        $result = $this->_conn->query("SELECT * FROM tbl_admin WHERE username='$user' AND password='$pass' AND status=1");

        if(!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }

        $rowcount=mysqli_num_rows($result);
        $rowd=mysqli_fetch_assoc($result);

        if($rowcount>0){
            $this -> admin_update_last_login($rowd['id']);
            $_SESSION['user_ll'] = $this->admin_get_last_login($rowd['id']);
            $_SESSION['user_id'] = $rowd['id'];
            return 1;
        }

        return 0;
    }

    public function admin_update_last_login($id) {
        $now=strtotime(date('Y-m-d H:i:s'));
        $result = $this->_conn->query("UPDATE tbl_admin SET last_login='$now' WHERE id='$id'");
        if(!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }
        return 1;
    }

    public function admin_get_last_login($id) {
        $result = $this->_conn->query("SELECT * FROM tbl_admin WHERE id='$id'");

        if(!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }

        $rowcount=mysqli_num_rows($result);
        $rowd=mysqli_fetch_assoc($result);

        if($rowcount>0){
            return $rowd['last_login'];
        }
        return 0;
    }

    public function admin_get_name($id) {
        $result = $this->_conn->query("SELECT * FROM tbl_admin WHERE id='$id'");

        if (!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }

        $rowcount=mysqli_num_rows($result);
        $rowd=mysqli_fetch_assoc($result);

        if($rowcount>0){
            return $rowd['fullname'];
        }
        return 0;
    }

    public function user_add($fullname, $codemeli ,$phone, $pin, $bdate, $status) {
        $now=strtotime(date('Y-m-d H:i:s'));

        $result = $this->_conn->query("INSERT INTO `tbl_user`
        (`fullname`, `codemeli`, `phone`, `pin`, `bdate`, `status`, `cdate`) 
        VALUES
	    ('$fullname','$codemeli','$phone','$pin','$bdate','$status','$now')");

        if (!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }

        return $this->_conn->insert_id;
    }

    public function user_edit($id, $fullname, $codemeli ,$phone, $pin, $bdate, $status) {
        $result = $this->_conn->query("UPDATE `tbl_user` SET 
        `fullname`='$fullname',
        `codemeli`='$codemeli',
        `phone`='$phone',
        `pin`='$pin',
        `bdate`='$bdate',
        `status`='$status'
        WHERE `id` ='$id'");

        if(!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }

        return $id;
    }
    public function user_remove($id) {
        $result = $this->_conn->query("DELETE FROM tbl_user WHERE id=$id");

        if (!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return 0;
        }

        return 1;
    }

    public function user_get_data($id, $data) {
        $result = $this->_conn->query("SELECT * FROM tbl_user WHERE id='$id'");
        if(!$result) {
            echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
            return false;
        }
        $rowcount=mysqli_num_rows($result);
        $rowd=mysqli_fetch_assoc($result);
        if($rowcount>0){
            return $rowd[$data];
        }
    }



}


