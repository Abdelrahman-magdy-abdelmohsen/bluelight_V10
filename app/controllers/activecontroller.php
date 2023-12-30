<?php
namespace MVC\controllers;
use MVC\core\controller;
use MVC\core\model;
use MVC\models\login;
use MVC\models\register;
use Rakit\Validation\Validator;
use MVC\core\Session;
use MVC\core\helper;
use MVC\models\verify;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use MVC\models\forgot_password;
class activecontroller extends controller
{

    public function email_verify()
    {
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $email = $_POST['email'];

            // Additional validation if needed (e.g., email format validation)

            $verifyModel = new verify();
            $userExists = $verifyModel->check_email($email);
            $user_data = $verifyModel->get_user($email);
            $status = $user_data['status'];
            $id = $user_data['id'];
            if ($userExists) {
                if ($status === 'verified') {
                    // If the status is 'Verified', inform the user that the email is already verified
                    $this->view('account/email_verify', ['message' => 'Email is already verified.']);
                    exit;
                }

                $token = $verifyModel->get_token($email);
                $token = $token[0];

                // Sending email verification
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'asustuf576@gmail.com';
                    $mail->Password = 'bnhqcnezkhvhtthz';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    // Email content
                    $mail->setFrom('asustuf576@gmail.com', 'Mailer');
                    $mail->addAddress($email); // Sending to the entered email address
                    $mail->isHTML(true);
                    $mail->Subject = 'Verify email for bluelight website';
                    $mail->Body = 'This code is secret. Do not share it with anyone to activate your account. Click <a href="http:bluelight.com/verify/' . $id . '/token=' . $token . '">here</a> to activate your account.';
                    $mail->AltBody = 'This is a test.';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

                $this->view('account/email_verify', ['title' => 'active_email']);
                exit;
            } else {
                // Email does not exist in the database
                $this->view('account/email_verify', ['message' => 'Email does not exist.']);
                exit;
            }
        } else {
            // Email field is empty
            $this->view('account/email_verify', ['message' => 'Email field is empty.']);
            exit;
        }
    }


    public function verify($id, $token)
    {
        if (isset($id) && isset($token)) {
            $verification = new verify();
            $checkResult = $verification->check_token($id, $token);

            if ($checkResult > 0) {
                $isActive = $verification->check_verification($id);

                if ($isActive) {
                    // User is not active, update status to 'verified'
                    $verification->update_status($id);
                    helper::redirect('index'); // Redirect to homepage after successful verification
                } else {
                    // User is already active, redirect to the homepage or a different page
                    helper::redirect('index');
                }
            } else {
                // Invalid token or user not found, handle the error (e.g., display an error message)
                helper::redirect('index');
            }
        }
    }


    public function reset_pass()
    {
        $this->view('account/reset_pass', ['title' => 'reset_pass']);
        // All checks passed, proceed to register the user
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $token = '';
        for ($i = 0; $i < 20; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $token .= $characters[$randomIndex];
        }
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $email = $_POST['email'];
            // Additional validation if needed (e.g., email format validation)
            date_default_timezone_set('egypt');
            $verifyModel = new verify();
            $userExists = $verifyModel->check_email($email);
            $user_data = $verifyModel->get_user($email);
            if ($user_data) {
                $id = $user_data['id'];
            }

            if ($userExists) {
                $send = new forgot_password();
                $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
                $send->update_token($email, $token, $expires_at);
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'asustuf576@gmail.com';
                    $mail->Password = 'bnhqcnezkhvhtthz';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    // Email content
                    $mail->setFrom('asustuf576@gmail.com', 'Mailer');
                    $mail->addAddress($email); // Sending to the entered email address
                    $mail->isHTML(true);
                    $mail->Subject = 'Verify email for bluelight website';
                    $mail->Body = 'This code is secret. Do not share it with anyone to activate your account. Click <a href ="http:bluelight.com/active/set_pass/' . $id . '/token=' . $token . '">here</a> reset your password .';
                    $mail->AltBody = 'This is a test.';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

            } else {
                echo 'this account is not exist';
            }
        }
    }

    public function set_pass($id, $token) {
        $data = new forgot_password();
        try {
            // Sanitize and validate inputs
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $token = filter_var($token, FILTER_SANITIZE_STRING);
            if (!$id || !$token) {
                echo "Invalid parameters provided.";
                return;
            }
            // Check if user exists with the given ID using prepared statements
            $user_data = $data->get_user_by_id($id);

            if (!$user_data) {
                throw new Exception("User not found.");
            }

            // Get the token from the database for the user
            $db_token = $user_data['pass_token'];

            // Check token expiration
            date_default_timezone_set('egypt');
            $current_timestamp = date('Y-m-d H:i:s');
            $expiry_timestamp = $user_data['expires_at'];
            if ($current_timestamp > $expiry_timestamp) {
                throw new Exception("Expired.");
            }

            // Compare tokens in a secure manner
            $tokenMatches = hash_equals($db_token, $token);

            if ($tokenMatches) {
                // Redirect to the password reset confirmation form
                $this->set_pass_confirm($id, $token);
            } else {
                throw new Exception("Invalid token.");
            }
        } catch (Exception $e) {
            // Log errors and display user-friendly messages based on specific exceptions
            if ($e->getMessage() === "Expired.") {
                echo "Reset link has expired.";
            } elseif ($e->getMessage() === "Invalid token.") {
                echo "Invalid token provided.";
            } elseif ($e->getMessage() === "User not found.") {
                echo "User not found.";
            } else {
                error_log($e->getMessage());
                echo "Something went wrong. Please try again later.";
            }
        }
    }

    public function set_pass_confirm($id, $token) {
        $data = new forgot_password();
        try {
            // Validate form inputs
            $validator = new Validator;
            if (isset($_POST['password']) && isset($_POST['con_pass'])) {
                $password = $_POST["password"];
                $con_pass = $_POST["con_pass"];
            }
            // Validate form inputs
            $validation = $validator->validate($_POST, [
                'password' => 'required|min:6',
                'con_pass' => 'required|same:password',
            ]);
            if ($validation->fails()) {
                // Get validation errors
                $validationErrors = $validation->errors();
                $errors = [
                    'password' => $validationErrors->first('password'),
                    'con_pass' => $validationErrors->first('con_pass'),
                ];
                $this->view('account/reset_pass_change', ['title'=>'test','errors' => $errors]);
                exit;
            }
            // Retrieve user data (if needed)
            $user_data = $data->get_user_by_id($id);
            // Additional token checks or other validations if required
            // ...
            // Hash and update the password securely
            echo $password;
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $data->update_user_password($hashedPassword,$id);
            // Optionally, clear or invalidate the used token
            // Redirect the user to a success page
            helper::redirect('home/index');
            exit;
        } catch (Exception $e) {
            // Log errors and display user-friendly messages
            error_log($e->getMessage());
            echo "Something went wrong. Please try again later.";
        }
    }


}

?>