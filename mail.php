<?php  
//Composer's autoload file loads all necessary files
require 'vendor/autoload.php';
if(isset($_POST['email'])){
  $email = htmlspecialchars(strip_tags($_POST['email']));
  $mail = new PHPMailer;
  $mail->isSMTP();  // Set mailer to use SMTP
  $mail->Host = 'smtp.mailgun.org';  //  
  $mail->SMTPAuth = true; // Enable SMTP authentication
  $mail->Username = 'postmaster@sandbox111d367d93c34256922f0663081a5984.mailgun.org';
  $mail->Password = '4372c6a0e5e3f218d78d7bf31986af2c-816b23ef-a1fd0523';
  $mail->SMTPSecure = 'tls';   // Enable encryption, 'ssl'
  $mail->SMTPOptions = array(
              'ssl' => array(
                  'verify_peer' => false,
                  'verify_peer_name' => false,
                  'allow_self_signed' => true
              )
          );
  $mail->SMTPDebug = 0
  //$mail->From = 'sandbox111d367d93c34256922f0663081a5984.mailgun.org'; 
  $mail->setFrom('info@lancers.app', 'Lancers.app');
  //$mail->FromName = 'Lancers.app'; // The NAME field which will be displayed on arrival by the email client
  $mail->addAddress($email);     // change to email from the text feild
  $mail->isHTML(true);   // Set email to be sent as HTML, if you are planning on sending plain text email just set it to false
  // The following is self explanatory
  $mail->Subject = 'Thank you for subscribing';
  $mail->Body    = 'mail body';
 // $mail->AltBody = '';
  if(!$mail->send()) {  
      echo "<span style='font-size:15px; color:#FFFFFF; text-algin: center; background-color: red;'> Oops!! We were unable to send you a mail, please try again later.</span>";
      //echo 'Mailer Error: ' . $mail->ErrorInfo . "n";
  } else {
      echo "<span style='font-size:15px; color:#FFFFFF;  text-algin: center; background-color: green;'>Email sent successfully</span>";
  }
}
?>