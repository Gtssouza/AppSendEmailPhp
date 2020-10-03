<?php

    require "./libs/PhpMailer/Exception.php";
    require "./libs/PhpMailer/OAuth.php";
    require "./libs/PhpMailer/PHPMailer.php";
    require "./libs/PhpMailer/POP3.php";
    require "./libs/PhpMailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);


    class Mensagem{
        private $para = null;
        private $assunto = null;
        private $mensagem = null;

        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function mensagemValida(){
            if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
                return false;
            }
            return true;
        }
    }

    $mensagem = new Mensagem();

    $mensagem->__set('para',$_POST['para']);
    $mensagem->__set('assunto',$_POST['assunto']);
    $mensagem->__set('mensagem',$_POST['mensagem']);

    if(!$mensagem->mensagemValida()){
        echo 'Mensagem não é valida';
        die();//descarta daqui para baixo
    }

    $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = '';                     // SMTP username
    $mail->Password   = '';                               // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('gtssouza94@gmail.com', 'TESTANDO');
    $mail->addAddress('gtssouza94@gmail.com', 'Destinatario');     // Add a recipient
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Não foi possivel enviar este e-mail. Mailer Error: {$mail->ErrorInfo}";
}
?>