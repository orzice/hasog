<?php
// +----------------------------------------------------------------------
// | HaSog (幻神商城系统)
// +----------------------------------------------------------------------
// | 技术支持【幻神科技】: https://www.hasog.com
// +----------------------------------------------------------------------
// | 联系我们:  https://www.hasog.com
// +----------------------------------------------------------------------
// | gitee开源项目：https://gitee.com/orzice/hasog
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/orzice/hasog
// +----------------------------------------------------------------------
// | Author：Orzice(小涛)  https://gitee.com/orzice
// +----------------------------------------------------------------------
// | DateTime：2020-12-31 18:28:38
// +----------------------------------------------------------------------

namespace Hasog;

use think\facade\Request;
/**
 * Response
 *
 * Response 请求重构
 *
 */
class Response {

    // Nginx 的 配置文件 直接拿来用  By：Orzice

    protected $mimeType = <<<ETO
    text/html                             html htm shtml;
    text/css                              css;
    text/xml                              xml;
    image/gif                             gif;
    image/jpeg                            jpeg jpg;
    application/x-javascript              js;
    application/atom+xml                  atom;
    application/rss+xml                   rss;

    text/mathml                           mml;
    text/plain                            txt;
    text/vnd.sun.j2me.app-descriptor      jad;
    text/vnd.wap.wml                      wml;
    text/x-component                      htc;

    image/png                             png;
    image/tiff                            tif tiff;
    image/vnd.wap.wbmp                    wbmp;
    image/x-icon                          ico;
    image/x-jng                           jng;
    image/x-ms-bmp                        bmp;
    image/svg+xml                         svg svgz;
    image/webp                            webp;

    application/java-archive              jar war ear;
    application/mac-binhex40              hqx;
    application/msword                    doc;
    application/pdf                       pdf;
    application/postscript                ps eps ai;
    application/rtf                       rtf;
    application/vnd.ms-excel              xls;
    application/vnd.ms-powerpoint         ppt;
    application/vnd.wap.wmlc              wmlc;
    application/vnd.google-earth.kml+xml  kml;
    application/vnd.google-earth.kmz      kmz;
    application/x-7z-compressed           7z;
    application/x-cocoa                   cco;
    application/x-java-archive-diff       jardiff;
    application/x-java-jnlp-file          jnlp;
    application/x-makeself                run;
    application/x-perl                    pl pm;
    application/x-pilot                   prc pdb;
    application/x-rar-compressed          rar;
    application/x-redhat-package-manager  rpm;
    application/x-sea                     sea;
    application/x-shockwave-flash         swf;
    application/x-stuffit                 sit;
    application/x-tcl                     tcl tk;
    application/x-x509-ca-cert            der pem crt;
    application/x-xpinstall               xpi;
    application/xhtml+xml                 xhtml;
    application/zip                       zip;

    application/octet-stream              bin exe dll;
    application/octet-stream              deb;
    application/octet-stream              dmg;
    application/octet-stream              eot;
    application/octet-stream              iso img;
    application/octet-stream              msi msp msm;

    audio/midi                            mid midi kar;
    audio/mpeg                            mp3;
    audio/ogg                             ogg;
    audio/x-m4a                           m4a;
    audio/x-realaudio                     ra;

    video/3gpp                            3gpp 3gp;
    video/mp4                             mp4;
    video/mpeg                            mpeg mpg;
    video/quicktime                       mov;
    video/webm                            webm;
    video/x-flv                           flv;
    video/x-m4v                           m4v;
    video/x-mng                           mng;
    video/x-ms-asf                        asx asf;
    video/x-ms-wmv                        wmv;
    video/x-msvideo                       avi;
ETO;
    protected $Type;
    protected $request;

    function __construct() {
        // $data = explode(PHP_EOL, $this->mimeType);
        //平台适配问题
        $data = str_replace(["\r\n","\n","\r"],"\r", $this->mimeType);
        $data = explode("\r", $data);

        //创建快捷数组，=A= 只能for循环了
        $this->Type = array();

        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i] == '') {
                continue;
            }
            $ls = explode(' ', $data[$i]);
            $ls = $this->where_data($ls);
         
            for ($s=0; $s < count($ls); $s++) { 
                if ($s == 0) {
                    continue;
                }
                $this->Type[$ls[$s]] = $ls[0];
            }
        }
    }
    public function GetData(){
        return $this->Type;
    }
    public function Get(){
        $ext = Request::ext();
        if ($ext == '') {
            return 'application/octet-stream';
        }
        if (isset($this->Type[$ext])) {
            return $this->Type[$ext];
        }
        return 'application/octet-stream';
    }
    public function where_data($data_array){
       $new = array();
       foreach ($data_array as $key => $value) {
          if(!empty($value)){

           $value = trim($value);//首先去掉头尾空格
           $value = str_replace(["\r\n","\n","\r"], "", $value); 
           $new[] = str_replace(';','',$value);
          }
       }
       return $new;
    }

}
