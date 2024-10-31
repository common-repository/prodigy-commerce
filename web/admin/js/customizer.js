jQuery( function( $ ) {
    var code = 'too_short';
    console.log(wp.customize.control( 'prodigy_general_images_ratio' ));
    wp.customize.control( 'prodigy_general_images_ratio' ).notifications.add(
        code,
        new wp.customize.Notification( code, {
            message: 'Site title too short.'
        } )
    );
});

