<?php

namespace app\tools;
// Main ReciveMail Class File - Version 1.0 (03-06-2015)
/*
 * File: recivemail.class.php
 * Description: Reciving mail With Attechment
 * Version: 1.1
 * Created: 03-06-2015
 * Author: Sara Zhou
 */

class ReceiveMail
{

    public $server = '';
    public $username = '';
    public $password = '';
    public $marubox = '';
    public $email = '';
    public $backUp = '{imap.qq.com}&UXZO1mWHTvZZOQ-/beifen';
    public $servertype;
    public $port;
    public $connectstr;

    function __construct($username, $password, $EmailAddress, $mailserver = 'localhost', $servertype = 'pop', $port = '110', $ssl = false)
    { //Constructure


        $this->server = $mailserver;
        $this->username = $username;
        $this->password = $password;
        $this->email = $EmailAddress;
        $this->servertype = $servertype;
        $this->port = $port;
    }

    function connect()
    {
        $this->connectstr = '{' . $this->server . ':' . $this->port . '/imap/ssl}INBOX';
//        echo $this->connectstr;exit;
        $this->marubox = @imap_open($this->connectstr, $this->username, $this->password);
        if (!$this->marubox) {
            echo "Error: Connecting to mail server";
            exit;
        }
    }

    function listMessages($page = 1, $per_page = 25, $sort = null)
    {
        $limit = ($per_page * $page);
        $start = ($limit - $per_page) + 1;
        $start = ($start < 1) ? 1 : $start;
        $limit = (($limit - $start) != ($per_page - 1)) ? ($start + ($per_page - 1)) : $limit;
        $info = imap_check($this->marubox);
        $limit = ($info->Nmsgs < $limit) ? $info->Nmsgs : $limit;

        if (true === is_array($sort)) {
            $sorting = array(
                'direction' => array('asc' => 0, 'desc' => 1),
                'by' => array('date' => SORTDATE, 'arrival' => SORTARRIVAL,
                    'from' => SORTFROM, 'subject' => SORTSUBJECT, 'size' => SORTSIZE));
            $by = (true === is_int($by = $sorting['by'][$sort[0]])) ? $by : $sorting['by']['date'];
            $direction = (true === is_int($direction = $sorting['direction'][$sort[1]])) ? $direction : $sorting['direction']['desc'];
            $sorted = imap_sort($this->marubox, $by, $direction);
            $msgs = array_chunk($sorted, $per_page);
            $msgs = $msgs[$page - 1];
        } else {
            $msgs = range($start, $limit); //just to keep it consistent
        }
        $result = imap_fetch_overview($this->marubox, implode($msgs, ','), 0);
        if (false === is_array($result))
            return false;

        foreach ($result as $k => $r) {
            $result[$k]->subject = $this->_imap_utf8($r->subject);
            $result[$k]->from = $this->_imap_utf8($r->from);
            $result[$k]->to = $this->_imap_utf8($r->to);
            $result[$k]->body = $this->getBody($r->msgno);
        }
//sorting!
        if (true === is_array($sorted)) {
            $tmp_result = array();
            foreach ($result as $r) {
                $tmp_result[$r->msgno] = $r;
            }

            $result = array();
            foreach ($msgs as $msgno) {
                $result[] = $tmp_result[$msgno];
            }
        }

        $return = array('res' => $result,
            'start' => $start,
            'limit' => $limit,
            'sorting' => array('by' => $sort[0], 'direction' => $sort[1]),
            'total' => imap_num_msg($this->marubox));
        $return['pages'] = ceil($return['total'] / $per_page);
        return $return;
    }

    function getHeaders($mid)
    {
        if (!$this->marubox)
            return false;

        $mail_header = imap_header($this->marubox, $mid);
        if (!empty($mail_header->from)) {
            $sender = $mail_header->from[0];
        } else {
            $sender=new \stdClass();
            $sender->host='';
            $sender->mailbox='';
            $sender->personal='';
        }

        if (!empty($mail_header->reply_to)) {

            $sender_replyto = $mail_header->reply_to[0];
        } else {
            $sender_replyto=new \stdClass();
            $sender_replyto->personal='';
            $sender_replyto->mailbox='';
            $sender_replyto->host='';
        }
        if (strtolower($sender->mailbox) != 'mailer-daemon' && strtolower($sender->mailbox) != 'postmaster') {
            $mail_details = array(
                'from' => strtolower($sender->mailbox) . '@' . $sender->host,
                'fromName' => $sender->personal,
                'toOth' => strtolower($sender_replyto->mailbox) . '@' . $sender_replyto->host,
                'toNameOth' => $sender_replyto->personal,
                'subject' => $mail_header->subject,
                'to' => strtolower($mail_header->toaddress)
            );
        }
        return $mail_details;
    }

    function get_mime_type(&$structure)
    { //Get Mime type Internal Private Use
        $primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");

        if ($structure->subtype) {
            return $primary_mime_type[(int)$structure->type] . '/' . $structure->subtype;
        }
        return "TEXT/PLAIN";
    }

