<?php
namespace ButtonZ\Widgets;

use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Ub_Button
 * @package Elementor
 */
class Button extends Widget_Base {
    public function get_name() {
        return 'buttonz-button';
    }

    public function get_title() {
        return __( 'ButtonZ Button', 'buttonz' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_style_depends() {
        return [ 'hover' ];
    }

    public function get_categories() {
        return [ 'theme-elements' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_btn',
            [
                'label' => __( 'Button', 'buttonz' ),
            ]
        );

        $this->add_control(
            'btn_style',
            [
                'label' => __( 'Button Type', 'buttonz' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default'=> esc_html__( 'Default', 'buttonz' ),
                    'line' => esc_html__( 'Line Button', 'buttonz' ),
                    'three_d_btn' => esc_html__( '3D Fold Bottom', 'buttonz' ),
                    'three_d_btn2' => esc_html__( '3d Fold Top', 'buttonz' ),
                ],
                'label_block' => true,
                'default' => 'default',
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__( 'Button Title', 'buttonz' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Learn More'
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'buttonz' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://your-link.com', 'buttonz' ),
                'default' => [
                    'url' => '#'
                ]
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'buttonz' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left', 'buttonz' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'buttonz' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'buttonz' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justified', 'buttonz' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default' => '',
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => __( 'Size', 'buttonz' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'sm',
                'options' => array(
                    'xs' => __( 'Extra Small', 'buttonz' ),
                    'sm' => __( 'Small', 'buttonz' ),
                    'md' => __( 'Medium', 'buttonz' ),
                    'lg' => __( 'Large', 'buttonz' ),
                    'xl' => __( 'Extra Large', 'buttonz' ),
                ),
                'style_transfer' => true,
            ]
        );

        $this->end_controls_section();

        /**
         * Button Icon
         */
        $this->start_controls_section(
            'btn-icon',
            [
                'label' => __( 'Button Icon', 'buttonz' ),
            ]
        );

        $this->add_control(
            'icon_type',
            [
                'label' => __( 'Icon Type', 'buttonz' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => __( 'Font Icon', 'buttonz' ),
                    'image' => __( 'Image', 'buttonz' ),
                ],
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label' => __( 'Icon', 'buttonz' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'condition' => [
                    'icon_type' => ['icon']
                ]
            ]
        );

        $this->add_control(
            'image_icon',
            [
                'label' => __( 'Image Icon', 'buttonz' ),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'icon_type' => ['image']
                ]
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label' => __( 'Icon Position', 'buttonz' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => __( 'Before', 'buttonz' ),
                    'right' => __( 'After', 'buttonz' ),
                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label' => __( 'Icon Spacing', 'buttonz' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .buttonz-btn .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_animation',
            [
                'label' => __( 'Hover Animation', 'buttonz' ),
                'type' => Controls_Manager::SELECT2,
                'options' => buttonz_icon_hover_anim(),
            ]
        );

        $this->end_controls_section();


        /**
         * 3D Settings
         */
        $this->start_controls_section(
            'btn-3d-settings',
            [
                'label' => __( '3D Settings', 'buttonz' ),
                'condition' => [
                    'btn_style' => ['three_d_btn', 'three_d_btn2'],
                ]
            ]
        );

        $this->add_control(
            'action_state',
            [
                'label' => __( 'Action State', 'buttonz' ),
                'description' => __( 'Select the transition action state.', 'buttonz' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'click',
                'options' => [
                    'hover' => __( 'Hover', 'buttonz' ),
                    'click' => __( 'Click', 'buttonz' ),
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Button Effect
         */
        $this->start_controls_section(
            'section_btn_effects',
            [
                'label' => __( 'Button Effects', 'buttonz' ),
                'condition' => [
                    'btn_style' => ['default'],
                ]
            ]
        );

        $this->add_responsive_control(
            'hover_animation',
            [
                'label' => __( 'Hover Effect', 'buttonz' ),
                'type' => Controls_Manager::SELECT2,
                'options' => buttonz_hover_anim(),
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /** --------------------------------------------------------------------------------------------------------- */

        /**
         * Button Style
         */
        $this->start_controls_section(
            'style_button', [
                'label' => __( 'Style Button', 'buttonz' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_btn',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .buttonz-btn',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'buttonz' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Text Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background_color',
                'label' => __( 'Background Color', 'buttonz' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .buttonz-btn.three_d_btn .elementor-button-content-wrapper, {{WRAPPER}} .buttonz-btn.three_d_btn2, {{WRAPPER}} .buttonz-btn:not(.treed-btn)',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'buttonz' ),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __( 'Text Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn:not(.buttonz-animation-left2right):hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .buttonz-btn.buttonz-animation-left2right::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .buttonz-btn.buttonz-animation-left2right:hover i' => 'color: {{VALUE}}; transition: margin 0.5s linear, color 0.6s;'
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_background_hover_color',
                'label' => __( 'Background Color', 'buttonz' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '
                    {{WRAPPER}} .buttonz-btn.three_d_btn2:hover, 
                    {{WRAPPER}} .buttonz-btn:not(.three_d_btn):not(.three_d_btn2):not(.buttonz-animation-left2right):hover, 
                    {{WRAPPER}} .buttonz-btn.three_d_btn .elementor-button-content-wrapper:hover, 
                    {{WRAPPER}} .elementor-button.buttonz-animation-left2right::after',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => __( 'Padding', 'buttonz' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn:not(.three_d_btn)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .three_d_btn .elementor-button-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();


        /**
         * Style Button Icon
         */
        $this->start_controls_section(
            'style_three_d_btn', [
                'label' => __( 'Style 3D Button', 'buttonz' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'btn_style' => ['three_d_btn2'],
                ]
            ]
        );

        $this->add_control(
            'shadow_color1',
            [
                'label' => __( 'Underneath Fold Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .three_d_btn2::before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .three_d_btn' => 'box-shadow: 0 6px 0 {{shadow_color1.VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shadow_color2',
            [
                'label' => __( 'Shadow Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .three_d_btn' => 'box-shadow: 0 6px 0 {{shadow_color1.VALUE}}, 0 10px 15px {{VALUE}}',
                ],
                'condition' => [
                    'btn_style' => 'three_d_btn',
                ]
            ]
        );

        $this->end_controls_section();


        /**
         * Style Button Icon
         */
        $this->start_controls_section(
            'style_button_icon', [
                'label' => __( 'Button Icon', 'buttonz' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'buttonz' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_box_size',
            [
                'label' => __( 'Icon Box Size', 'buttonz' ),
                'description' => __( 'The icon box size is square. Will apply the same size on Height and Width.', 'buttonz' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn i' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_margin',
            [
                'label' => __( 'Margin', 'buttonz' ),
                'description' => __( 'Margin around the icon. You can use margin values to position the icon along with the text correctly.', 'buttonz' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label' => __( 'Border Radius', 'buttonz' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color',
            [
                'label' => __( 'Background Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn i' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Border
         */
        $this->start_controls_section(
            'style_border_sec', [
                'label' => __( 'Border', 'buttonz' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .buttonz-btn',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'buttonz' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .buttonz-btn.three_d_btn .elementor-button-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'is_btm_line',
            [
                'label' => __( 'Bottom Line', 'buttonz' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'buttonz' ),
                'label_off' => __( 'No', 'buttonz' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'btn_style' => 'line',
                ]
            ]
        );

        $this->start_controls_tabs( 'tabs_border_style' );

        $this->start_controls_tab(
            'tab_border_normal',
            [
                'label' => __( 'Normal', 'buttonz' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .buttonz-btn',
            ]
        );

        $this->add_control(
            'button_btm_line_color',
            [
                'label' => __( 'Bottom Line Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn.buttonz-btn-line::before' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'btn_style' => 'line',
                    'is_btm_line' => 'yes',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_border_hover',
            [
                'label' => __( 'Hover', 'buttonz' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} .buttonz-btn:hover',
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __( 'Border Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn:hover, {{WRAPPER}} .buttonz-btn:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_btm_line_color',
            [
                'label' => __( 'Bottom Line Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buttonz-btn.buttonz-btn-line::after' => 'background-color: {{VALUE}} !important; border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'btn_style' => 'line',
                    'is_btm_line' => 'yes',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Render icon widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('button', 'class', 'buttonz-btn');

        // Icon Hover Effect
        if ( !empty($settings['icon_hover_animation']) ) {
            $this->add_render_attribute( 'button', 'class', $settings['icon_hover_animation'] );
        }

        if ( !empty($settings['btn_style'] && $settings['btn_style'] == 'normal' ) ) {
            $this->add_render_attribute( 'button', 'class', 'buttonz-btn-normal' );
        }

        if ( !empty($settings['btn_style']) && $settings['btn_style'] == 'line' && $settings['is_btm_line'] == 'yes' ) {
            $this->add_render_attribute('button', 'class', 'buttonz-btn-line');
        }

        if ( !empty($settings['btn_style']) && $settings['btn_style'] == 'line' ) {
            $this->add_render_attribute('button', 'class', 'buttonz-btn-link');
        }

        if ( $settings['btn_style'] == 'default' || !isset($settings['btn_style']) ) {
            $this->add_render_attribute('button', 'class', 'elementor-button');
        }

        // 3D Button
        if ( $settings['btn_style'] == 'three_d_btn' ) {
            $this->add_render_attribute('button', 'class', "elementor-button three_d_btn treed-btn {$settings['action_state']}");
        }

        if ( $settings['btn_style'] == 'three_d_btn2' ) {
            $this->add_render_attribute('button', 'class', "elementor-button three_d_btn2 treed-btn {$settings['action_state']}");
        }

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_link_attributes( 'button', $settings['link'] );
            $this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
        }

        $this->add_render_attribute( 'button', 'role', 'button' );

        if ( ! empty( $settings['button_css_id'] ) ) {
            $this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
        }

        if ( ! empty( $settings['size'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
        }

        if ( !empty($settings['hover_animation']) ) {
            $this->add_render_attribute( 'button', 'class', $settings['hover_animation'] );
            if ( $settings['hover_animation'] == 'left2right' ) {
                $this->add_render_attribute( 'button', 'data-text', $settings['text'] );
            }
        }
        ?>

        <a <?php echo $this->get_render_attribute_string('button') ?>>
            <?php $this->render_text(); ?>
        </a>
        <?php
    }

    /**
     * Render
     */

    /**
     * Render button text.
     *
     * Render button widget text.
     *
     * @since 1.5.0
     * @access protected
     */
    protected function render_text() {
        $settings = $this->get_settings_for_display();

        $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
        $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

        if ( ! $is_new && empty( $settings['icon_align'] ) ) {
            // @todo: remove when deprecated
            // added as bc in 2.6
            //old default
            $settings['icon_align'] = $this->get_settings( 'icon_align' );
        }

        $icon_hover_animation = !empty($settings['icon_hover_animation']) ? ' hvr-icon' : '';

        $this->add_render_attribute( [
            'content-wrapper' => [
                'class' => 'elementor-button-content-wrapper',
            ],
            'icon-atts' => [
                'class' => [
                    'elementor-button-icon',
                    'elementor-align-icon-' . $settings['icon_align'],
                    $icon_hover_animation
                ],
            ],
            'text' => [
                'class' => 'elementor-button-text',
            ],
        ] );

        $this->add_inline_editing_attributes( 'text', 'none' );
        ?>

        <span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php
            if ( $settings['icon_type'] == 'icon' ) :
                if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) :
                    ?>
                    <span <?php echo $this->get_render_attribute_string( 'icon-atts' ); ?>>
                        <?php
                        if ( $is_new || $migrated ) :
                            Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                        else : ?>
                            <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                        <?php endif; ?>
                    </span>
                    <?php
                endif;
            elseif ( $settings['icon_type'] == 'image' ) :
                ?>
                <span <?php echo $this->get_render_attribute_string( 'icon-atts' ); ?>> <?php
                    echo wp_get_attachment_image($settings['image_icon']['id'], 'full'); ?>
                </span>
                <?php
            endif;
            ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>>
                <?php echo $settings['text']; ?>
            </span>
		</span>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Button() );