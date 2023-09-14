<?php
class class_db
{
    /* VERİTABANI BAĞLANTISI İÇİN GEREKLİ PARAMETRELER TANIMLANDI.. */
    protected $pdo = null;
    protected $host = "localhost";
    protected $user = "root";
    protected $pass = "";
    protected $dbname = "arge_oturum";
    protected $charset = "utf8";
    protected $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    /* VERİTABANI BAĞLANTI KURULUMU */
    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset";
        try {
            $this->pdo = new PDO(
                $dsn,
                $this->user,
                $this->pass,
                $this->options
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    function getSecurity($data)
        //Security Funcs.
    {
        if(is_array($data))
        {
            $variable = array_map('htmlspecialchars', $data);
            $response = array_map('stripslashes', $variable);
            return $response;
        } else {
            $variable = htmlspecialchars($data);
            $response = stripslashes($variable);
            return $response;
        }
    }

    //db tekli veri çekme
    public function pdoQuerySingle($sql)
    {
        $query = $this->pdo->query($sql);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    //db veri ekleme
    public function pdoPrepareInsert($sql, $args = [])
    {
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($args);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        $lastInsertID = $this->pdo->lastInsertID();
        if ($lastInsertID) {
            return true;
        } else {
            return false;
        }
    }

    //  OTURUM YÖNETİMİ

    // yönlendirme fonksiyonu
    function yonlendir($url,$zaman = 0){
        if($zaman != 0){
            header("Refresh: $zaman; url=$url");
        }
        else header("Location: $url");
    }

    public function getPasswordEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = "."'".$email."'";
        $query = $this->pdoQuerySingle($sql);
        if ($query)
        {
            return $query;
        }else{
            return false;
        }
    }

    public function control($email,$password)
    {
        $email = $this->getSecurity($email);
        $password = $this->getSecurity($password);
        $login = $this->getPasswordEmail($email);

        if ($login != false)
        {
            if (password_verify($password,$login['password']))
            {
                $this->createToken($login['user_id']);
                $this->yonlendir("./index.php");
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //Session Funcs.  Begin  ******
    function createSession($name,$value)
        //Session Oluştur.
    {
        return $_SESSION[$name]=$value;
    }

    function isHaveSession($name)
        //Session Kontrolü
    {
        return isset($_SESSION[$name]) ? true : false;
    }

    function getSession($name)
        //Session Çek
    {
        if(self::isHaveSession($name))
        {
            return $_SESSION[$name];
        }else{
            return false;
        }
    }

    function delSession($name)
        //Session ı Sil
    {
        if (self::isHaveSession($name))
        {
            unset($_SESSION[$name]);
            $this->yonlendir("./login");
        }
    }

    function delAllSession()
        //Tüm Sessionları Sil
    {
        session_destroy();
    }
    //Session Funcs.  Finish   /*/*/*/*/

    //Token Begin ******
    function createToken($userid)
        //Token Oluştur
    {
        $token = md5(uniqid(mt_rand()));
        $this->insertTokenDb($userid,$token);
        return $this->createSession("auth",$token);
    }

    function controlToken($token)
        //Token Kontrol
    {
        if ($this->isHaveSession("auth") and $token == $this->getSession("auth"))
        {
            if ($this->controlTokenDb($token))
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function insertTokenDb($userid,$token)
    {
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO list_sessions (user_id,token,login_date) VALUES (?,?,?)";
        $args = [$userid,$token,$date];
        $query = $this->pdoPrepareInsert($sql,$args);
        if ($query)
        {
            return true;
        }else{
            return false;
        }
    }
    function controlTokenDb($token)
    {
        $sql = "SELECT * FROM list_sessions WHERE token="."'".$token."'";
        $query = $this->pdoQuerySingle($sql);
        if ($query)
        {
            return true;
        }else{
            return false;
        }
    }


}