    function get_part($stream, $msg_number, $mime_type, $structure = false, $part_number = false)
    { //Get Part Of Message Internal Private Use
        if (!$structure) {
            $structure = imap_fetchstructure($stream, $msg_number);
        }
        if ($structure) {
            if ($mime_type == $this->get_mime_type($structure)) {
                if (!$part_number) {
                    $part_number = "1";
                }
                $text = imap_fetchbody($stream, $msg_number, $part_number);
                if ($structure->encoding == 3) {
                    return imap_base64($text);
                } else if ($structure->encoding == 4) {
                    return imap_qprint($text);
                } else {
                    return $text;
                }
            }
            if ($structure->type == 1) /* multipart */ {
                while (list($index, $sub_structure) = each($structure->parts)) {
                    $prefix = '';
                    if ($part_number) {
                        $prefix = $part_number . '.';
                    }
                    $data = $this->get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1));
                    if ($data) {
                        return $data;
                    }
                }
            }
        }
        return false;
    }

    function getTotalMails()
    {
        if (!$this->marubox)
            return false;

        $headers = imap_headers($this->marubox);

        $mail_list = imap_listmailbox($this->marubox, "{imap.qq.com}", '*');
        print_r("<pre>");
        print_r($mail_list);
        return count($headers);
    }

    function GetAttach($mid, $path)
    { // Get Atteced File from Mail
        if (!$this->marubox) {
            return false;
        }

        $struckture = imap_fetchstructure($this->marubox, $mid);
        $ar = "";
        if (!empty($struckture->parts)) {
            foreach ($struckture->parts as $key => $value) {
                $enc = $struckture->parts[$key]->encoding;
                if ($struckture->parts[$key]->subtype == 'OCTET-STREAM') {
                    $name = base64_decode($struckture->parts[$key]->parameters[1]->value);
                    $name = iconv("gbk", 'utf-8', $name);
                    $name = substr($name, 7); // 未知原因 base64解密以后字符串前边多了三个 乱码字符    截取7以后的字符串
                    $message = imap_fetchbody($this->marubox, $mid, $key + 1);
                    switch ($enc) {
                        case 0:
                            $message = imap_8bit($message);
                            break;
                        case 1:
                            $message = imap_8bit($message);
                            break;
                        case 2:
                            $message = imap_binary($message);
                            break;
                        case 3:
                            $message = imap_base64($message);
                            break;
                        case 4:
                            $message = quoted_printable_decode($message);
                            break;
                        case 5:
                            $message = $message;
                            break;
                    }
// 文件名转换
                    $name = explode('.', $name);
                    $firs_name = urlencode($name[0]);
                    $filename = $firs_name . '.' . $name[1];
                    $fp = fopen($path . $filename, "w");  //fopen  中文文件名
                    fwrite($fp, $message);
                    fclose($fp);
                    $ar = $ar . $filename . ",";
                }
//                print_r("********************<br /> 进入测试区");
//
//                $mess = base64_decode("?gb18030?B?MjAxNDA2MTXW0Ln6uaTJzNL40NDM2NS8taXOu1BPU7270tfH5bWlMDUwMjAxMTIwMzcwXzAwMC5jc3Y=?=");
//                $mess = iconv("gbk", 'utf-8', $mess);
//
//                $mess = substr($mess, 7);
//                print_r($mess);
//                die();
//                $message = imap_fetchbody($this->marubox, $mid, $partnro);
//
//                print_r($key);

                /*
                 * @下边暂时禁用  // Support for embedded attachments starts here
                 */
//                if (isset($struckture->parts[$key]->parts)) {
//                    foreach ($struckture->parts[$key]->parts as $keyb => $valueb) {
//                        $enc = $struckture->parts[$key]->parts[$keyb]->encoding;
//                        if ($struckture->parts[$key]->parts[$keyb]->ifdparameters) {
//                            $name = $struckture->parts[$key]->parts[$keyb]->dparameters[0]->value;
//                            $partnro = ($key + 1) . "." . ($keyb + 1);
//                            $message = imap_fetchbody($this->marubox, $mid, $partnro);
//                            switch ($enc) {
//                                case 0:
//                                    $message = imap_8bit($message);
//                                    break;
//                                case 1:
//                                    $message = imap_8bit($message);
//                                    break;
//                                case 2:
//                                    $message = imap_binary($message);
//                                    break;
//                                case 3:
//                                    $message = imap_base64($message);
//                                    break;
//                                case 4:
//                                    $message = quoted_printable_decode($message);
//                                    break;
//                                case 5:
//                                    $message = $message;
//                                    break;
//                            }
//                            $fp = fopen($path . $name, "w");
//                            fwrite($fp, $message);
//                            fclose($fp);
//                            $ar = $ar . $name . ",";
//                        }
//                    }
//                }
            }
        }
        $ar = substr($ar, 0, (strlen($ar) - 1));
        return $ar;
    }

    function removeEamil($mid)
    {
        if (!$this->marubox)
            return false;

        imap_mail_move($this->marubox, $mid, '&UXZO1mWHTvZZOQ-/beifen');
    }

    function getBody($mid)
    { // Get Message Body
        if (!$this->marubox) {
            return false;
        }
        $body = $this->get_part($this->marubox, $mid, "TEXT/HTML");
        if ($body == "") {
            $body = $this->get_part($this->marubox, $mid, "TEXT/PLAIN");
        }
        if ($body == "") {
            return "";
        }
        return $this->_iconv_utf8($body);
    }

    function deleteMails($mid)
    { // Delete That Mail
        if (!$this->marubox)
            return false;

        imap_delete($this->marubox, $mid);
    }

    function close_mailbox()
    { //Close Mail Box
        if (!$this->marubox)
            return false;

        imap_close($this->marubox, CL_EXPUNGE);
    }

    function _imap_utf8($text)
    {
        if (preg_match('/=\?([a-zA-z0-9\-]+)\?(.*)\?=/i', $text, $match)) {
            $text = imap_utf8($text);
            if (strtolower(substr($match[1], 0, 2)) == 'gb') {
                $text = iconv('gbk', 'utf-8', $text);
            }
            return $text;
        }
        return $this->_iconv_utf8($text);
    }

    function _iconv_utf8($text)
    {
        $s1 = iconv(mb_detect_encoding($text), 'utf-8', $text);
        $s0 = iconv(mb_detect_encoding($text), 'gbk', $s1);
        if ($s0 == $text) {
            return $s1;
        } else {
            return $text;
        }
    }

}
