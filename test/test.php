<?php
error_reporting(E_ALL);
$arr = array("asdf", "asdfg");



//User Key (Irgendwo wegspeichern)
//$key = openssl_random_pseudo_bytes(16);
//
//for($i = 0;$i<= 1000;$i++)
//{
//    $plaintext = "zu verschlüsselnde Nachricht ". $i;
//    $cipher = "aes-128-gcm";
//
//    $ivlen = openssl_cipher_iv_length($cipher);
//    $iv = openssl_random_pseudo_bytes($ivlen);
//    $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
//    // speichere $cipher, $iv und $tag für spätere Entschlüsselung
//    $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
//    echo $original_plaintext."\n";
//}
//
//exit;

list($a, $b) = $arr;

echo $b;