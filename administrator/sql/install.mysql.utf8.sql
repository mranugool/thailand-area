CREATE TABLE IF NOT EXISTS `#__thailand_provinces` (
`id` 							INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`asset_id` 						INT(11) UNSIGNED NOT NULL DEFAULT '0',
`provinces_code` 				VARCHAR(10)  NOT NULL ,
`provinces_name_th` 			VARCHAR(150)  NOT NULL ,
`provinces_name_en` 			VARCHAR(150)  NOT NULL ,
`provinces_geo_id` 				VARCHAR(4)  NOT NULL ,
`provinces_postcode_prefix` 	VARCHAR(4)  NOT NULL ,
`provinces_phone_area_code` 	VARCHAR(4)  NOT NULL ,
`provinces_zone` 				INT(11)  NOT NULL ,
`provinces_logo` 				VARCHAR(255)  NOT NULL ,
`note` 							TEXT NOT NULL ,
`ordering` 						INT(11)  NOT NULL ,
`state` 						TINYINT(1)  NOT NULL DEFAULT 1,
`checked_out` 					INT(11)  NOT NULL ,
`checked_out_time` 				DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
`created_by` 					INT(11)  NOT NULL ,
`modified_by` 					INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__thailand_districts` (
`id` 					INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`asset_id` 				INT(11) UNSIGNED NOT NULL DEFAULT '0',
`districts_code` 		VARCHAR(10)  NOT NULL ,
`districts_name_th` 	VARCHAR(150)  NOT NULL ,
`districts_name_en` 	VARCHAR(150)  NOT NULL ,
`districts_geo_id` 		VARCHAR(4)  NOT NULL ,
`districts_postcode` 	VARCHAR(10)  NOT NULL ,
`province_id` 			INT(11)  NOT NULL ,
`note` 					TEXT NOT NULL ,
`ordering` 				INT(11)  NOT NULL ,
`state` 				TINYINT(1)  NOT NULL DEFAULT 1,
`checked_out` 			INT(11)  NOT NULL ,
`checked_out_time` 		DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
`created_by` 			INT(11)  NOT NULL ,
`modified_by` 			INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `#__thailand_subdistricts` (
`id` 					INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`asset_id` 				INT(11) UNSIGNED NOT NULL DEFAULT '0',
`subdistrict_code` 		VARCHAR(10)  NOT NULL ,
`subdistrict_name_th` 	VARCHAR(150)  NOT NULL ,
`subdistrict_name_en` 	VARCHAR(150)  NOT NULL ,
`subdistrict_geo_id` 	VARCHAR(4)  NOT NULL ,
`subdistrict_postcode` 	VARCHAR(10)  NOT NULL ,
`province_id` 			INT(11)  NOT NULL ,
`district_id` 			INT(11)  NOT NULL ,
`note` 					TEXT NOT NULL ,
`ordering` 				INT(11)  NOT NULL ,
`state` 				TINYINT(1)  NOT NULL DEFAULT 1,
`checked_out` 			INT(11)  NOT NULL ,
`checked_out_time` 		DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
`created_by` 			INT(11)  NOT NULL ,
`modified_by` 			INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `#__thailand_changelogs` (
`id` 					INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`asset_id` 				INT(11) UNSIGNED NOT NULL DEFAULT '0',
`changelog_version` 	VARCHAR(10)  NOT NULL ,
`changelogs_date` 		DATETIME NOT NULL ,
`changelogs_detail` 	TEXT NOT NULL ,
`changelogs_tag` 		TEXT NOT NULL ,
`ordering` 				INT(11)  NOT NULL ,
`state` 				TINYINT(1)  NOT NULL DEFAULT 1,
`checked_out` 			INT(11)  NOT NULL ,
`checked_out_time` 		DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
`created_by` 			INT(11)  NOT NULL ,
`modified_by` 			INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Changelog','com_thailandarea.changelog','{"special":{"dbtable":"#__thailand_changelogs","key":"id","type":"Changelog","prefix":"ThailandareaTable"}}', '{"formFile":"administrator\/components\/com_thailandarea\/models\/forms\/changelog.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"changelogs_detail"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_thailandarea.changelog')
) LIMIT 1;

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Subdistrict','com_thailandarea.subdistrict','{"special":{"dbtable":"#__thailand_subdistricts","key":"id","type":"Subdistrict","prefix":"ThailandareaTable"}}', '{"formFile":"administrator\/components\/com_thailandarea\/models\/forms\/subdistrict.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"note"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"province_id","targetTable":"#__thailand_provinces","targetColumn":"67308","displayColumn":"provinces_name_th"},{"sourceColumn":"district_id","targetTable":"#__thailand_districts","targetColumn":"67309","displayColumn":"districts_name_th"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_thailandarea.subdistrict')
) LIMIT 1;

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'District','com_thailandarea.district','{"special":{"dbtable":"#__thailand_districts","key":"id","type":"District","prefix":"ThailandareaTable"}}', '{"formFile":"administrator\/components\/com_thailandarea\/models\/forms\/district.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"note"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"province_id","targetTable":"#__thailand_provinces","targetColumn":"67308","displayColumn":"provinces_name_th"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_thailandarea.district')
) LIMIT 1;

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Province','com_thailandarea.province','{"special":{"dbtable":"#__thailand_provinces","key":"id","type":"Province","prefix":"ThailandareaTable"}}', '{"formFile":"administrator\/components\/com_thailandarea\/models\/forms\/province.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"note"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_thailandarea.province')
) LIMIT 1;