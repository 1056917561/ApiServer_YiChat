<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 文件管理
 * 
 * @version 0.1
 * @sort 5
 * @nav TRUE
 * @icon fa-file-image-o
 * 
 */
class File extends AdminBase {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 文件管理
     * 
     * @icon fa-file-image-o
     * @nav TRUE
     */
    public function index() {
        $this->parser->parse();
    }

    /**
     * 浏览
     */
    public function manager() {
        $this->load->model('file_model');
        
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
        $user = md5(COMPANY_ID . '-5014c77e08495c90dd664bc3f6f81c36');
        $path = DIRECTORY_SEPARATOR . 'attached' . DIRECTORY_SEPARATOR . $user . DIRECTORY_SEPARATOR;
//根目录路径，可以指定绝对路径
        $root_path = $root . $path;
//根目录URL，可以指定绝对路径
        $root_url = '/attached/' . $user . '/';
//图片扩展名
        $ext_arr = ['gif', 'jpg', 'jpeg', 'png', 'bmp'];

        $dirs = [
            'image' => 'images',
            'flash' => 'files',
            'media' => 'files',
            'file' => 'files'
        ];

        //检查目录名
        $name = $this->input->post_get('dir') ?: 'image';


        $dirname = isset($dirs[$name]) ? $dirs[$name] : 'images';

        if ($dirname !== '') {
            $root_path .= $dirname . DIRECTORY_SEPARATOR;
            $root_url .= $dirname . "/";
            
            $this->file_model->makeDirectory($root_path);
        }

//根据path参数，设置各路径和URL
        if (!$this->input->post_get('path')) {
            $current_path = realpath($root_path) . '/';
            $current_url = $root_url;
            $current_dir_path = '';
            $moveup_dir_path = '';
        } else {
            $current_path = realpath($root_path) . DIRECTORY_SEPARATOR . $this->input->post_get('path');
            $current_url = $root_url . $this->input->post_get('path');
            $current_dir_path = $this->input->post_get('path');
            $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
        }
//echo realpath($root_path);
//排序形式，name or size or type
        $order = !$this->input->post_get('order') ? 'name' : strtolower($this->input->post_get('order'));

//不允许使用..移动到上一级目录
        if (preg_match('/\.\./', $current_path)) {
            echo 'Access is not allowed.';
            exit;
        }
//最后一个字符不是/
        if (!preg_match('/\/$/', $current_path)) {
            echo 'Parameter is not valid.';
            exit;
        }
//目录不存在或不是目录
        if (!file_exists($current_path) || !is_dir($current_path)) {
            echo 'Directory does not exist.';
            exit;
        }

//遍历目录取得文件信息
        $file_list = array();
        if ($handle = opendir($current_path)) {
            $i = 0;
            while (false !== ($filename = readdir($handle))) {
                if ($filename{0} == '.')
                    continue;
                $file = $current_path . $filename;
                if (is_dir($file)) {
                    $file_list[$i]['is_dir'] = TRUE; //是否文件夹
                    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
                    $file_list[$i]['filesize'] = 0; //文件大小
                    $file_list[$i]['is_photo'] = FALSE; //是否图片
                    $file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
                } else {
                    $file_list[$i]['is_dir'] = FALSE;
                    $file_list[$i]['has_file'] = FALSE;
                    $file_list[$i]['filesize'] = filesize($file);
                    $file_list[$i]['dir_path'] = '';
                    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
                    $file_list[$i]['filetype'] = $file_ext;
                }
                $file_list[$i]['filename'] = $filename; //文件名，包含扩展名
                $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
                $i++;
            }
            closedir($handle);
        }

        $this->load->library('SortArray');

        if ($order == 'size') {
            $file_list = $this->sortarray->arrayDesc($file_list, 'filesize');
        } elseif ($order == 'type') {
            $file_list = $this->sortarray->arrayDesc($file_list, 'filetype');
        } else {
            $file_list = $this->sortarray->arrayDesc($file_list, 'filename');
        }


        $result = [];
//相对于根目录的上一级目录
        $result['moveup_dir_path'] = $moveup_dir_path;
//相对于根目录的当前目录
        $result['current_dir_path'] = $current_dir_path;
//当前目录的URL
        $result['current_url'] = $current_url;
//文件数
        $result['total_count'] = count($file_list);
//文件列表数组
        $result['file_list'] = $file_list;

//输出JSON字符串
        $this->showJson($result);
    }

    /**
     * 上传
     */
    public function upload() {

        $extarr = [
            'image' => ['gif', 'jpg', 'jpeg', 'png'],
            'flash' => ['swf', 'flv'],
            'media' => ['swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'],
            'file' => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'],
        ];
        $dirs = [
            'image' => 'images',
            'flash' => 'files',
            'media' => 'files',
            'file' => 'files'
        ];

        //检查目录名
        $name = $this->input->post_get('dir') ?: 'image';

        $dirname = isset($dirs[$name]) ? $dirs[$name] : 'images';

        $config = [];
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
        $path = DIRECTORY_SEPARATOR . 'attached' . DIRECTORY_SEPARATOR . md5(COMPANY_ID . '-5014c77e08495c90dd664bc3f6f81c36') . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR . date('Y-m-d') . DIRECTORY_SEPARATOR;
        $config['upload_path'] = $root . $path;
        //$config['upload_path'] = FCPATH . 'attached' . DIRECTORY_SEPARATOR . COMPANY_ID . DIRECTORY_SEPARATOR;
        $config['file_ext_tolower'] = TRUE;
        $config['overwrite'] = FALSE;
        $config['allowed_types'] = implode('|', $extarr[$name]);
        $this->load->model('file_model');
        $this->file_model->makeDirectory($config['upload_path']);
        $this->load->library('upload', $config);


        if (!$this->upload->do_upload('imgFile')) {
            $this->showJson(['error' => 1, 'message' => $this->upload->display_errors()]);
        } else {
            $data = $this->upload->data();
            $url = substr($data['full_path'], strlen($root));
            $this->showJson(['error' => 0, 'url' => str_replace(DIRECTORY_SEPARATOR, '/', $url)]);
        }
    }

}
