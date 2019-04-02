/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery("document").ready(function() {
    jQuery("form[name=post]").submit(function() {
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
    });
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
    
    /* Tags*/
    if (validation) {
        var tagsChecked = jQuery("#tagsdiv-post_tag ul.tagchecklist li");
        tagsChecked.each(function(index,element){
            var tag = jQuery(element).clone().children().remove().end().text().trim();
            if (validationTags.indexOf(tag) == -1) {
                var error = [];
                error["metabox"] = "#tagsdiv-post_tag";
                error["message"] = tag + ": " +validationLiterals.TagNotExist;
                errors.push(error);
            }
        });
    }
    /*END Tags*/
    
    /* Secondary Channels*/
    if (validation) {
        var secchChecked = jQuery("#tagsdiv-second_channel ul.tagchecklist li");
        secchChecked.each(function(index,element){
            var secch = jQuery(element).clone().children().remove().end().text().trim();
            if (validationSecch.indexOf(secch) == -1) {
                var error = [];
                error["metabox"] = "#tagsdiv-second_channel";
                error["message"] = secch + ": " +validationLiterals.SecchNotExist;
                errors.push(error);
            }
        });
    }
    /*END Secondary Channels*/
    
    return errors;
}