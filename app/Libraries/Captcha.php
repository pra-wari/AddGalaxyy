<?php
namespace App\Libraries;
class Captcha
{

    function getCaptchaCode($length)
    {
        $random_alpha = md5(random_bytes(64));
        $captcha_code = substr($random_alpha, 0, $length);
        return $captcha_code;
    }
    
    function setSession($key, $value) {
        
        $data = array($key=>$value);
        session()->set($data);
        //$this->session->userdata($key,$value);
    }
    
    function getSession($key) {
        $value = "";
        if(!empty($key) && !empty(session()->get('captcha_code')))
        {            
            $value = $_SESSION[$key];
        }
        return $value;
    }

    function createCaptchaImage($captcha_code)
    {
        $target_layer = imagecreatetruecolor(72,28);
        $captcha_background = imagecolorallocate($target_layer, 204, 204, 204);
        imagefill($target_layer,0,0,$captcha_background);
        $captcha_text_color = imagecolorallocate($target_layer, 0, 0, 0);
        imagestring($target_layer, 5, 10, 5, $captcha_code, $captcha_text_color);
        
        return $target_layer;
    }

    function renderCaptchaImage($imageData)
    {
        header("Content-type: image/jpeg");
         imagejpeg($imageData);
       $rawImageBytes = ob_get_clean();
       return "<img src='data:image/jpeg;base64," . base64_encode( $rawImageBytes ) . "' />";
        
    }
    
    function validateCaptcha($formData) {
        
        $isValid = false;
        $capchaSessionData = $this->getSession("captcha_code");
        if($capchaSessionData == $formData) 
        {
            $isValid = true;
        }
        return $isValid;
    }
}