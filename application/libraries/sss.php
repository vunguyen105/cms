<!--//-->
<!--// clients screen resolution: <script type='text/javascript'>document.write(screen.width+'x'+screen.height); </script>-->
<!--//    referer: --><?php //print ($_SERVER['HTTP_REFERER']); ?>
<!--client ip: --><?php //print ($_SERVER['REMOTE_ADDR']); ?>
<!--user agent:  --><?php //print ($_SERVER['HTTP_USER_AGENT']); ?>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: huy
 * Date: 2/11/13
 * Time: 10:44 AM
 * To change this template use File | Settings | File Templates.
 */


function logVisitors()
{
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $referrer = $_SERVER['HTTP_REFERER'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $fn = 'logVisitors.txt';
    $content = file_get_contents($fn);
    $content .= date("d/m/Y:H:i:s;\t");
    $content .= $user_ip . ";\t";
    $content .= $user_agent . ";\t";
    $content .= $referrer . ";\t";
    $fp = fopen($fn, "w+") or die ("Error opening file in write mode!");
    fputs($fp, $content);
    fclose($fp);
}