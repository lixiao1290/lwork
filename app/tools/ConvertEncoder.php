<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/22
 * Time: 17:54
 */

namespace app\tools;


class ConvertEncoder
{
    public static function decode_mime($string)
    {
        $pos = strpos($string, '=?');
        if (!is_int($pos)) {
            return $string;
        }
        $preceding = substr($string, 0, $pos); // save any preceding text
        $search = substr($string, $pos + 2); /* the mime header spec says this is the longest a single encoded Word can be */
        $d1 = strpos($search, '?');
        if (!is_int($d1)) {
            return $string;
        }
        $charset = substr($string, $pos + 2, $d1); //取出字符集的定义部分
        $search = substr($search, $d1 + 1); //字符集定义以后的部分＝>$search;
        $d2 = strpos($search, '?');
        if (!is_int($d2)) {
            return $string;
        }
        $encoding = substr($search, 0, $d2); ////两个?　之间的部分编码方式　：ｑ　或　ｂ　
        $search = substr($search, $d2 + 1);
        $end = strpos($search, '?='); //$d2+1 与 $end 之间是编码了　的内容：=> $endcoded_text;
        if (!is_int($end)) {
            return $string;
        }
        $encoded_text = substr($search, 0, $end);
        $rest = substr($string, (strlen($preceding . $charset . $encoding . $encoded_text) + 6)); //+6 是前面去掉的　=????=　六个字符
        switch ($encoding) {
            case 'Q':
            case 'q':
//$encoded_text = str_replace('_', '％20', $encoded_text);
//$encoded_text = str_replace('=', '％', $encoded_text);
//$decoded = urldecode($encoded_text);
                $decoded = quoted_printable_decode($encoded_text);
                if (strtolower($charset) == 'windows-1251') {
                    $decoded = convert_cyr_string($decoded, 'w', 'k');
                }
                break;
            case 'B':
            case 'b':
                $decoded = base64_decode($encoded_text);
                if (strtolower($charset) == 'windows-1251') {
                    $decoded = convert_cyr_string($decoded, 'w', 'k');
                }
                break;
            default:
                $decoded = '=?' . $charset . '?' . $encoding . '?' . $encoded_text . '?=';
                break;
        }
        return $preceding . $decoded . self::decode_mime($rest);
        //return $preceding . $decoded . $this->decode_mime($rest);

    }
}