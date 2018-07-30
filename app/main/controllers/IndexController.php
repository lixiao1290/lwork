<?php

namespace app\main\controllers;

use app\tools\Email_reader;
use app\tools\ReceiveMail;
use common\lib\Snoopy;
use common\models\demo;
use minicore\helper\Db;
use minicore\lib\Controller;
use FFMpeg\FFMpeg;
use minicore\lib\View;
use minicore\model\minidemo;
use minicore\lib\Mini;
use app\tools\ConvertEncoder;
use Syscover\EmailReader\Server;
use app\common\models;
class IndexController extends Controller
{

    public function initial()
    {
        $this->assign('AssetDir', Mini::app()->getIndexDir() . "/");
    }

    public function index()
    {

//        echo $_SERVER['PATH_INFO'],'<br/>',$_SERVER['DOCUMENT_ROOT'],'<br/>',$_SERVER['REQUEST_URI'];

        $data = [
            'username' => 'lixiao',
            'hobby'    => 'music,wine'
        ];
        /* $i = intval(file_get_contents("E:log.txt"));
         file_put_contents("E:log.txt", $i++);*/
        $dsn = 'mysql:dbname=mini;host=localhost';
        /* $list = Db::database('mini')->table('sys_user')
             ->where(array(
             'id',
             '=',
             7
         ))
             ->asObj()
             ->select();
         $list2 = Db::database('mini')->table('sys_user')
             ->where(array(
             'id',
             '=',
             7
         ))
             ->update(array(
             'username' => 'iegj',
             'sex' => 1
         ));

         var_dump($list);*/
        // Db::database('mini')->getPdo()->beginTransaction();
        $this->assign('list', [
            '张武',
            '李宵',
            /*   '徐瑶瑶',
               '张彪',
               '王世超'*/
        ]);
        $this->registerJs(array(
            'a',
            'b',
            'c'
        ));
        $this->registerCss(array(
            'd'
        ));


        // var_dump($_SERVER['HTTP_USER_AGENT']);
        /*
         * $useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
         * if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){
         * echo " 非微信浏览器禁止访问";
         * }else{
         * echo "微信浏览器允许访问";
         * }
         */
        $this->view();
    }

