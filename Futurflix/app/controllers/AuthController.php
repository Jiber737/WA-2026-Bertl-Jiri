<?php
require_once '../core/Controller.php';

class AuthController extends Controller {

    
    // Výchozí metoda, pokud někdo zadá jen ?url=auth
    public function index() {
        // Pokud už je uživatel přihlášený, hodíme ho na jeho profil
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/profile');
            exit;
        } else {
            // Pokud přihlášený není, pošleme ho na přihlašovací formulář
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
    }

    // 2. Zobrazení profilu (TADY SE DĚLA SMYČKA, POKUD TOTO CHYBĚLO NEBO BYLO ŠPATNĚ UMÍSTĚNO)
    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro zobrazení profilu se musíš nejdříve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/User.php';
        require_once '../app/models/Video.php';
        
        $db = (new Database())->getConnection();
        $userModel = new User($db);
        $videoModel = new Video($db);

        $user = $userModel->findById($_SESSION['user_id']);
        $videos = $videoModel->getByUserId($_SESSION['user_id']);

        require_once '../app/views/webpages/my_profile.php';
    }
    
    // 1. Zobrazení registračního formuláře
    public function register() {
        require_once '../app/views/auth/register.php';
    }

    // 2. Zpracování registrace
    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $firstName = htmlspecialchars($_POST['first_name'] ?? '');
            $lastName = htmlspecialchars($_POST['last_name'] ?? '');
            $nickname = htmlspecialchars($_POST['nickname'] ?? '');
            
            // Hesla neočišťujeme přes htmlspecialchars, aby se nerozbily speciální znaky
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $this->addErrorMessage('Vyplňte prosím všechna povinná pole.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            if ($password !== $passwordConfirm) {
                $this->addErrorMessage('Zadaná hesla se neshodují.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';
            
            $db = (new Database())->getConnection();
            $userModel = new User($db);

            if ($userModel->register($username, $email, $password, $firstName, $lastName, $nickname)) {
                $this->addSuccessMessage('Registrace byla úspěšná. Nyní se můžete přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            } else {
                $this->addErrorMessage('Uživatel s tímto e-mailem již existuje.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }
        }
    }

    // 3. Zobrazení přihlašovacího formuláře
    public function login() {
        require_once '../app/views/auth/login.php';
    }

    // 4. Ověření přihlášení (autentizace)
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';
            
            $db = (new Database())->getConnection();
            $userModel = new User($db);

            $user = $userModel->findByEmail($email);

            // Bezpečné ověření hesla vůči hashi v DB
            if ($user && password_verify($password, $user['password'])) {
                
                // Uložení stavu do Session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = !empty($user['nickname']) ? $user['nickname'] : $user['username'];

                $_SESSION['is_admin'] = $user['is_admin'];

                $this->addSuccessMessage('Vítejte zpět na Futurflixu, ' . $_SESSION['user_name'] . '!');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                // Obecná hláška kvůli bezpečnosti
                $this->addErrorMessage('Nesprávný e-mail nebo heslo.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
        }
    }

    // 5. Odhlášení
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        
        $this->addSuccessMessage('Byli jste úspěšně odhlášeni.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // Pomocné metody pro zprávy
    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }
    protected function addNoticeMessage($message) {
        $_SESSION['messages']['notice'][] = $message;
    }
    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }
}