<?php
namespace Bigup\Contact_Form;

/**
 * Bigup Contact Form - Widget.
 *
 * This template defines the widget including:
 *  - settings form
 *  - front end html
 *  - saving settings
 *
 * @package bigup-contact-form
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 * @license GPL2+
 * @link https://jeffersonreal.uk
 * 
 */
use WP_Widget;

class Widget extends WP_Widget {

	// Store widget options.
	private $bigup_widget_options;


    /**
     * Construct the widget.
     */
    public function __construct() {
        $this->bigup_widget_options = array (
            'classname' => 'bigup_contact_form',
            'description' => 'An SMTP contact form.'
        );
		parent::__construct(
			'bigup_contact_form',	   /* Base ID */
			'Bigup Web: Contact Form', /* widget name as it appears in widget picker */
			$this->widget_options
		);
    }


    /**
     * output the contact form widget settings form.
     */
    public function form( $instance ) {

        $title = ! empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : false;
        $message = ! empty( $instance['message'] ) ? $instance['message'] : false;
        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Form Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'message' ); ?>">Message to Appear Above the Form:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'message' ); ?>" name="<?php echo $this->get_field_name( 'message' ); ?>" value="<?php echo esc_attr( $message ); ?>" />
        </p>

    <?php
    }


    /**
     * display the contact form widget on the front end.
     */
    public function widget( $args, $instance ) {

        //enqueue contact form and styles
        wp_enqueue_script('bigup_contact_form_public_js');
        wp_enqueue_style('bigup_contact_form_public_css');

        echo $args[ 'before_widget' ];
		//get the form markup built with the passed vars.
		$form = Form_Generator::get_form(
			array(
				'title' => apply_filters( 'widget_title', $instance[ 'title' ] ),
				'message' => $instance[ 'message' ],
			)
		);
		echo $form;
        echo $args[ 'after_widget' ];

    }


    /**
     * define the data saved by the contact form widget.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'message' ] = strip_tags( $new_instance[ 'message' ] );
        return $instance;
    }
} 
