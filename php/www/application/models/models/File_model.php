<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 文件管理
 * @author 费尔
 */
class File_model extends CI_Model {

    public $mimefile = [
        'image/bmp' => 'bmp',
        'image/cgm' => 'cgm',
        'image/g3fax' => 'g3',
        'image/gif' => 'gif',
        'image/ief' => 'ief',
        'image/jpeg' => 'jpg',
        'image/ktx' => 'ktx',
        'image/png' => 'png',
        'image/prs.btif' => 'btif',
        'image/sgi' => 'sgi',
        'image/svg+xml' => 'svg',
        'image/tiff' => 'tiff',
        'image/vnd.adobe.photoshop' => 'psd',
        'image/vnd.dece.graphic' => 'uvi',
        'image/vnd.dvb.subtitle' => 'sub',
        'image/vnd.djvu' => 'djvu',
        'image/vnd.dwg' => 'dwg',
        'image/vnd.dxf' => 'dxf',
        'image/vnd.fastbidsheet' => 'fbs',
        'image/vnd.fpx' => 'fpx',
        'image/vnd.fst' => 'fst',
        'image/vnd.fujixerox.edmics-mmr' => 'mmr',
        'image/vnd.fujixerox.edmics-rlc' => 'rlc',
        'image/vnd.ms-modi' => 'mdi',
        'image/vnd.ms-photo' => 'wdp',
        'image/vnd.net-fpx' => 'npx',
        'image/vnd.wap.wbmp' => 'wbmp',
        'image/vnd.xiff' => 'xif',
        'image/webp' => 'webp',
        'image/x-3ds' => '3ds',
        'image/x-cmu-raster' => 'ras',
        'image/x-cmx' => 'cmx',
        'image/x-freehand' => 'fh',
        'image/x-icon' => 'ico',
        'image/x-mrsid-image' => 'sid',
        'image/x-pcx' => 'pcx',
        'image/x-pict' => 'pic',
        'image/x-portable-anymap' => 'pnm',
        'image/x-portable-bitmap' => 'pbm',
        'image/x-portable-graymap' => 'pgm',
        'image/x-portable-pixmap' => 'ppm',
        'image/x-rgb' => 'rgb',
        'image/x-tga' => 'tga',
        'image/x-xbitmap' => 'xbm',
        'image/x-xpixmap' => 'xpm',
        'image/x-xwindowdump' => 'xwd'
    ];

    /**
     * 远程图片本地化
     * @param string $content
     * @param bool $htmlspecialchars html实体
     * @return string
     */
    public function img_location($content, $htmlspecialchars = FALSE) {
        set_time_limit(0);
        if (empty($content)) {
            return '';
        }
        $content = preg_replace_callback('/<img.*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/', [$this, 'res_img'], $htmlspecialchars ? htmlspecialchars_decode($content) : $content);
        if ($htmlspecialchars) {
            return htmlspecialchars($content);
        } else {
            return $content;
        }
    }

