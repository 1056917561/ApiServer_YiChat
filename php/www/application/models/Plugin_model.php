<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 插件管理
 * @author 费尔
 */
class Plugin_model extends CI_Model {

    public $tables = 'plugin';

    public function get_noverify() {
        return ['Auth', 'Plugin', 'Welcome'];
    }

    /**
     * 检测插件是否安装
     */
    public function check_plugin($name) {
        return $this->db->get_where($this->tables, ['name' => $name, 'uid' => COMPANY_ID], 1)->row_array();
    }

    /**
     * 初始导航
     */
    public function init_plugin($path) {
        $file = [];
        $handle = opendir($path);
        if ($handle) {
            while (FALSE !== ($filename = readdir($handle))) {
                if ($filename{0} == '.') {
                    continue;
                }
                $name = basename($filename, '.php');
                if (!in_array($name, $this->get_noverify())) {
                    require_once ($path . DIRECTORY_SEPARATOR . $filename);
                    $file[] = $name;
                }
            }
            closedir($handle);
        }
    
        $authority = [];
        if (!empty($file)) {
            $this->load->library('PHPDocParser');
            for ($index = 0; $index < count($file); $index++) {
                $authority[] = $this->reflection_class($file[$index]);
            }
        }//var_dump($authority);exit;
        if (!empty($authority)) {
            $this->load->library('SortArray');
            $authority = $this->sortarray->arrayAsc($authority);
            $plugin = $this->get_plugin();
            for ($index1 = 0; $index1 < count($authority); $index1++) {
                if (!empty($plugin[$authority[$index1]['name']])) {
                    $authority[$index1]['plugin'] = !empty($plugin[$authority[$index1]['name']]) ? TRUE : FALSE;
                    $authority[$index1]['method'] = $this->get_method($authority[$index1]['name']);
                }
            }
        }
        return $authority;
    }

    /**
     * 返回导航
     * @return array
     */
    public function get_plugin() {
        $list = $this->db->where(['uid' => COMPANY_ID])->get($this->tables)->result_array();
        if (!empty($list)) {
            $lists = [];
            for ($index = 0; $index < count($list); $index++) {
                $lists[$list[$index]['name']] = $list[$index];
            }
        }
        return !empty($lists) ? $lists : [];
    }

    /**
     * 分析控制器
     * @param string $class
     * @return array
     */
    public function get_method($class) {

        $parser = $this->phpdocparser;
        $reflection = new ReflectionClass($class);
//        $parser->init($reflection->getDocComment());
//        $parser->parse();
//        $params = $parser->getParams();
        $list = [];

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (strpos($method->name, '_') === FALSE && !empty($method->getDocComment())) {
                $parser->init($method->getDocComment());
                $parser->parse();
                $params = $parser->getParams();
                $list[] = [
                    'name' => $method->name,
                    'desc' => $parser->getDesc() ?: $parser->getShortDesc(),
                    'author' => $params['author'] ?? '',
                    'icon' => $params['icon'] ?? '',
                    'nav' => !empty($params['nav']) ? TRUE : FALSE,
                    'sort' => !empty($params['sort']) ? (int) $params['sort'] : 0,
                    'private' =>!empty($params['private'])?:'',
                ];
            }
        }
        return $list;
    }

    /**
     * 分析类
     * @param string $name
     * @return array
     */
    public function reflection_class($name) {
        $class = $name;
        $parser = $this->phpdocparser;
        $reflection = new ReflectionClass($class);
        $parser->init($reflection->getDocComment());
        $parser->parse();
        $params = $parser->getParams();
        $list = [];
        $list['name'] = $reflection->name;
        $list['desc'] = $parser->getDesc() ?: $parser->getShortDesc();
        $list['author'] = !empty($params['author']) ? $params['author'] : '';
        $list['version'] = !empty($params['version']) ? $params['version'] : '0.0';
        $list['link'] = !empty($params['link']) ? $params['link'] : '';
        $list['nav'] = !empty($params['nav']) ? 1 : 0;
        $list['icon'] = !empty($params['icon']) ? $params['icon'] : '';
        $list['sort'] = !empty($params['sort']) ? (int) $params['sort'] : 0;
        $list['setting'] = !empty($params['setting']) ? 1 : 0;
        $list['example'] = !empty($params['icon']) ? $params['example'] : ''; 
        return !empty($list) ? $list : null;
    }

    /**
     * 安装
     */
    public function install($name) {
        $data = [];
        $data['name'] = $name;
        $data['uid'] = COMPANY_ID;
        return !$this->db->get_where($this->tables, $data, 1)->row_array() && $this->db->insert($this->tables, $data);
    }

    /**
     * 卸载
     */
    public function delete($name) {
        $where = [];
        $where['name'] = $name;
        $where['uid'] = COMPANY_ID;
        return $this->db->get_where($this->tables, $where, 1)->row_array() && $this->db->limit(1)->where($where)->delete($this->tables);
    }

}
