<?php

use BN\ContentPost\Helpers;

if (!defined('ABSPATH')){
    die;
}
return array(
    Helpers::NAMESPACE."_fields" => array(
        "default" => array(
            "title" => array(),
            "content" => array(),
            "excerpt" => array(),
            "featuredimage" => array(),
            "categories" => array(),
            "tags" => array(),
            "author" => array(),
            "slug" => array(),
        ),
        "extra" => array(
            "pretitle" => array(
                "id" => "pretitle",
                "label" => __("Ante Titulo",Helpers::LOCALE),
                "type" => "text",
                "validation" => array(
                    "width" => 40,
                    "pattern" => "[a-zA-Z0-9]+"
                ),
                "readonly" => FALSE,
                "required" => TRUE,
                "enabled" => TRUE,
                "metabox" => array(
                    "id" => "pretitle_mb",
                    "context" => "normal",
                    "label" => __("Ante Title",Helpers::LOCALE),
                ),
                "metakey" => "pretitle"
            ),
            "hometitle" => array(
                "id" => "hometitle",
                "label" => __("Titulo Portada",Helpers::LOCALE),
                "type" => "text",
                "validation" => array(
                    "width" => 5,
                    "pattern" => "[a-zA-Z0-9]+"
                ),
                "readonly" => FALSE,
                "required" => TRUE,
                "enabled" => TRUE,
                "metabox" => array(
                    "id" => "hometitle_mb",
                    "context" => "normal",
                    "label" => __("Titulo Portada",Helpers::LOCALE),
                ),
                "metakey" => "hometitle"
            ),
        ),
    ),
    Helpers::NAMESPACE."_validationliterals" => array(
        "NoTitle" => __("No Title specified", Helpers::LOCALE),
        "TitleTooLong" => __("Title too long.", Helpers::LOCALE),
        "TitleInvalidChars" => __("Title has Invalid Chars.", Helpers::LOCALE),
        "NoSubtitle" => __("No Subtitle specified", Helpers::LOCALE),
        "SubTitleTooLong" => __("Subtitle too long.", Helpers::LOCALE),
        "SubTitleInvalidChars" => __("Subtitle has Invalid Chars.", Helpers::LOCALE),
        "NoAuthor" => __("No Author specified", Helpers::LOCALE),
        "NoContent" => __("No Content specified", Helpers::LOCALE),
        "NoCategories" => __("Categories are not set", Helpers::LOCALE),
        "CategoriesTooMuch" => __("Only one Category can be set", Helpers::LOCALE),
        "NoTags" => __("Tags are not set", Helpers::LOCALE),
        "NoPermissionTags" => __('Your role does not have permission to add new tags. Plase choose an exisiting one'),
        "NoThumbnail" => __("Main Image is not set", Helpers::LOCALE),
        "TagNotExist" => __("is a Tag which not exist, your role cannot create new ones", Helpers::LOCALE),
        "SecchNotExist" => __("is a Secondary Channel which not exist, your role cannot create new ones", Helpers::LOCALE),
    )
);
