<?
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(-1);

session_start();
include('jdf.php');
date_default_timezone_set("Asia/Tehran");

class DB
{

    protected $_DB_HOST = 'localhost';
    protected $_DB_USER = 'root';
    protected $_DB_PASS = '';
    protected $_DB_NAME = 'hamitech';
    protected $connection;

    public function __construct()
    {
        $this->connection = mysqli_connect($this->_DB_HOST, $this->_DB_USER, $this->_DB_PASS,  $this->_DB_NAME);
        if ($this->connection) {
            $this->connection->query("SET NAMES 'utf8'");
            $this->connection->query("SET CHARACTER SET 'utf8'");
            $this->connection->query("SET character_setconnectionection = 'utf8'");
        }
    }

    public function connect()
    {
        return $this->connection;
    }

}

class Action
{

    public $connection;

    public function __construct()
    {
        $db = new DB();
        $this->connection = $db->connect();
    }

    public function result($result)
    {
        if (!$result) {
            $errorno = mysqli_errno($this->connection);
            $error = mysqli_error($this->connection);
            echo "Error NO : $errorno";
            echo "<br>";
            echo "Error Message : $error";
            echo "<hr>";
            return 0;
        }
        return 1;
    }

    public function get_data($table, $id, $data)
    {
        $result = $this->connection->query("SELECT * FROM `$table` WHERE id='$id'");
        if (!$this->result($result)) return 0;
        $row = $result->fetch_object();
        return $row->{$data};
    }

    public function get_date_shamsi($timestamp)
    {
        return $this->miladi_to_shamsi(date('Y-m-d', $timestamp));
    }

    public function remove_data($table, $id)
    {
        $result = $this->connection->query("DELETE FROM `$table` WHERE id='$id'");
        if (!$this->result($result)) return 0;
        return 1;
    }

    public function clean($string, $status = true)
    {
        if ($status)
            $string = htmlspecialchars($string);
        $string = stripslashes($string);
        $string = strip_tags($string);
        $string = mysqli_real_escape_string($this->connection, $string);
        return $string;
    }

    public function request($name, $status = true)
    {
        return $this->clean($_REQUEST[$name], $status);
    }

    public function get_date_miladi($name)
    {
        $name = $this->request('birthday');
        $name = $this->miladi_to_shamsi($name);
        return strtotime($name);
    }

    public function shamsi_to_miladi($date)
    {
        $pieces = explode("/", $date);
        $day = $pieces[2];
        $month = $pieces[1];
        $year = $pieces[0];
        $b = jalali_to_gregorian($year, $month, $day, $mod = '-');
        $f = $b[0] . '-' . $b[1] . '-' . $b[2];
        return $f;
    }

    public function miladi_to_shamsi($date)
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
        $textMessage = mb_convert_encoding($textMessage, "UTF-8");
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

    public function get_token($length)
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

    public function admin_login($user, $pass)
    {
        $result = $this->connection->query("SELECT * FROM `tbl_admin` WHERE `username`='$user' AND `password`='$pass' AND status=1");
        if (!$this->result($result)) return 0;
        $rowcount = mysqli_num_rows($result);
        $row = $result->fetch_object();

        if ($rowcount > 0) {
            $this->admin_update_last_login($row->id);
            $_SESSION['user_ll'] = $this->admin_get_last_login($row->id);
            $_SESSION['user_id'] = $row->id;
            return 1;
        }

        return 0;
    }

    public function admin_update_last_login($id)
    {
        $now = strtotime(date('Y-m-d H:i:s'));
        $result = $this->connection->query("UPDATE `tbl_admin` SET `last_login`='$now' WHERE `id`='$id'");
        if (!$this->result($result)) return 0;
        return 1;
    }

    public function admin_get_last_login($id)
    {
        $result = $this->connection->query("SELECT * FROM `tbl_admin` WHERE `id`='$id'");
        if (!$this->result($result)) return 0;
        $row = $result->fetch_object();
        return $row->last_login;
    }

    public function admin_get_data($id, $data)
    {
        return $this->get_data("tbl_admin", $id, $data);
    }

    public function user_add($first_name, $last_name, $national_code, $phone, $username, $password, $birthday, $status)
    {
        $now = time();

        $result = $this->connection->query("INSERT INTO `tbl_user`
        (`first_name`,`last_name`,`national_code`,`phone`,`username`,`password`,`birthday`,`status`,`created_at`) 
        VALUES
        ('$first_name','$last_name','$national_code','$phone','$username','$password','$birthday','$status','$now')");
        if (!$this->result($result)) return 0;

        return $this->connection->insert_id;
    }

    public function user_edit($id, $first_name, $last_name, $national_code, $phone, $username, $password, $birthday, $status)
    {
        $now = time();
        $result = $this->connection->query("UPDATE `tbl_user` SET 
        `first_name`='$first_name',
        `last_name`='$last_name',
        `national_code`='$national_code',
        `phone`='$phone',
        `username`='$username',
        `password`='$password',
        `birthday`='$birthday',
        `status`='$status',
        `updated_at`='$now'
        WHERE `id` ='$id'");

        if (!$this->result($result)) return 0;

        return $id;
    }

    public function user_remove($id)
    {
        return $this->remove_data("tbl_user", $id);
    }

    public function user_get_data($id, $data)
    {
        return $this->get_data("tbl_user", $id, $data);
    }


}


