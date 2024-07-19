<?php

    /**
     * Class ReduxFramework_rane_text
     */

// Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    if ( ! class_exists( 'ReduxFramework_rane_text' ) ) {
        class ReduxFramework_rane_text {

            /**
             * Field Constructor.
             * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
             *
             * @since ReduxFramework 1.0.1
             */
            function __construct( $field = array(), $value = '', $parent='' ) {
                $this->parent = $parent;
                $this->field  = $field;
                $this->value  = $value;
            }

            /**
             * Field Render Function.
             * Takes the vars and outputs the HTML for the field in the settings
             *
             * @since ReduxFramework 1.0.1
             */
            function render() {
                
				if ( ! empty( $this->field['rane_field_3'] ) && $this->field['rane_field_3'] === true ) {
                    $this->_render_combined_field_2();
                } else if ( ! empty( $this->field['rane_field_2'] ) && $this->field['rane_field_2'] === true ) {
                    $this->_render_combined_field();
                } else {
                    $this->_render_single_field();
                }
            }

            /**
             * This will render a combined User/rane_field_1 field
             *
             * @since ReduxFramework 3.0.9
             * @example
             *        <code>
             *        array(
             *        'id'          => 'smtp_account',
             *        'type'        => 'rane_field_1',
             *        'rane_field_2'    => true,
             *        'title'       => 'SMTP Account',
             *        'placeholder' => array('rane_field_2' => 'rane_field_2')
             *        )
             *        </code>
             */
			 
			private function _render_combined_field() {

                $defaults = array(
                    'rane_field_1'    => '',				
                    'rane_field_2'    => '',
                    'placeholder' => array(
                        'rane_field_1' => __( 'Field 1', 'redux-framework' ),
                        'rane_field_2' => __( 'Field 2', 'redux-framework' ),
                    )
                );

                $this->value = wp_parse_args( $this->value, $defaults );

                if ( ! empty( $this->field['placeholder'] ) ) {
                    if ( is_array( $this->field['placeholder'] ) ) {
                        if ( ! empty( $this->field['placeholder']['rane_field_1'] ) ) {
                            $this->value['placeholder']['rane_field_1'] = $this->field['placeholder']['rane_field_1'];
                        }
                        if ( ! empty( $this->field['placeholder']['rane_field_2'] ) ) {
                            $this->value['placeholder']['rane_field_2'] = $this->field['placeholder']['rane_field_2'];
                        }						
                    } else {
                        $this->value['placeholder']['rane_field_1'] = $this->field['placeholder'];
                    }
                }

			

                // rane_field_1 field
                echo '<input type="text" autocomplete="on" placeholder="' . $this->value['placeholder']['rane_field_1'] . '" id="' . $this->field['id'] . '[rane_field_1]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[rane_field_1]' . '" value="' . esc_attr( $this->value['rane_field_1'] ) . '" class="' . $this->field['class'] . '" />';


				
                // rane_field_2 field
                echo '<input type="text" autocomplete="on" placeholder="' . $this->value['placeholder']['rane_field_2'] . '" id="' . $this->field['id'] . '[rane_field_2]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[rane_field_2]' . '" value="' . esc_attr( $this->value['rane_field_2'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
								
				
				
            }
 
            private function _render_combined_field_2() {

                $defaults = array(
                    'rane_field_1'    => '',				
                    'rane_field_2'    => '',
					'rane_field_3'    => '',					
                    'placeholder' => array(
                        'rane_field_1' => __( 'Field 1', 'redux-framework' ),
                        'rane_field_2' => __( 'Field 2', 'redux-framework' ),
						'rane_field_3' => __( 'Field 3', 'redux-framework' ),
                    )
                );

                $this->value = wp_parse_args( $this->value, $defaults );

                if ( ! empty( $this->field['placeholder'] ) ) {
                    if ( is_array( $this->field['placeholder'] ) ) {
                        if ( ! empty( $this->field['placeholder']['rane_field_1'] ) ) {
                            $this->value['placeholder']['rane_field_1'] = $this->field['placeholder']['rane_field_1'];
                        }
                        if ( ! empty( $this->field['placeholder']['rane_field_2'] ) ) {
                            $this->value['placeholder']['rane_field_2'] = $this->field['placeholder']['rane_field_2'];
                        }
                        if ( ! empty( $this->field['placeholder']['rane_field_3'] ) ) {
                            $this->value['placeholder']['rane_field_3'] = $this->field['placeholder']['rane_field_3'];
                        }						
                    } else {
                        $this->value['placeholder']['rane_field_1'] = $this->field['placeholder'];
                    }
                }

			

                // rane_field_1 field
                echo '<input type="text" autocomplete="on" placeholder="' . $this->value['placeholder']['rane_field_1'] . '" id="' . $this->field['id'] . '[rane_field_1]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[rane_field_1]' . '" value="' . esc_attr( $this->value['rane_field_1'] ) . '" class="' . $this->field['class'] . '" />';


				
                // rane_field_2 field
                echo '<input type="text" autocomplete="on" placeholder="' . $this->value['placeholder']['rane_field_2'] . '" id="' . $this->field['id'] . '[rane_field_2]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[rane_field_2]' . '" value="' . esc_attr( $this->value['rane_field_2'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
				
								
                // rane_field_3 field
                echo '<input type="text" autocomplete="on" placeholder="' . $this->value['placeholder']['rane_field_3'] . '" id="' . $this->field['id'] . '[rane_field_3]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[rane_field_3]' . '" value="' . esc_attr( $this->value['rane_field_3'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
				
				
				
            }

            /**
             * This will render a single rane_field_1 field
             *
             * @since ReduxFramework 3.0.9
             * @example
             *        <code>
             *        array(
             *        'id'    => 'smtp_rane_field_1',
             *        'type'  => 'rane_field_1',
             *        'title' => 'SMTP rane_field_1'
             *        )
             *        </code>
             */
            private function _render_single_field() {
                echo '<input type="text" id="' . $this->field['id'] . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '" value="' . esc_attr( $this->value ) . '" class="' . $this->field['class'] . '" />';
            }
        }
    }