    private function res_img($value) {

        $imgUrl = $value[1];
        if (strpos($imgUrl, "http") !== 0) {
            return '<img src="' . $value[1] . '" />';
        }

        preg_match('/(^https*:\/\/[^:\/]+)/', $imgUrl, $matches);
        $host_with_protocol = count($matches) > 1 ? $matches[1] : '';


// 判断是否是合法 url
        if (!filter_var($host_with_protocol, FILTER_VALIDATE_URL)) {
            return '<img src="' . $value[1] . '" />';
        }

        preg_match('/^https*:\/\/(.+)/', $host_with_protocol, $matches);
        $host_without_protocol = count($matches) > 1 ? $matches[1] : '';

// 此时提取出来的可能是 ip 也有可能是域名，先获取 ip
        $ip = gethostbyname($host_without_protocol);
// 判断是否是私有 ip
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
            return '<img src="' . $value[1] . '" />';
        }

//获取请求头并检测死链
        $heads = get_headers($imgUrl, 1);
        if (!(stristr($heads[0], "200") && stristr($heads[0], "OK"))) {
            return '<img src="' . $value[1] . '" />';
        }

//格式验证(扩展名验证和Content-Type验证)
        if (!isset($heads['Content-Type']) || !($fileType = $this->mimefile[$heads['Content-Type']] ?? null) || !stristr($heads['Content-Type'], "image")) {
            return '<img src="' . $value[1] . '" />';
        }
//打开输出缓冲区并获取远程图片
        ob_start();
        $context = stream_context_create(
                ['http' => ['follow_location' => false]]
        );
        readfile($imgUrl, false, $context);
        $img = ob_get_contents();
        ob_end_clean();


//文件保存目录路径
        $save_path = $this->get_save_path();
//文件保存目录URL
        $save_url = $this->get_save_url();



//新文件名
        $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $fileType;
//移动文件
        $file_path = $save_path . $new_file_name;
        $this->makeDirectory(dirname($file_path));
//文件URL
        $file_url = $save_url . $new_file_name;
        file_put_contents($file_path, $img);
        if (file_exists($file_path)) {
            return '<img src="' . $file_url . '" />';
        } else {
            return '<img src="' . $value[1] . '" />';
        }
    }

    /**
     * 文件保存目录路径
     */
    public function get_absolute_path() {
        return rtrim($this->get_setting('absolutepath') ?: rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . DIRECTORY_SEPARATOR . 'attached', '/\\') . DIRECTORY_SEPARATOR;
    }

    /**
     * 文件保存目录URL
     */
    public function get_absolute_url() {
        return rtrim($this->get_setting('absoluteurl') ?: str_replace(DIRECTORY_SEPARATOR, '/', DIRECTORY_SEPARATOR . 'attached'), '/\\') . DIRECTORY_SEPARATOR;
    }

    /**
     * 文件保存目录路径
     */
    public function get_save_path() {
        return $this->get_absolute_path() . md5(USER_UID . '-5014c77e08495c90dd664bc3f6f81c36') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . date('Y-m-d') . DIRECTORY_SEPARATOR;
    }

    /**
     * 文件保存目录URL
     */
    public function get_save_url() {
        return str_replace($this->get_absolute_url() . md5(USER_UID . '-5014c77e08495c90dd664bc3f6f81c36') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . date('Y-m-d') . DIRECTORY_SEPARATOR);
    }

    /**
     * 创建目录
     * @access public
     * @param string $path 路径
     * @param string $mode 权限
     * @return string 如果已经存在则返回YES，否则为flase
     */
    public function makeDirectory($path, $mode = 0755) {
        if (is_dir($path)) {
            return true;
        } else {
            $_path = dirname($path);
            if ($_path !== $path) {
                $this->makeDirectory($_path, $mode);
            }
            return mkdir($path, $mode);
        }
    }

    /**
     * 设置
     * @return boolean
     */
    public function setting() {
        $return = FALSE;
        $_setting = [];
        foreach (['method', 'hostname', 'username', 'password', 'port', 'absolutepath', 'absoluteurl'] as $value) {
            $data = '';
            $data = $this->input->post($value) ?: '';
            if ($this->db->replace('c_setting_file', ['key' => $value, 'value' => serialize($data)])) {
                $return = TRUE;
            }
            $_setting[$value] = $data;
        }
        $this->cache->save('c_setting_file', $_setting);
        return $return;
    }

    /**
     * 返回配制
     * @staticvar array $_setting
     * @param string $key
     * @return array
     */
    public function get_setting($key = NULL) {
        static $_setting = [];
        if (empty($_setting) && !( $_setting = $this->cache->get('c_setting_file'))) {
            $_setting = [];
            foreach ($this->db->get('c_setting_file')->result_array() as $value) {
                $value['key'] = $value['key'];
                $_setting[$value['key']] = unserialize($value['value']);
            }
            $this->cache->save('c_setting_file', $_setting);
        }
        return !empty($key) ? (!empty($_setting[$key]) ? $_setting[$key] : NULL) : $_setting;
    }

}
