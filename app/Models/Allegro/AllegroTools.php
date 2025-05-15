<?php

namespace App\Models\Allegro;

class AllegroTools
{
    static $REDIRECT_URL = "https://autoglobal.md/info.php";

    static $URL_ENVIRONEMENT = "https://api.allegro.pl";

    static $URL_INIT = "https://allegro.pl/auth/oauth/device";
    static $URL_TOKEN = "https://allegro.pl/auth/oauth/token";
    static $URL_AUTHORIZATION = "/auth/oauth/authorize";

    // autoglobal.md
    // static $CLIENTID = "9aa625e0d4c54fd09761c33fdb09e133";
    // static $CLIENTSECRET = "bwf6whBDneFEyy4BoRxkp6rSjwRRX3KcqjGcEaPm9CKV82ENEoFRlOuciLV83qWk";

    // // autoglobalpl
    // static $CLIENTID = "0ff225621f6948a0ab8af36d724109fd";
    // static $CLIENTSECRET = "ueXBx2zXccuMpFANAuJpDyzal6nKGwSljdl2xDjAu9lO5iT0MZ9uw79QuedmG356";

    // autoglobalpl@gmail.com
    static $CLIENTID = "118b35183ced44c7a36155f1b142d9c4";
    static $CLIENTSECRET = "xEVSjNWTqSuKK8jlx0ER6whb9wEojgw1BG85upIaqYhDbnZMH9zhysgpNfX2asWo";

    static $ACCESS_TOKEN = false;



    static public function test()
    {
        // $categories = AllegroCategory::getCategoryList();
        // $detail = AllegroCategory::getCategoryDetail(5);
        // $options = AllegroCategory::getCategoryDetail(5);
        $products = AllegroProduct::getProducts(5, $err);
        dd($err);
        // dd($categories, $detail, $options, $products);
        dd($products);
        // $credentials = new Credentials(
        //     self::$CLIENTID,
        //     self::$CLIENTSECRET,
        //     '/',
        //     false
        // );

        // dd($credentials);

    }

    // ------------------------------------------------------------------
    static public function get($url, &$err = null)
    {
        $err = false;

        $headers = self::getHeaders();

        $ch = self::getCurl($headers, $url);

        // dd($url, $headers, $ch);

        $result = curl_exec($ch);
        $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($result === false || $resultCode !== 200) {
            $err = true;
            $err = $resultCode;
            return;
        }
        return json_decode($result, true);
    }

    // ------------------------------------------------------------------
    static public function getCurl($headers, $url, $content = null, $isFullUrl = false)
    {
        $url = ($isFullUrl) ? $url : self::$URL_ENVIRONEMENT . $url;

        // dd($url);

        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true
            )
        );
        if ($content !== null) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }
        return $ch;
    }

    static public function getHeaders()
    {
        AllegroToken::setAccessToken();
        $token = self::$ACCESS_TOKEN;

        $headers = array();
        $headers[] = "Authorization: Bearer {$token}";
        $headers[] = "Content-Type: application/json";
        $headers[] = "Accept: application/vnd.allegro.public.v1+json";
        return $headers;
    }

    // ------------------------------------------------------------------

}