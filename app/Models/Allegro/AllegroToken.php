<?php

namespace App\Models\Allegro;

class AllegroToken
{
    static public function initAccessToken()
    {
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";

        $authorization = base64_encode(AllegroTools::$CLIENTID . ':' . AllegroTools::$CLIENTSECRET);
        $headers[] = "Authorization: Basic {$authorization}";

        $content = "grant_type=urn:ietf:params:oauth:grant-type:device_code";
        $content .= "&client_id=" . AllegroTools::$CLIENTID;
        
        $ch = AllegroTools::getCurl($headers, AllegroTools::$URL_INIT, $content, true);

        $tokenResult = curl_exec($ch);

        $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        
        if ($tokenResult === false || $resultCode !== 200) {
            return -1;
        }

        return json_decode($tokenResult, true);
    }

    static public function getFirstToken($device_code)
    {
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";

        $authorization = base64_encode(AllegroTools::$CLIENTID . ':' . AllegroTools::$CLIENTSECRET);
        $headers[] = "Authorization: Basic {$authorization}";

        $content = null;

        $url = AllegroTools::$URL_TOKEN;
        $url .= '?grant_type=urn:ietf:params:oauth:grant-type:device_code&device_code='.$device_code;
        
        $ch = AllegroTools::getCurl($headers, $url, $content, true);

        $tokenResult = curl_exec($ch);

        $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($tokenResult === false || $resultCode !== 200) {
            return -1;
        }

        $tarr = json_decode($tokenResult, true);

        $obj = AlgToken::GetObj();

        $obj->clientid = AllegroTools::$CLIENTID;
        $obj->clientsecret = AllegroTools::$CLIENTSECRET;
        
        $obj->access_token = $tarr['access_token'];
        $obj->token_type = $tarr['token_type'];
        $obj->refresh_token = $tarr['refresh_token'];
        
        $obj->expires_in = $tarr['expires_in'];
        $obj->avaible_date = time() + $tarr['expires_in'] - 200;
        
        $obj->scope = $tarr['scope'];
        $obj->allegro_api = (int)$tarr['allegro_api'];
        $obj->jti = $tarr['jti'];

        $obj->_save();

        return $obj;
    }

    static public function checkAccessToken()
    {
        $f = [];
        $f['_limit'] = 1;
        $f['_orderby'][] = ['_d' => 'desc', '_c' => 'id'];

        $objects = AlgToken::_getAll($f);
        $obj = reset($objects);

        $needRefreshToken = ($obj->avaible_date <= (time() + 1800)) ? true : false;

        if (!$needRefreshToken)
            return 0;

        return self::regenerateToken($obj);
    }

    static protected function regenerateToken($obj)
    {
        $err = false;

        $authorization = base64_encode($obj->clientid . ':' . $obj->clientsecret);

        $headers = array();
        $headers[] = "Authorization: Basic {$authorization}";
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        $headers[] = "Accept: application/vnd.allegro.public.v1+json";

        
        $content = "grant_type=refresh_token";
        $content .= "&refresh_token=".$obj->refresh_token;
        $content .= "&redirect_uri=".AllegroTools::$REDIRECT_URL;
        $content .= "&client_id=".$obj->clientid;
        $content .= "&client_secret=".$obj->clientsecret;
        
        $ch = AllegroTools::getCurl($headers, AllegroTools::$URL_TOKEN, $content, true);

        $tokenResult = curl_exec($ch);

        $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($tokenResult === false || $resultCode !== 200) {
            $err = true;
            return -1;
        }

        $tarr = json_decode($tokenResult, true);

        $obj->access_token = $tarr['access_token'];
        $obj->refresh_token = $tarr['refresh_token'];
        $obj->expires_in = $tarr['expires_in'];
        $obj->avaible_date = time() + $tarr['expires_in'] - 200;
        $obj->scope = $tarr['scope'];
        $obj->jti = $tarr['jti'];

        $obj->_save();

        return $obj;
    }

    static public function getAccessToken()
    {
        $f = [];
        $f['_limit'] = 1;
        $f['_orderby'][] = ['_d' => 'desc', '_c' => 'id'];

        $objects = AlgToken::_getAll($f);
        $obj = reset($objects);
        return $obj->access_token;
    }

    static public function setAccessToken(&$err = null)
    {
        if (AllegroTools::$ACCESS_TOKEN) return;
        AllegroTools::$ACCESS_TOKEN = self::getAccessToken();
    }

}