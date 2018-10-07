<?

class User {
    
    private $user = Array("email", "username", "password"), $loggedin = false, $DBH;
    
    public function __construct(PDO $DBH) {
        $this->DBH = $DBH;
        $cookie = filter_input(INPUT_COOKIE, "__INSERT_COOKIE_NAME_HERE__");
        if (isset($cookie['username']) && isset($cookie['password'])) {
            $this->login($cookie['username'], $cookie['password'], true);
        } elseif (isset($_SESSION['user']['username']) && isset($_SESSION['user']['password'])) {
            $this->login($_SESSION['username']['username'], $_SESSION['username']['password']);
        }
    }
    
    public function login($username, $password, $savecookie = false) {
        $STH = $this->DBH->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
        $STH->execute(Array($username, $password));
        if($STH->rowCount() != 0) {
            $data = $STH->fetch(PDO::FETCH_ASSOC);
            $this->user['username'] = $username;
            $this->user['password'] = $password;
            $this->user['email'] = $data['email'];
            $_SESSION['user'] = $this->user;
            $savecookie ? setcookie('__INSERT_COOKIE_NAME_HERE__', $this->user, time() + 31557600) : "";
        } else {
            $this->logout();
        }
    }
    
    public function logout() {
        unset($_SESSION['user']);
        unset($this->user);
        setcookie('__INSERT_COOKIE_NAME_HERE__', '', time() - 3600);
    }
    
}
