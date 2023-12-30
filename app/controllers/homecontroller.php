<?php
namespace MVC\controllers;
use MVC\core\controller;
use MVC\models\register;
use MVC\models\user;
use Rakit\Validation\Validator;
use MVC\core\Session;
use MVC\core\helper;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use MVC\models\index;
class homecontroller extends controller{
    public function __construct()
    {
        session::Start();
    }

    public function index(){
        $index = new index();
        $products = $index->latest_products();
    $title = "index";
  $this->view("home/index",['title'=>$title,'products'=>$products]);

}
    public function checkout()
    {
        $this->view('home/check_out', ['title' => 'checkout']);
    }
    public function about_us()
    {
        $this->view('home/about_us', ['title' => 'about_us']);
    }
    public function contact_us()
    {
        $this->view('home/contact_us', ['title' => 'contact_us']);
    }
public  function postlogin(){
    $this->view('home/login',['title'=>'login']);
    $validator = new Validator;

    $validation = $validator->validate($_POST, [
        'email'                 => 'required|email',
        'password'              => 'required|min:6',

        ]);

    if ($validation->fails()) {
        // handling errors
        $errors = $validation->errors();
        echo "<pre>";
        print_r($errors->firstOfAll());
        echo "</pre>";
        exit;
    } else {
        // validation passes
        $user = new user();
            $data = $user->getuser($_POST['email'],$_POST['password']);
        session::Set('user',$data);
helper::redirect("user/index");
    }
}

public function contact_us_mail(){

        $name = $_POST["full_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $msg = $_POST["msg"];

        $errors = [];

        if (empty($name)) {
            $errors['name'] = "Full name is required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email address.";
        }

        if (!preg_match("/^[0-9]+$/", $phone)) {
            $errors['phone'] = "Invalid phone number.";
        }

        if (empty($msg)) {
            $errors['msg'] = "Message is required.";
        }

        if (count($errors) > 0) {
            $this->view('home/contact_us', ['title' => 'login', 'errors' => $errors]);
            return;
        }

        $error = null;

        try {
            // Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            // Server settings
            // Enable verbose debug output
            $mail->isSMTP();  // Send using SMTP
            $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to send through
            $mail->SMTPAuth = true;  // Enable SMTP authentication
            $mail->Username = 'asustuf576@gmail.com';  // SMTP username
            $mail->Password = 'bnhqcnezkhvhtthz';  // SMTP password
            $mail->SMTPSecure = 'ssl';  // Enable implicit TLS encryption
            $mail->Port = 465;  // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress('asustuf576@gmail.com', 'Asus');  // Add a recipient

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $msg;
            $mail->Body = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'this is a test';

            if ($mail->send()) {
                $this->view('home/contact_us', ['title' => 'login', 'result' => 'the msg was send sucessfully']);
            } else {
                $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } catch (Exception $e) {
            $error = "Invalid address: " . $e->getMessage();
        }

        if ($error) {
            $this->view('home/contact_us', ['title' => 'login', 'error' => $error]);
        }
    }

    public function test()
    {
       $this->view('home/test',['title'=>'title']);
    }
}