    public function ffmpeg()
    {
        $ffpeg = FFMpeg::create([
            'ffmpeg.binaries'  => 'E:\ffpeg/ffmpeg.exe',
            'ffprobe.binaries' => 'E:\ffpeg/ffprobe.exe'
        ]);

        $video = $ffpeg->open('QQ20170123-151825-HD.mp4');
        $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(2));
        $frame->save('image.jpg');
    }

    public function wx()
    {
        $useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
            exit(" 非微信浏览器禁止访问");
        }
    }



    public function session()
    {
        //session_start();
        Mini::app()->appPath;
        $sss = 5643223424;
        $_SESSION['session'] = 'ijgjaea3256233jklfak6324lkjkjkl253643kljdafdafdskj543426734456ljlka';
        var_dump(session_get_cookie_params(), session_id(), session_save_path());
        var_dump($_SESSION, get_defined_vars());
    }

    public function mails()
    {
        echo 'mail tests ！';


        // Create the Transport
        $transport = \Swift_SmtpTransport::newInstance('smtp.163.com')
            ->setUsername('aizhizhiren@163.com')
            ->setPassword('lx0521131');

        /*
        You could alternatively use a different transport such as Sendmail or Mail:

        // Sendmail
        $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

        // Mail
        $transport = Swift_MailTransport::newInstance();
        */

// Create the Mailer using your created Transport
        $mailer = \Swift_Mailer::newInstance($transport);

// Create a message
        $message = \Swift_Message::newInstance('Hello lixiao')
            ->setFrom(array('aizhizhiren@163.com' => 'li'))
            ->setTo(array('209201763@qq.com'))
            ->setBody('Hello lixiao');

// Send the message
        $result = $mailer->send($message);
    }

    public function tick()
    {
        declare(ticks=1) {
            // entire script here
            echo 12;
        }

// or you can use this:
        declare(ticks=1);
        for ($i = 0; $i < 10; $i++) {
            $a = 1;


        }
    }

    public function readmails()
    {
        echo 'readmailtest';
        $emailReader = new  Email_reader();
        $i_mails = 0;
        echo '<pre>';
        // print_r($emailReader->getInbox());
        //$body=$emailReader->get(1)['body'];
        // echo $body;
//         print (imap_base64(imap_fetchbody($emailReader->conn,1,2)));
        // print (imap_base64(imap_fetchbody($emailReader->conn,1,'2')));
//        print_r($emailReader->get(1)['header']);
        foreach ($emailReader->getInbox() as $mail_num => $mail) {
            if ($i_mails >= 10) {
                break;
            }
            $structure = get_object_vars($mail['structure']);
            // var_dump(base64_decode($mail['body'],false));
            echo base64_decode(imap_fetchbody($emailReader->conn, $mail['index'], '2'));
            // var_dump($mail);
            $i_mails++;
        }
    }

    public function getmails()
    {


        $hostname = '{imap.163.com:993/imap/ssl}INBOX';
        $username = 'aizhizhiren@163.com';
        $password = 'lx0521131';

        /* try to connect */
        $mail = imap_open($hostname, $username, $password) or die('Cannot connect to Gmail: ' . imap_last_error());

        $total = imap_num_msg($mail);
        echo '一共', $total, '封邮件<br/>';
        for ($n = 1; $n <= $total; $n++) {
            $st = imap_fetchstructure($mail, $n);


            if (!empty($st->parts)) {
                $body = '第' . $n . '封';
                $j = count($st->parts);
                var_dump($st->parts);
                for ($i = 0; $i < $j; $i++) {
                    $part = $st->parts[$i];
                    if ($part->subtype == 'PLAIN') {
                        $body .= 'part_' . $i;
                        $contents = (imap_fetchbody($mail, $n, $i));
                        $body .= $contents;
                        $mine = imap_fetchmime($mail, $n, $i);
                    }
                }
            } else {
                $body = imap_base64(imap_body($mail, $n));
            }
            $mail_header = imap_headerinfo($mail, $n);
            $subject = $mail_header->subject;//邮件标题
            $subject = ConvertEncoder::decode_mime($subject);
            echo($body), '</pre><br/>';
            echo $subject;

        }


    }

    public function receivemails()
    {
        $hostname = 'imap.163.com';
        $username = 'aizhizhiren@163.com';
        $password = 'lx0521131';
        $fileSavePaht = '/emailsave/';
        $obj = new ReceiveMail($username, $password, $username, $hostname, 'imap', '993', false);
        $obj->connect();
        $tot = $obj->getTotalMails(); //Total Mails in Inbox Return integer value
        echo "Total Mails:: $tot<br>";

        for ($i = $tot; $i > 0; $i--) {
            $head = $obj->getHeaders($i);  // Get Header Info Return Array Of Headers **Array Keys are (subject,to,toOth,toNameOth,from,fromName)
            echo "Subjects :: " . $head['subject'] . "<br>";
            echo "TO :: " . $head['to'] . "<br>";
            echo "To Other :: " . $head['toOth'] . "<br>";
            echo "ToName Other :: " . $head['toNameOth'] . "<br>";
            echo "From :: " . $head['from'] . "<br>";
            echo "FromName :: " . $head['fromName'] . "<br>";
            echo "<br><br>";
            echo "<br>*******************************************************************************************<BR>";
            echo $obj->getBody($i);  // Get Body Of Mail number Return String Get Mail id in interger
            print_r("附件下载区");
            print_r("<br />");
            $str = $obj->GetAttach($i, $fileSavePaht); // Get attached File from Mail Return name of file in comma separated string  args. (mailid, Path to store file)
            $ar = explode(",", $str);
            foreach ($ar as $key => $value)
                echo ($value == "") ? "" : "Atteched File :: " . $value . "<br>";
            echo "<br>------------------------------------------------------------------------------------------<BR>";
            //  $obj->removeEamil($i); // Delete Mail from Mail box
        }
        $obj->close_mailbox();   //Close Mail Box
    }

    /**
     *读邮件
     * @throws \Exception
     */
    public function reademails()
    {
        $server = new Server('imap.163.com', '993', 'imap');
        $server->setAuthentication('aizhizhiren@163.com', 'lx0521131');
        $messages = $server->getMessages(20);
        echo '<pre>  ';
//       print_r($messages);
        echo '<pre>';
        foreach ($messages as $message) {
            echo $message->getHtmlBody();
        }
    }

    public function welcome()
    {
        $this->view();
    }

    public function main()
    {

        $this->view();
    }

    /**
     *
     */
    public function browse()
    {
        $url = 'http://www.cipm-expo.com/e/cpxx_chs.php?ID=1389&W=http://www.cipm-expo.com/e/cplb_chs.php$ID=8^P=1^O=1';

        $snoopy = new Snoopy();
        $rst = file_get_contents($url);
        var_dump($rst);


        $this->view();
    }

    public function animate()
    {
        return View::view();

    }

    /**
     *
     */
    public function refle()
    {

        /**
         * @var  models\demo $demo
         */
        $demo = Mini::createObj(models\demo::class);
        $demo->big();
    }

    /**
     * sphinx 搜索demo
     * 配置文件：\common\lib\sphinx.conf
     * sphinxRt 实时索引curd 类 相当于sphinx拿来作数据库用可以执行sql语句
     * sphinx.conf中的serachd 配置listen=9306:mysql41 实现sphinx可以支持mysql连接执行sql语句端口为9306
     * 连接命令：mysql -h 127.0.0.1 -P 9306
     * 启动sphinx bin\searchd.exe  --config ./sphinx.conf (nmp集成环境)
     * 数据文件 vendor\minicore\sqlmigration
     *
     *
     */
    function sphinx()
    {
//        include './xiunophp/sphinx.class.php';
        include dirname(dirname(dirname(dirname($this->getClassFile())))) . '/common' . '/lib/SphinxRt.class.php';
//        include dirname(dirname(dirname(dirname($this->getClassFile())))) . '/common' . '/lib/sphinx.php';
        $sphinx = new \SphinxRt('ciku', '127.0.0.1:9306');
        //打开调试信息
        $sphinx->debug = false;
        //查询
//        $prodList = $sphinx->where($condition)->order($orderCondition)->group('prod_uid')->search();
        $prodList = $sphinx->where("WHERE MATCH('大') and group_id = 5")->limit(100)->search();
        echo "sphinxrt", "<pre>";
        print_r($prodList);
        //插入数据
        $sphinxData['word'] = "大";
        $sphinxData['group_id'] = 5;
//      $sphinx->insert($sphinxData); //插入数据

        $sx = new \SphinxClient();
        $sx->SetServer('127.0.0.1', 9312);
        $sx->SetArrayResult(true);
        $sx->SetMatchMode(SPH_MATCH_ANY); //
        $sx->SetRankingMode(SPH_RANK_WORDCOUNT); //
        $sx->SetSortMode(SPH_SORT_RELEVANCE, "WEIGHT() DESC");//
        $sx->SetFilter('group_id', array(5));
//        $sx->SetLimits(0, 1000);//
        $r = $sx->Query("大", "ciku");
        echo "<pre>";
        print_r($r);
    }

    /**
     *
     */
    public function insertSphinx()
    {
        include dirname(dirname(dirname(dirname($this->getClassFile())))) . '/common' . '/lib/SphinxRt.class.php';

        $argcs = array("i", "ijf", "idjfa");
        $db_config = array(
            "host" => "localhost",
            "port" => "3306",
            "db"   => "test",
            "user" => "root",
            "pwd"  => "root",
            "type" => "mysql"
        );
        $list = Db::db($db_config)->table("ciku_keyword")->limit("5000")->asArray();
        $sphinx = new \SphinxRt('ciku', '127.0.0.1:9306');
        //打开调试信息
        $sphinx->debug = false;
        //插入数据
        $acount=0;
        foreach ($list as $value) {

            $sphinxData['_id'] = $value['id'];
            $sphinxData['word'] = $value['word'];
            $sphinxData['cat_id'] = $value['cat_id'];
            $r = $sphinx->insert($sphinxData); //插入数据
            if($r) {
                $acount+=1;
            } else {
                var_dump($sphinx->getError());
            }
        }
        echo $acount;
    }
}

