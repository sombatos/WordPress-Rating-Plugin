<?php
/*
  Plugin Name: Rating Plus
  Plugin URI: https://github.com/sombatos/WordPress-Rating-Plugin
  Description: A simple and clean rating widget plugin allowing to add a sexy rate button to the widgets area.
  Version: 1.0.0
  Author: sombatos
  Author URI: 
 */

define('RATING_PLUS_I18N', 'rating-plus');

function rp_admin_enqueue_scripts() {
    $assets_url = plugin_dir_url( __FILE__ ) . 'assets/';

    wp_register_style('select2css', $assets_url.'/css/select2.css', false, '1.0', 'all');
    wp_register_script('select2', $assets_url.'/js/select2.js', array( 'jquery' ), '1.0', true);

    wp_enqueue_style('select2css');
    wp_enqueue_script('select2');
}
add_action('admin_enqueue_scripts', 'rp_admin_enqueue_scripts');

class RatingPlusWidget extends WP_Widget {

    public static $instance_default = array(
        'title'  => 'Rate This Page',
        'icon_l' => 'thmb5-u',
        'icon_d' => 'thmb5-d',
        'icon_size' => '37',
        'i18n_like' => 'Like'
    );

    static public $icons = array(
        'hrt1',
        'hrt10',
        'hrt11',
        'hrt12',
        'hrt13',
        'hrt2',
        'hrt3',
        'hrt4',
        'hrt5',
        'hrt6',
        'hrt6-o',
        'hrt7',
        'hrt7-o',
        'hrt8',
        'hrt9',
        'thmb3-u',
        'thmb3-d',
        'thmb4-u',
        'thmb4-d',
        'thmb5-u',
        'thmb5-d',
        'thmb7-u',
        'thmb7-d',
        'thmb8-u',
        'thmb8-d',
        'thmb9-v',
        'thmb9-u',
        'thmb2-u',
        'thmb2-d',
        'thmb1',
        'thmb6',
        'alrt1',
        'alrt2',
        'arr1-d',
        'arr1-u',
        'arr10-d',
        'arr10-u',
        'arr11-d',
        'arr11-l',
        'arr11-r',
        'arr11-u',
        'arr12-d',
        'arr12-u',
        'arr13-d',
        'arr13-u',
        'arr14-d',
        'arr14-u',
        'arr15-d',
        'arr15-u',
        'arr16-d',
        'arr16-u',
        'arr17-d',
        'arr17-u',
        'arr18-d',
        'arr18-u',
        'arr19-d',
        'arr19-u',
        'arr2-d',
        'arr2-u',
        'arr3-d',
        'arr3-u',
        'arr4-d',
        'arr4-u',
        'arr5-d',
        'arr5-u',
        'arr6-d',
        'arr6-u',
        'arr7-d',
        'arr7-u',
        'arr8-d',
        'arr8-u',
        'arr9-d',
        'arr9-u',
        'blb1',
        'blb2',
        'bll',
        'bll-o',
        'bskt',
        'dmnd',
        'flg1',
        'flg2',
        'flg2-f',
        'flg2-o',
        'lck1-c',
        'lck1-o',
        'lck2-c',
        'lck2-o',
        'rnd',
        'rnd-0',
        'sgn1-s',
        'sgn1-t',
        'sgn10-c',
        'sgn10-t',
        'sgn11-i',
        'sgn11-q',
        'sgn12-m',
        'sgn12-p',
        'sgn2-m',
        'sgn2-p',
        'sgn3-c',
        'sgn3-m',
        'sgn3-p',
        'sgn3-t',
        'sgn4-c',
        'sgn4-t',
        'sgn5-t',
        'sgn6-m',
        'sgn6-p',
        'sgn7-c',
        'sgn7-m',
        'sgn7-p',
        'sgn7-t',
        'sgn8-c',
        'sgn8-m',
        'sgn8-p',
        'sgn8-t',
        'sgn9-f',
        'sky-sn',
        'sky-mn',
        'sml1',
        'sml2',
        'sml3-h',
        'sml3-n',
        'sml3-u',
        'stck',
        'str1',
        'str1-o',
        'str2',
        'str2-o',
        'trsh',
        'usr1',
        'usr1-o',
        'usr2-c',
        'usr2-p',
        'vlm1-d',
        'vlm1-u',
        'zap',
        'zm-in',
        'zm-out',
    );

    function __construct() {
        $widget_ops = array('description' => __('Clean rating widget', RATING_PLUS_I18N));
        parent::__construct(false, __('Rating Plus', RATING_PLUS_I18N), $widget_ops);
    }

