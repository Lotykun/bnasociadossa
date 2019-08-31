/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery("document").ready(function() {
    /*jQuery("form[name=post]").submit(function() {
        jQuery("div.notice").remove();
        jQuery(".error").removeClass("error");
        var errors = validate_post_data();
        var result;
        if (errors.length > 0) {
            errors.forEach(function(element){
                render_admin_notice("error",element.message);
                jQuery(element.metabox).addClass("error");
            });
            result = false;
        } else {
            result = true;
        }
        window.scrollTo(0,0);
        return result;
    });*/
    //wp.data.dispatch( 'core/notices' ).createErrorNotice( 'Please enter a date to continue.', { id: 'LOCK_NOTICE',isDismissible: true} ) ;
    const { getEditedPostAttribute } = wp.data.select( 'core/editor' );
    const title = getEditedPostAttribute( 'title' );
    let pageTemplate;
    wp.data.subscribe(() => {
	const newPageTemplate = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'title' );
	if ( pageTemplate !== newPageTemplate ) {
            console.log( 'Page template has changed!' );
            //pageTemplate = newPageTemplate;
	}
    });
    
    
    
    /*const { getEditedPostAttribute } = wp.data.select( 'core/editor' );
    const title = getEditedPostAttribute( 'title' );
    const content = getEditedPostAttribute( 'content' );*/
    /*wp.data.dispatch( 'core/notices' ).createErrorNotice( 'LOTY IS HERE');
    wp.data.dispatch( 'core/notices' ).createWarningNotice( 'LOTy IS HERE 2' );
    wp.data.dispatch( 'core/notices' ).createSuccessNotice( 'LOTy IS HERE 3' );*/
});

function render_admin_notice(type, message){
    var dismissible = (type !== "error") ? " is-dismissible" : "";
    var html = '\
                <div class="notice notice-'+ type + dismissible +'">\n\
                    <p>'+ type.toUpperCase() +': '+ message +'</p>\n\
                </div>';
    jQuery(html).insertBefore(jQuery("form[name=post]"));
}

function validate_post_data() {
    var errors = [];
    
    /* ROLES */
    var validation = false;
    validationUserRoles.forEach(function(userRole,index){
        if (validationRoles.indexOf(userRole) > -1) {
            validation = true;
        }
    });
    /*END ROLES */
    
    /* Categories*/
    var categoriesChecked = jQuery("#categorydiv input:checked").toArray();
    var exclude = "popular";
    categoriesChecked.forEach(function(element,index) {
        if (element.id.indexOf(exclude) !== -1) {
            categoriesChecked.splice(index, 1);
        }
    });
    var countCategories = categoriesChecked.length;
    if (countCategories === 0) {
        var element = [];
        element["metabox"] = "#categorydiv";
        element["message"] = validationLiterals.NoCategories;
        errors.push(element);
    }
    if (countCategories > 1) {
        var element = [];
        element["metabox"] = "#categorydiv";
        element["message"] = validationLiterals.CategoriesTooMuch;
        errors.push(element);
    }
    /*END Categories*/
    
    /* Status*/
    //if (validation) {
        var statusChecked = jQuery("#tagsdiv-second_channel ul.tagchecklist li");
        secchChecked.each(function(index,element){
            var secch = jQuery(element).clone().children().remove().end().text().trim();
            if (validationSecch.indexOf(secch) == -1) {
                var error = [];
                error["metabox"] = "#tagsdiv-second_channel";
                error["message"] = secch + ": " +validationLiterals.SecchNotExist;
                errors.push(error);
            }
        });
    //}
    /*END Status*/
    
    return errors;
}