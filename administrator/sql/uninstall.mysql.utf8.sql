DROP TABLE IF EXISTS `#__thailand_provinces`;
DROP TABLE IF EXISTS `#__thailand_districts`;
DROP TABLE IF EXISTS `#__thailand_subdistricts`;
DROP TABLE IF EXISTS `#__thailand_changelogs`;

DELETE FROM `#__content_types` WHERE (type_alias LIKE 'com_thailandarea.%');