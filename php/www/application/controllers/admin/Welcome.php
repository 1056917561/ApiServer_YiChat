<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends AdminBase {

    public function index() {
        $this->data['user'] = $this->ion_auth->user()->row_array();
        $this->parser->parse($this->data);
    }

    public function navs() {
        $navs = $this->plugin_model->init_plugin(__DIR__);
        $user = $this->ion_auth->user()->row_array();
        $list = [];
        for ($index = 0; $index < count($navs); $index++) {
            if (!empty($navs[$index]['plugin']) && !empty($navs[$index]['nav'])) {
                $list[$index]['title'] = $navs[$index]['desc'];
                $list[$index]['icon'] = !empty($navs[$index]['icon']) ? $navs[$index]['icon'] : '';
                $list[$index]['spread'] = $index === 0 ? true : false;
                if (!empty($navs[$index]['method'])) {
                    for ($index1 = 0; $index1 < count($navs[$index]['method']); $index1++) {
                        if (!empty($navs[$index]['method'][$index1]['nav']) && ($navs[$index]['method'][$index1]['private']=='admin' && empty($user['region']) || $navs[$index]['method'][$index1]['private']!='admin')) {
                            $list[$index]['children'][] = [
                                'title' => $navs[$index]['method'][$index1]['desc'],
                                'icon' => $navs[$index]['method'][$index1]['icon'],
                                'href' => site_url($navs[$index]['name'] . '/' . $navs[$index]['method'][$index1]['name']),
                            ];
                        }
                    }
                }
            }
        }
        $lists = [];
        foreach ($list as $value) {
            $lists[] = $value;
        }
        $js = 'var navs =';
        $js .= json_encode($lists, JSON_UNESCAPED_UNICODE);
        $js .= ';';
        //header('Content-type:application/javascript;charset=utf-8');
        echo $js;
    }

    public function main() {
        $this->parser->parse();
    }

}
