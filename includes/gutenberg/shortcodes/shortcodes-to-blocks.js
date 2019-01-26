// License: GPLv2+

var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
    TextControl = wp.components.TextControl,
    SelectControl = wp.components.SelectControl,
	InspectorControls = wp.editor.InspectorControls;

/*
 * Here's where we register the block in JavaScript.
 *
 * It's not yet possible to register a block entirely without JavaScript, but
 * that is something I'd love to see happen. This is a barebones example
 * of registering the block, and giving the basic ability to edit the block
 * attributes. (In this case, there's only one attribute, 'form_slug'.)
 */
registerBlockType( 'buddyforms/bf-embed-form', {
	title: 'Embed a BuddyForm',
	icon: 'welcome-widgets-menus',
	category: 'buddyforms',

	/*
	 * In most other blocks, you'd see an 'attributes' property being defined here.
	 * We've defined attributes in the PHP, that information is automatically sent
	 * to the block editor, so we don't need to redefine it here.
	 */

	edit: function( props ) {
        console.log(buddyforms_forms);



        var forms = [
            { value: 'no', label: 'Select a Form' },
        ];
        for (var key in buddyforms_forms) {
            console.log(key +' - '+buddyforms_forms[key]);
            forms.push({ value: key, label: buddyforms_forms[key] });
        }

        console.log(forms);

		return [
			/*
			 * The ServerSideRender element uses the REST API to automatically call
			 * php_block_render() in your PHP code whenever it needs to get an updated
			 * view of the block.
			 */
			el( ServerSideRender, {
				block: 'buddyforms/bf-embed-form',
				attributes: props.attributes,
			} ),
			/*
			 * InspectorControls lets you add controls to the Block sidebar. In this case,
			 * we're adding a TextControl, which lets us edit the 'form_slug' attribute (which
			 * we defined in the PHP). The onChange property is a little bit of magic to tell
			 * the block editor to update the value of our 'form_slug' property, and to re-render
			 * the block.
			 */

			el( InspectorControls, {},
                // el( TextControl, {
                //     label: 'Form Slug',
                //     value: props.attributes.form_slug,
                //     onChange: ( value ) => { props.setAttributes( { form_slug: value } ); },
                // } ),
                el( SelectControl, {
                    label: 'Free Entrance',
                    value: props.attributes.form_slug,
                    options: forms,
                    onChange: ( value ) => { props.setAttributes( { form_slug: value } ); },
                } ),
			)
		];
	},

	// We're going to be rendering in PHP, so save() can just return null.
	save: function() {
		return null;
	},
} );
