<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helpers extends Model {

    function file_ext_strip($filename) {
        return preg_replace('/.[^.]*$/', '', $filename);
    }

    function gen_uuid($len = 3) {

        $hex = md5("yourSaltHere" . uniqid("", true));

        $pack = pack('H*', $hex);
        $tmp = base64_encode($pack);

        $uid = preg_replace("#(*UTF8)[^A-Za-z0-9]#", "", $tmp);

        $len = max(12, min(128, $len));

        while (strlen($uid) < $len)
            $uid .= gen_uuid(22);

        return substr($uid, 0, $len);
    }

}
