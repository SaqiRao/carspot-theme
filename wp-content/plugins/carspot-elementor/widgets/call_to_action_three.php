<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Call_To_Action_Three extends Widget_Base {

    public function get_name() {
        return 'call_to_action_three_shortcode';
    }

    public function get_title() {
        return __('Call to Action Three', 'cs-elementor');
    }

    public function get_icon() {
        return 'eicon-animation';
    }

    public function get_categories() {
        return ['cstheme'];
    }

    public function get_script_depends() {
        return [''];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls() {
        /* for GEneral tab */
        $this->start_controls_section(
            'call_action_3_general_tab',
            [
                'label' => __('General', 'cs-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'bg_img',
            [
                'label' => __('Background Image', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label_block' => true,
                'description' => __('Recommended Size For Image should be 1280x800.png', 'cs-elementor'),
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => ''
                ],
            ]
        );
        $this->end_controls_section();
        /* for Left tab */
        $this->start_controls_section(
                'call_action_3_left_tab',
                [
                    'label' => __('Left Side', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'tagline_left',
                [
                    'label' => __('Left Side Tagline', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'title_left',
                [
                    'label' => __('Left Side Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'desc_left',
                [
                    'label' => __('Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'btn_title',
                [
                    'label' => __('Button Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => __('Button title here', 'cs-elementor'),
                    'default' => __('Button Link', 'cs-elementor'),
                    'label_block' => true
                ]
        );
        $this->add_control(
                'btn_link',
                [
                    'label' => __('Button Link', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __('https://your-link.com', 'cs-elementor'),
                    'label_block' => true,
                    'show_external' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        );
        $this->add_control(
                'left_car_img',
                [
                    'label' => __('Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'description' => __('Recommended Size For Image should be 1280x800.png', 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->end_controls_section();

        /* for Right tab */
        $this->start_controls_section(
                'call_action_3_right_tab',
                [
                    'label' => __('Right Side', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'tagline_right',
                [
                    'label' => __('Right Side Tagline', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'title_right',
                [
                    'label' => __('Right Side Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'desc_right',
                [
                    'label' => __('Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'btn_title1',
                [
                    'label' => __('Button Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => __('Button title here', 'cs-elementor'),
                    'default' => __('Button Link', 'cs-elementor'),
                    'label_block' => true
                ]
        );
        $this->add_control(
                'btn_link1',
                [
                    'label' => __('Button Link', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __('https://your-link.com', 'cs-elementor'),
                    'label_block' => true,
                    'show_external' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        );
        $this->add_control(
                'right_car_img',
                [
                    'label' => __('Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'description' => __('Recommended Size For Image should be 1280x800.png', 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['bg_img'] = $settings['bg_img']['id'] ? $settings['bg_img']['id'] : '';
        //left
        $params['tagline_left'] = $settings['tagline_left'] ? $settings['tagline_left'] : '';
        $params['title_left'] = $settings['title_left'] ? $settings['title_left'] : '';
        $params['desc_left'] = $settings['desc_left'] ? $settings['desc_left'] : '';
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        $params['left_car_img'] = $settings['left_car_img']['id'] ? $settings['left_car_img']['id'] : '';
        //right
        $params['tagline_right'] = $settings['tagline_right'] ? $settings['tagline_right'] : '';
        $params['title_right'] = $settings['title_right'] ? $settings['title_right'] : '';
        $params['desc_right'] = $settings['desc_right'] ? $settings['desc_right'] : '';
        $params['btn_title1'] = $settings['btn_title1'] ? $settings['btn_title1'] : '';
        $params['btn_link1'] = $settings['btn_link1']['url'] ? $settings['btn_link1']['url'] : '';
        $params['target_two'] = $settings['btn_link1']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_two'] = $settings['btn_link1']['nofollow'] ? ' rel="nofollow"' : '';
        $params['right_car_img'] = $settings['right_car_img']['id'] ? $settings['right_car_img']['id'] : '';

        echo cs_elementor_call_to_action_three($params);
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _content_template() {
        
    }
}