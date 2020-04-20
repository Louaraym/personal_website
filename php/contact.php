<?php

    $array = [
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'telephone' => '',
            'message' => '',
            'firstnameError' => '',
            'lastnameError' => '',
            'emailError' => '',
            'telephoneError' => '',
            'messageError' => '',
            'isSuccess' => false,
        ];

    $emailTo = 'louaraym@gmail.com';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        $array['firstname'] = secureInput($_POST['firstname']);
        $array['lastname'] = secureInput($_POST['lastname']);
        $array['email'] = secureInput($_POST['email']);
        $array['telephone'] = secureInput($_POST['telephone']);
        $array['message'] = secureInput($_POST['message']);
        $emailContent = '';
        $array['isSuccess'] = true;

        if (empty($array['firstname'])){
            $array['firstnameError'] = 'Je veux connaître votre Prénom !';
            $array['isSuccess'] = false;
        }else{
            $emailContent .= "Firstname: {$array['firstname']}\n";
        }

        if (empty($array['lastname'])){
            $array['lastnameError'] = 'Je veux connaître votre Nom !';
            $array['isSuccess'] = false;
        }else{
            $emailContent .= "Lastname: {$array['lastname']}\n";
        }

        if (!isValidEmail($array['email'])){
            $array['emailError'] = 'Je veux connaître votre Email valide !';
            $array['isSuccess'] = false;
        }else{
            $emailContent .= "Email: {$array['email']}\n";
        }

        if (!isValidPhoneNumber($array['telephone'])){
            $array['telephoneError'] = 'Je veux connaître votre numéro de téléphone !';
            $array['isSuccess'] = false;
        }else{
            $emailContent .= "Telephone: {$array['telephone']}\n";
        }

        if (empty($array['message'])){
            $array['messageError'] = 'Quelle est votre message pour moi !';
            $array['isSuccess'] = false;
        }else{
            $emailContent .= "Message: {$array['message']}\n";
        }

        if ($array['isSuccess']){
            $headers= "From: {$array['firstname']} {$array['lastname']} <{$array['email']}>\r\nReply-To: {$array['email']}";
            mail($emailTo, 'Un message de votre site web', $emailContent, $headers);
        }

        echo json_encode($array);
    }

    function isValidEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function isValidPhoneNumber($phoneNumber){
        return preg_match('/^[0-9 +]+$/', $phoneNumber);
    }

    function secureInput($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);

        return $input;
    }



