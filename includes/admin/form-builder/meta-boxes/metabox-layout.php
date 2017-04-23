<?php


function buddyforms_metabox_form_designer(){
	buddyforms_layout_screen();
}

function buddyforms_load_form_layout(){
    global $buddyforms;

    $form_slug = $_POST['form_slug'];

    if( $form_slug == 'bf_global' ){
	    $options = get_option( 'buddyforms_layout_options' );
	    echo json_encode( $options['layout']);
	    die();
    }

	$json =  array();

	if( isset( $buddyforms[ $form_slug ]['layout'] ) ){
		$json = $buddyforms[ $form_slug ]['layout'];
    } else {
		$json['error'] = 'Please enter a name';
    }

	echo json_encode( $json );
    die();
}
add_action( 'wp_ajax_buddyforms_load_form_layout', 'buddyforms_load_form_layout' );

function buddyforms_layout_screen( $option_name = "buddyforms_options") {
    global $post, $buddyforms;

	$option_name = $option_name. '[layout]';

	$form_setup = array();

	$options = get_post_meta( get_the_ID(), '_buddyforms_options', true );



	// Labels

	$form_setup['Labels'][]        = new Element_HTML('<h4 style="margin-top: 30px; text-transform: uppercase;">Labels</h4>' );

	$labels_layout = isset( $options['layout']['labels_layout'] ) ? $options['layout']['labels_layout'] : 'inline';
	$form_setup['Labels'][]        = new Element_Radio( '<b>' . __( 'Use labels as placeholders?', 'buddyforms' ) . '</b>', $option_name . "[labels_layout]", array(
		'label'  => __( 'Show labels', 'buddyforms' ),
		'inline' => __( 'Use as placeholder', 'buddyforms' ),
	), array(
		'value'     => $labels_layout,
		'shortDesc' => '<b>Show labels</b>: display the labels above the text fields. <br><br><b>Use as placeholder</b>: hide labels and display as placeholder text inside text fields. '
	) );

	$label_font_size = isset( $options['layout']['label_font_size'] ) ? $options['layout']['label_font_size'] : '';
	$form_setup['Labels'][]        = new Element_Number('<b>' . __( 'Label Font Size', 'buddyforms' ) . '</b>', $option_name . "[label_font_size]", array(
		'value'     => $label_font_size,
		'shortDesc' => 'Just enter a number. Leave empty = auto'
	) );

	$label_font_color = isset( $options['layout']['label_font_color'] ) ? $options['layout']['label_font_color'] : 'auto';
	$form_setup['Labels'][]        = new Element_Color('<b>' . __( 'Label Font Color', 'buddyforms' ) . '</b>', $option_name . "[label_font_color]", array(
		'value'     => $label_font_color,
		'shortDesc' => 'Default is auto'
	) );

	$label_font_style = isset( $options['layout']['label_font_style'] ) ? $options['layout']['label_font_style'] : 'bold';
	$form_setup['Labels'][]        = new Element_Radio( '<b>' . __( 'Label Font Style', 'buddyforms' ) . '</b>', $option_name . "[label_font_style]", array(
		'normal' => __( 'Normal', 'buddyforms' ),
		'italic'  => '<i>' . __( 'Italic', 'buddyforms' ) . '</i>',
		'bold'  => '<b>' . __( 'Bold', 'buddyforms' ) . '</b>',
		'bolditalic'  => '<b><i>' . __( 'Bold Italic', 'buddyforms' ) . '</i></b>',
	), array(
		'value'     => $label_font_style,
		'shortDesc' => ''
	) );




	// Text Fields

	$form_setup['Text Fields'][]        = new Element_HTML('<h4 style="margin-top: 30px; text-transform: uppercase;">Text Fields</h4>' );

	$field_padding = isset( $options['layout']['field_padding'] ) ? $options['layout']['field_padding'] : '15';
	$form_setup['Text Fields'][]        = new Element_Number('<b>' . __( 'Field Padding', 'buddyforms' ) . '</b>', $option_name . "[field_padding]", array(
		'value'     => $field_padding,
		'shortDesc' => 'Just enter a number. Default is 15 (px)'
	) );

	$field_background_color = isset( $options['layout']['field_background_color'] ) ? $options['layout']['field_background_color'] : 'auto';
	$form_setup['Text Fields'][]        = new Element_Color('<b>' . __( 'Field Background Color ', 'buddyforms' ) . '</b>', $option_name . "[field_background_color]", array(
		'value'     => $field_background_color,
		'shortDesc' => 'Default is auto'
	) );

	$field_border_color = isset( $options['layout']['field_border_color'] ) ? $options['layout']['field_border_color'] : 'auto';
	$form_setup['Text Fields'][]        = new Element_Color('<b>' . __( 'Field Border Color', 'buddyforms' ) . '</b>', $option_name . "[field_border_color]", array(
		'value'     => $field_border_color,
		'shortDesc' => 'Default is auto'
	) );

	$field_border_width = isset( $options['layout']['field_border_width'] ) ? $options['layout']['field_border_width'] : '';
	$form_setup['Text Fields'][]        = new Element_Number('<b>' . __( 'Field Border Width', 'buddyforms' ) . '</b>', $option_name . "[field_border_width]", array(
		'value'     => $field_border_width,
		'shortDesc' => 'in px, just enter a number. Leave empty = auto'
	) );

 	$field_font_size = isset( $options['layout']['field_font_size'] ) ? $options['layout']['field_font_size'] : '';
	$form_setup['Text Fields'][]        = new Element_Number('<b>' . __( 'Field Font Size', 'buddyforms' ) . '</b>', $option_name . "[field_font_size]", array(
		'value'     => $field_font_size,
		'shortDesc' => 'in px, just enter a number. Leave empty = auto'
	) );

	$field_font_color = isset( $options['layout']['field_font_color'] ) ? $options['layout']['field_font_color'] : 'auto';
	$form_setup['Text Fields'][]        = new Element_Color('<b>' . __( 'Field Font Color', 'buddyforms' ) . '</b>', $option_name . "[field_font_color]", array(
		'value'     => $field_font_color,
		'shortDesc' => 'Default is auto'
	) );

	$field_placeholder_font_color = isset( $options['layout']['field_placeholder_font_color'] ) ? $options['layout']['field_placeholder_font_color'] : 'auto';
	$form_setup['Text Fields'][]        = new Element_Color('<b>' . __( 'Field Placeholder Font Color', 'buddyforms' ) . '</b>', $option_name . "[field_placeholder_font_color]", array(
		'value'     => $field_placeholder_font_color,
		'shortDesc' => 'Default is auto'
	) );

	$field_active_background_color = isset( $options['layout']['field_active_background_color'] ) ? $options['layout']['field_active_background_color'] : 'auto';
	$form_setup['Text Fields'][]        = new Element_Color('<b>' . __( 'Field Active Background Color', 'buddyforms' ) . '</b>', $option_name . "[field_active_background_color]", array(
		'value'     => $field_active_background_color,
		'shortDesc' => 'Default is auto'
	) );

	$field_active_border_color = isset( $options['layout']['field_active_border_color'] ) ? $options['layout']['field_active_border_color'] : 'auto';
	$form_setup['Text Fields'][]        = new Element_Color('<b>' . __( 'Field Active Border Color', 'buddyforms' ) . '</b>', $option_name . "[field_active_border_color]", array(
		'value'     => $field_active_border_color,
		'shortDesc' => 'Default is auto'
	) );

	$field_active_font_color = isset( $options['layout']['field_active_font_color'] ) ? $options['layout']['field_active_font_color'] : 'auto';
	$form_setup['Text Fields'][]        = new Element_Color('<b>' . __( 'Field Active Font Color', 'buddyforms' ) . '</b>', $option_name . "[field_active_font_color]", array(
		'value'     => $field_active_font_color,
		'shortDesc' => 'Default is auto'
	) );






	// Buttons

	$form_setup['Buttons'][]        = new Element_HTML('<h4 style="margin-top: 30px; text-transform: uppercase;">Buttons</h4>' );

	$submit_text = isset( $options['layout']['submit_text'] ) ? $options['layout']['submit_text'] : 'Submit';
	$form_setup['Buttons'][]        = new Element_Textbox('<b>' . __( 'Button Submit Text', 'buddyforms' ) . '</b>', $option_name . "[submit_text]", array(
		'value'     => $submit_text,
		'shortDesc' => 'Default text for the submit button. Default is "Submit". <br>HTML is allowed, so you can embed icons.'
	) );

	$button_width = isset( $options['layout']['button_width'] ) ? $options['layout']['button_width'] : 'blockmobile';
	$form_setup['Buttons'][]        = new Element_Radio( '<b>' . __( 'Button Width', 'buddyforms' ) . '</b>', $option_name . "[button_width]", array(
		'blockmobile'  => __( 'Full width button on mobile only', 'buddyforms' ),
		'block' => __( 'Always full width button', 'buddyforms' ),
		'inline' => __( 'Always normal width button', 'buddyforms' ),
	), array(
		'value'     => $button_width,
		'shortDesc' => 'We recommend full width buttons on mobile, looks neater.'
	) );

	$button_size = isset( $options['layout']['button_size'] ) ? $options['layout']['button_size'] : 'auto';
	$form_setup['Buttons'][]        = new Element_Radio( '<b>' . __( 'Button Size', 'buddyforms' ) . '</b>', $option_name . "[button_size]", array(
		'auto'  => __( 'Auto', 'buddyforms' ),
		'large' => __( 'Large', 'buddyforms' ),
		'xlarge' => __( 'Extra Large', 'buddyforms' ),
	), array(
		'value'     => $button_size,
		'shortDesc' => ''
	) );

	$button_class = isset( $options['layout']['button_class'] ) ? $options['layout']['button_class'] : '';
	$form_setup['Buttons'][]        = new Element_Textbox('<b>' . __( 'Add custom CSS classes to button', 'buddyforms' ) . '</b>', $option_name . "[button_class]", array(
		'value'     => $button_class,
		'shortDesc' => 'for example: "btn btn-primary" '
	) );

	$button_border_radius = isset( $options['layout']['button_border_radius'] ) ? $options['layout']['button_border_radius'] : '';
	$form_setup['Buttons'][]        = new Element_Number('<b>' . __( 'Button Corner Radius', 'buddyforms' ) . '</b>', $option_name . "[button_border_radius]", array(
		'value'     => $button_border_radius,
		'shortDesc' => 'Rounded corners. Just enter a number. Leave empty = auto'
	) );

	$button_background_color = isset( $options['layout']['button_background_color'] ) ? $options['layout']['button_background_color'] : 'auto';
	$form_setup['Buttons'][]        = new Element_Color('<b>' . __( 'Button Background Color', 'buddyforms' ) . '</b>', $option_name . "[button_background_color]", array(
		'value'     => $button_background_color,
		'shortDesc' => 'Default is auto'
	) );

	$button_font_color = isset( $options['layout']['button_font_color'] ) ? $options['layout']['button_font_color'] : 'auto';
	$form_setup['Buttons'][]        = new Element_Color('<b>' . __( 'Button Font Color', 'buddyforms' ) . '</b>', $option_name . "[button_font_color]", array(
		'value'     => $button_font_color,
		'shortDesc' => 'Default is auto'
	) );

	$button_border_width = isset( $options['layout']['button_border_width'] ) ? $options['layout']['button_border_width'] : '';
	$form_setup['Buttons'][]        = new Element_Number('<b>' . __( 'Button Border Width', 'buddyforms' ) . '</b>', $option_name . "[button_border_width]", array(
		'value'     => $button_border_width,
		'shortDesc' => 'Border width in pixels. Just enter a number. Leave empty for auto setting.'
	) );

	$button_border_color = isset( $options['layout']['button_border_color'] ) ? $options['layout']['button_border_color'] : 'auto';
	$form_setup['Buttons'][]        = new Element_Color('<b>' . __( 'Button Border Color', 'buddyforms' ) . '</b>', $option_name . "[button_border_color]", array(
		'value'     => $button_border_color,
		'shortDesc' => 'Default is auto'
	) );

	$button_background_color_hover = isset( $options['layout']['button_background_color_hover'] ) ? $options['layout']['button_background_color_hover'] : 'auto';
	$form_setup['Buttons'][]        = new Element_Color('<b>' . __( 'Button Background Color Hover', 'buddyforms' ) . '</b>', $option_name . "[button_background_color_hover]", array(
		'value'     => $button_background_color_hover,
		'shortDesc' => 'Default is auto'
	) );

	$button_font_color_hover = isset( $options['layout']['button_font_color_hover'] ) ? $options['layout']['button_font_color_hover'] : 'auto';
	$form_setup['Buttons'][]        = new Element_Color('<b>' . __( 'Button Font Color Hover', 'buddyforms' ) . '</b>', $option_name . "[button_font_color_hover]", array(
		'value'     => $button_font_color_hover,
		'shortDesc' => 'Default is auto'
	) );

	$button_border_color_hover = isset( $options['layout']['button_border_color_hover'] ) ? $options['layout']['button_border_color_hover'] : 'auto';
	$form_setup['Buttons'][]        = new Element_Color('<b>' . __( 'Button Border Color Hover', 'buddyforms' ) . '</b>', $option_name . "[button_border_color_hover]", array(
		'value'     => $button_border_color_hover,
		'shortDesc' => 'Default is auto'
	) );





	// Other Elements

	$form_setup['Other Elements'][]        = new Element_HTML('<h4 style="margin-top: 30px; text-transform: uppercase;">Other Elements</h4>' );

	$radio_button_alignment = isset( $options['layout']['radio_button_alignment'] ) ? $options['layout']['radio_button_alignment'] : 'inline';
	$form_setup['Other Elements'][]        = new Element_Radio( '<b>' . __( 'Radio Button Alignment', 'buddyforms' ) . '</b>', $option_name . "[radio_button_alignment]", array(
		'inline-block'  => __( 'Inline', 'buddyforms' ),
		'block' => __( 'List', 'buddyforms' ),
	), array(
		'value'     => $radio_button_alignment,
		'shortDesc' => 'Want to display your radio buttons in a row (inline) or in a vertical list?'
	) );

	$checkbox_alignment = isset( $options['layout']['checkbox_alignment'] ) ? $options['layout']['checkbox_alignment'] : 'inline';
	$form_setup['Other Elements'][]        = new Element_Radio( '<b>' . __( 'Checkbox Option Alignment', 'buddyforms' ) . '</b>', $option_name . "[checkbox_alignment]", array(
		'inline-block'  => __( 'Inline', 'buddyforms' ),
		'block' => __( 'List', 'buddyforms' ),
	), array(
		'value'     => $checkbox_alignment,
		'shortDesc' => 'Want to display your checkbox options in a row (inline) or in a vertical list?'
	) );




	// Custom CSS

	$custom_css = isset( $options['layout']['custom_css'] ) ? $options['layout']['custom_css'] : '';
	$form_setup['Custom CSS'][] = new Element_Textarea( '<b>' . __( 'Custom CSS', 'buddyforms' ) . '</b>', $option_name . "[custom_css]", array(
		'rows'  => 3,
		'style' => "width:100%",
		'class' => 'display_message display_form',
		'value' => $custom_css,
		'id'    => 'custom_css',
		'shortDesc' => __( 'Add custom styles to the form', 'buddyforms' )
	) );


    if( get_post_type() == 'buddyforms' ) { ?>
    <script>
        jQuery(document).ready(function (jQuery) {
            jQuery(document).on('click', '#bf_load_layout_options', function () {

                jQuery('.layout-spinner').addClass(' is-active');
                jQuery('.layout-spinner').show();
                var form_slug = jQuery('#bf_form_layout_select').val();
                jQuery.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: ajaxurl,
                    data: {"action": "buddyforms_load_form_layout",
                        "form_slug": form_slug,
                    },
                    success: function (data) {
                        jQuery.each(data, function (i, val) {
                            jQuery('.layout-spinner').hide();
                            jQuery("input[name='<?php echo $option_name ?>[" + i + "]']").val(val);
                        });
                    }
                });
                return false;
            });
        });
    </script>
	<?php
	echo '<p>' . __( 'Copy layout settings from') . '</p>';

	echo '<p><select id="bf_form_layout_select" style="width: 50% !important; margin-right: 10px">';
	echo '<option value="bf_global">Reset to Global Layout Settings</option>';
	if( isset($buddyforms) ){
		foreach ( $buddyforms as $form_slug => $form ){
			echo '<option value="' . $form_slug . '">' . $form["name"] . '</option>';
		}
	}
	echo '</select>';
	echo  '<a id="bf_load_layout_options" class="button" href="#"><span style="display: none;" class="layout-spinner  spinner"></span> Load Layout Settings</a></p>';
    };
    ?>

    <div class="tabs tabbable tabs-left">
        <ul class="nav nav-tabs nav-pills">
			<?php
			$i = 0;
			foreach ( $form_setup as $tab => $fields ) {
				$tab_slug = sanitize_title( $tab ); ?>
            <li class="<?php echo $i == 0 ? 'active' : '' ?><?php echo $tab_slug ?>_nav"><a
                        href="#<?php echo $tab_slug; ?>"
                        data-toggle="tab"><?php echo $tab; ?></a>
                </li><?php
				$i ++;
			}
			// Allow other plugins to add new sections
			do_action( 'buddyforms_form_designer_nav_li_last' );
			?>

        </ul>
        <div class="tab-content">
			<?php
			$i = 0;
			foreach ( $form_setup as $tab => $fields ) {
				$tab_slug = sanitize_title( $tab );
				?>
                <div class="tab-pane fade in <?php echo $i == 0 ? 'active' : '' ?>"
                     id="<?php echo $tab_slug; ?>">
                    <div class="buddyforms_accordion_general">
						<?php
						// get all the html elements and add them above the settings
						foreach ( $fields as $field_key => $field ) {
							$type = $field->getAttribute( 'type' );
							if ( $type == 'html' ) {
								$field->render();
							}
						} ?>
                        <table class="wp-list-table widefat posts striped fixed">
                            <tbody>
							<?php foreach ( $fields as $field_key => $field ) {

								$type     = $field->getAttribute( 'type' );
								$class    = $field->getAttribute( 'class' );
								$disabled = $field->getAttribute( 'disabled' );
								$classes  = empty( $class ) ? '' : $class . ' ';
								$classes .= empty( $disabled ) ? '' : 'bf-' . $disabled . ' ';

								// If the form element is not html create it as table row
								if ( $type != 'html' ) {
									?>
                                    <tr class="<?php echo $classes ?>">
                                        <th scope="row">
                                            <label for="form_title"><?php echo $field->getLabel() ?></label>
                                        </th>
                                        <td>
											<?php echo $field->render() ?>
                                            <p class="description"><?php echo $field->getShortDesc() ?></p>
                                        </td>
                                    </tr>
								<?php }
							} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
				<?php
				$i ++;
			}
			// Allow other plugins to hook there content for there nav into the tab content
			do_action( 'buddyforms_form_designer_tab_pane_last' );
			?>
        </div>  <!-- close .tab-content -->
    </div> <!--	close .tabs -->

	<?php
}
