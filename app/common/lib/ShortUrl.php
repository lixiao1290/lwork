<?php
namespace common\lib;

class ShortUrl
{
    
    public function Code62($x)
    {
        $show = '';
        while($x>0){
            $s = $x%62;
            if($s>35)
            {
                $s = chr($s+61);
            }elseif ($s>9&&s<=35)
            {
                $s = chr($s+55);
            }
            $show .= $s;
            $x = floor($x/62);
        }
        return $show;
    }
    public function ShortUrl($id)
    {
        $id = crc32($id);
        $result = sprintf("%u",$id);
        return ShortUrl::Code62($result);
    }
}