    function form($instance) {
        $widget_id = time()+mt_rand(0, 10000000);

        $instance = $this->sanitizeInstance($instance);

        ?>
        <div id="rating_plus_<?php echo $widget_id; ?>" class="rp-widget">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', RATING_PLUS_I18N); ?>:</label>
                <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('icon_l'); ?>"><?php _e('Like Icon', RATING_PLUS_I18N); ?>:</label>
                <select name="<?php echo $this->get_field_name('icon_l'); ?>" id="<?php echo $this->get_field_id('icon_l'); ?>" class="rp-icon-select widefat">
                    <?php foreach (self::$icons as $icon): ?>
                        <option value="<?php echo $icon; ?>" <?php selected($icon, $instance['icon_l']); ?> ><?php echo $icon; ?></option>
                    <?php endforeach ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('icon_d'); ?>"><?php _e('Dislike Icon', RATING_PLUS_I18N); ?>:</label>
                <select name="<?php echo $this->get_field_name('icon_d'); ?>" id="<?php echo $this->get_field_id('icon_d'); ?>" class="rp-icon-select widefat">
                    <?php foreach (self::$icons as $icon): ?>
                        <option value="<?php echo $icon; ?>" <?php selected($icon, $instance['icon_d']); ?> ><?php echo $icon; ?></option>
                    <?php endforeach ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('icon_size'); ?>"><?php _e('Icon Size', RATING_PLUS_I18N); ?>:</label>
                <input class="widefat" type="number" id="<?php echo $this->get_field_id('icon_size'); ?>" name="<?php echo $this->get_field_name('icon_size'); ?>" value="<?php echo $instance['icon_size']; ?>" min="5" max="500" maxlenght="3"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('i18n_like'); ?>"><?php _e('Like Text', RATING_PLUS_I18N); ?>:</label>
                <input class="widefat" type="text" id="<?php echo $this->get_field_id('i18n_like'); ?>" name="<?php echo $this->get_field_name('i18n_like'); ?>" value="<?php echo $instance['i18n_like']; ?>" />
            </p>
        </div>
        <link rel="stylesheet" href="//w.likebtn.com/css/w/icons.css">
        <style>
            /*.rp-icon-select.select2-container {
                width: 100%;
            }*/
            .rp-icon-select.select2-container .lb-fi,
            .select2-results .lb-fi {
                font-size: 22px;
            }
            .select2-celled .select2-results li {
                display: inline-block;
                width: 43px;
                text-align: center;
            }
        </style>
        <script type="text/javascript">
            function rpIconSelectFormat(state) {
                return '<i class="lb-fi lb-fi-'+state.id+'"></i>';
            }
            jQuery(document).on('touchcancel', '.select2-chosen', function(e) {
                var field = jQuery(e.target);
                field.trigger('touchstart');
                return field.trigger('touchend');
            });
            jQuery(document).ready(function() {
                jQuery("#rating_plus_<?php echo $widget_id; ?> select.rp-icon-select").select2({
                    dropdownCssClass: 'select2-celled',
                    minimumResultsForSearch: -1,
                    formatResult: rpIconSelectFormat,
                    formatSelection: rpIconSelectFormat,
                    escapeMarkup: function(m) { return m; }
                });
            });
        </script>
        <?php
    }

    function sanitizeInstance($instance) {
        if (!isset($instance['title'])) {
            $instance['title'] = __(self::$instance_default['title'], RATING_PLUS_I18N);
        }
        if (empty($instance['icon_l'])) {
            $instance['icon_l'] = self::$instance_default['icon_l'];
        }
        if (empty($instance['icon_d'])) {
            $instance['icon_d'] = self::$instance_default['icon_d'];
        }
        if (empty($instance['icon_size'])) {
            $instance['icon_size'] = self::$instance_default['icon_size'];
        }
        if (!isset($instance['i18n_like'])) {
            $instance['i18n_like'] = self::$instance_default['i18n_like'];
        }

        return $instance;
    }


    function widget($args, $instance) {
        global $post;

        $instance = $this->sanitizeInstance($instance);

        if (is_array($instance)) {
            extract($instance);
        }

        $identifier = '';
        $post_id = '';
        $post_type = '';
        if ($post) {
            $post_id = $post->ID;

            if (empty($post->post_type)) {
                $post_type = $post->post_type;
            } else {
                $post_type = 'post';
            }
        }
        if ($post_id && $post_type) {
            $identifier = $post_type.'_'.$post_id;
        }

        $extra = '';
        if (!$instance['i18n_like']) {
            $extra .= ' data-show_like_label="false" ';
        }

        $widget_html = <<<WIDGET_HTML
<!-- LikeBtn.com BEGIN -->
<span class="likebtn-wrapper" data-theme="custom" data-btn_size="{$instance['icon_size']}" data-f_size="24" data-icon_l="{$instance['icon_l']}" data-icon_d="{$instance['icon_d']}" data-icon_size="{$instance['icon_size']}" data-icon_l_c="#3498db" data-icon_d_c="#3498db" data-bg_c="transparent" data-brdr_c="rgba(0,0,0,0)" data-identifier="{$identifier}" data-i18n_like="{$instance['i18n_like']}" {$extra}></span>
<script>(function(d,e,s){if(d.getElementById("likebtn_wjs"))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id="likebtn_wjs";a.src=s;m.parentNode.insertBefore(a, m)})(document,"script","//w.likebtn.com/js/w/widget.js");</script>
<!-- LikeBtn.com END -->
WIDGET_HTML;

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'].$instance['title'].$args['after_title'];
        }
        echo $widget_html;
        echo $args['after_widget'];
    }
}

function rp_widgets_init() {
    register_widget('RatingPlusWidget');
}
add_action('widgets_init', 'rp_widgets_init' );
