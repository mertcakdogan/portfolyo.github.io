<?php

// Kendi e-posta adresinizle değiştirin
$siteOwnersEmail = 'mertcakdogan@gmail.com';


if($_POST) {

  $name = trim(htmlspecialchars($_POST['contactName']));
  $email = trim(htmlspecialchars($_POST['contactEmail']));
  $subject = trim(htmlspecialchars($_POST['contactSubject']));
  $contact_message = trim(htmlspecialchars($_POST['contactMessage']));

  // İsim Kontrol
  if (strlen($name) < 2) {
    $error['name'] = "Lütfen adınızı giriniz.";
  }
  // E-posta Kontrol
  if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
    $error['email'] = "Lütfen mail adresinizi giriniz.";
  }
  // Mesaj Kontrol
  if (strlen($contact_message) < 15) {
    $error['message'] = "Lütfen mesajınızı yazınız. En az 15 karakter olmak zorundadır.";
  }
  // Konu
  if ($subject == '') { $subject = ""; }


  // Mesaj Oluşturma
  $message .= "Email from: " . $name . "<br />";
  $message .= "Email address: " . $email . "<br />";
  $message .= "Message: <br />";
  $message .= $contact_message;
  $message .= "<br /> ----- <br /> Bu e-posta, sitenizin iletişim formundan gönderilmiştir. <br />";

  // Gönderen Başlığı
  $from =  $name . " <" . $email . ">";

  // E-posta Başlıkları
  $headers = "From: " . $from . "\r\n";
  $headers .= "Reply-To: ". $email . "\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


  if (!$error) {

    // Mail işlevinin çalışıp çalışmadığını kontrol et
    if (mail($siteOwnersEmail, $subject, $message, $headers)) {
      echo "OK";
    } else {
      echo "Mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin.";
    }
  } else {

    $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
    $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
    $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
  
    echo $response;

  }

}

?>