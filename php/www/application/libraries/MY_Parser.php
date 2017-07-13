<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * CI Smarty
 *
 * Smarty templating for Codeigniter
 *
 * @package   CI Smarty
 * @author    Dwayne Charrington
 * @copyright 2015 Dwayne Charrington and Github contributors
 * @link      http://ilikekillnerds.com
 * @license   MIT
 * @version   3.0
 */
class MY_Parser extends CI_Parser {

    protected $CI;
    protected $_template_locations = array();
// Current theme location
    protected $_current_path = NULL;
// The name of the theme in use
    protected $_theme_name = '';

    public function __construct() {
// Codeigniter instance and other required libraries/files
        $this->CI = get_instance();
        $this->CI->load->library('smarty');

// CI_Smarty
// Manual trigger CI_Smarty, otherwise unable to load the configuration file
        $this->CI->smarty = new CI_Smarty();

// Load the URL module
        $this->CI->load->helper(array('url', 'parser'));


// What controllers or methods are in use
        $this->_directory = strtolower($this->CI->router->fetch_directory());
        if (!empty($this->_directory)) {
            $this->_directory = rtrim(str_replace('\\', DIRECTORY_SEPARATOR, $this->_directory), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }
        $this->_controller = strtolower($this->CI->router->fetch_class());
        $this->_method = strtolower($this->CI->router->fetch_method());

        $this->CI->smarty->template_dir = array();

// If we don't have a theme name stored
        if ($this->_theme_name == '') {
            $this->set_theme($this->CI->config->item('smarty.theme_name'));
        }

// Update theme paths
//$this->_update_views_paths();
    }

    /**
     * Call
     * able to call native Smarty methods
     * @returns mixed
     */
    public function __call($method, $params = array()) {
        if (!method_exists($this, $method)) {
            return call_user_func_array(array($this->CI->smarty, $method), $params);
        }
    }

    /**
     * Set Theme
     *
     * Set the theme to use
     *
     * @access public
     * @param $name
     * @return string
     */
    public function set_theme($name) {
// Store the theme name
        $this->_theme_name = trim($name);

        $this->_theme_name = !empty($this->_theme_name) ? rtrim($this->_theme_name, '\\/') . DIRECTORY_SEPARATOR : '';
//        // Our themes can have a functions.php file just like Wordpress
//        $functions_file = $this->CI->config->item('smarty.theme_path') . $this->_theme_name . '/functions.php';
//
//        // Incase we have a theme in the application directory
//        $functions_file2 = APPPATH . "themes/" . $this->_theme_name . '/functions.php';
//
//        // If we have a functions file, include it
//        if (file_exists($functions_file)) {
//            include_once($functions_file);
//        } elseif (file_exists($functions_file2)) {
//            include_once($functions_file2);
//        }
// Update theme paths
        $this->_update_views_paths();
    }

    /**
     * Get Theme
     *
     * Does what the function name implies: gets the name of
     * the currently in use theme.
     *
     * @return string
     */
    public function get_theme() {
        return (isset($this->_theme_name)) ? $this->_theme_name : '';
    }

    /**
     * Parse
     *
     * Parses a template using Smarty 3 engine
     *
     * @access public
     * @param $data
     * @param $template
     * @param $return
     * @param $caching
     * @param $theme
     * @return string
     */
    public function parse($data = array(), $template = '', $return = FALSE, $caching = FALSE, $theme = '') {
// If we don't want caching, disable it
        if ($caching === FALSE) {
            $this->CI->smarty->disable_caching();
        }

        if (empty($template)) {
            $template = $this->_method;
        }

// If no file extension dot has been found default to defined extension for view extensions
        if (!stripos($template, '.')) {
            $template = $template . "." . $this->CI->smarty->template_ext;
        }

// Are we overriding the theme on a per load view basis?
        if (!empty($theme)) {
            $this->set_theme($theme);
        }



// If we have variables to assign, lets assign them
        if (!empty($data)) {
            foreach ($data AS $key => $val) {
                $this->CI->smarty->assign($key, $val);
            }
        }

// Load our template into our string for judgement
        $template_string = $this->CI->smarty->fetch($template);
        if ($this->CI->config->item('smarty.html_compress')) {
            $template_string = htmlCompress($template_string);
        }
// If we're returning the templates contents, we're displaying the template
        if ($return === FALSE) {
            $this->CI->output->append_output($template_string);
            return TRUE;
        }

// We're returning the contents, fo' shizzle
        return $template_string;
    }

    /**
     * CSS
     *
     * An asset function that returns a CSS stylesheet
     *
     * @access public
     * @param $file
     * @return string
     */
    public function css($file, $attributes = array()) {
        $defaults = array(
            'media' => 'screen',
            'rel' => 'stylesheet',
            'type' => 'text/css'
        );

        $attributes = array_merge($defaults, $attributes);
        $href = str_replace('\\', '/', $this->CI->config->item('smarty.theme_path') . $this->_theme_name . $this->_directory . $file);

        $return = '<link rel="' . $attributes['rel'] . '" type="' . $attributes['type'] . '" href="' . $href . '" media="' . $attributes['media'] . '">';

        return $return;
    }

    /**
     * JS
     *
     * An asset function that returns a script embed tag
     *
     * @access public
     * @param $file
     * @return string
     */
    public function js($file, $attributes = array()) {
        $defaults = array(
            'type' => 'text/javascript'
        );

        $attributes = array_merge($defaults, $attributes);

        $src = str_replace('\\', '/', $this->CI->config->item('smarty.theme_path') . $this->_theme_name . $this->_directory . $file);

        $return = '<script type="' . $attributes['type'] . '" src="' . $src . '"></script>';

        return $return;
    }

    /**
     * IMG
     *
     * An asset function that returns an image tag
     *
     * @access public
     * @param $file
     * @return string
     */
    public function img($file, $attributes = array()) {
        $defaults = array(
            'alt' => '',
            'title' => ''
        );

        $attributes = array_merge($defaults, $attributes);

        $src = str_replace('\\', '/', $this->CI->config->item('smarty.theme_path') . $this->_theme_name . $this->_directory . $file);

        $return = '<img src ="' . $src . '" alt="' . $attributes['alt'] . '" title="' . $attributes['title'] . '" class="' . $attributes['class'] . '" style="' . $attributes['style'] . '"/>';

        return $return;
    }

    /**
     * Theme URL
     *
     * A web friendly URL for determining the current
     * theme root location.
     *
     * @access public
     * @param $location
     * @return string
     */
    public function theme_url($location = '') {
// The path to return
        $return = str_replace('\\', '/', $this->CI->config->item('smarty.theme_path') . $this->_theme_name . $this->_directory);

// If we want to add something to the end of the theme URL
        if ($location !== '') {
            $return = $return . $location;
        }

        return trim($return);
    }

    /**
     * Add Paths
     *
     * Traverses all added template locations and adds them
     * to Smarty so we can extend and include view files
     * correctly from a slew of different locations including
     * modules if we support them.
     *
     * @access protected
     */
    protected function _add_paths() {
// Iterate over our saved locations and find the file
        foreach ($this->_template_locations AS $location) {
            $this->CI->smarty->addTemplateDir($location);
        }
    }

    /**
     * Update Theme Paths
     *
     * Adds in the required locations for themes
     *
     * @access protected
     */
    protected function _update_views_paths() {

        if (!empty($this->_directory)) {
            $this->_template_locations = array(
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_theme_name . $this->_directory . $this->_controller . DIRECTORY_SEPARATOR,
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_theme_name . $this->_directory,
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_theme_name . $this->_directory . 'layouts' . DIRECTORY_SEPARATOR
            );
        } else {
            $this->_template_locations = array(
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_theme_name . $this->_controller . DIRECTORY_SEPARATOR,
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_theme_name,
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_theme_name . 'layouts' . DIRECTORY_SEPARATOR . $this->_controller . DIRECTORY_SEPARATOR,
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_theme_name . 'layouts' . DIRECTORY_SEPARATOR,
            );
        }
// Will add paths into Smarty for "smarter" inheritance and inclusion
        $this->_add_paths();
    }

    /**
     * String Parse
     *
     * Parses a string using Smarty 3
     *
     * @param string $template
     * @param array $data
     * @param boolean $return
     * @param mixed $is_include
     */
    public function string_parse($template, $data = array(), $return = FALSE, $is_include = FALSE) {
        return $this->CI->smarty->fetch('string:' . $template, $data);
    }

    /**
     * Parse String
     *
     * Parses a string using Smarty 3. Never understood why there
     * was two identical functions in Codeigniter that did the same.
     *
     * @param string $template
     * @param array $data
     * @param boolean $return
     * @param mixed $is_include
     */
    public function parse_string($template, $data = array(), $return = FALSE, $is_include = false) {
        return $this->string_parse($template, $data, $return, $is_include);
    }

}
