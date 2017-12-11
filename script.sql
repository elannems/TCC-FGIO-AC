DROP TABLE IF EXISTS `wp_bp_notifications`,`wp_bp_notifications_meta`;

DELETE FROM `wp_bp_xprofile_fields`;
INSERT INTO `wp_bp_xprofile_fields` (`id`, `group_id`, `parent_id`, `type`, `name`, `description`, `is_required`, `is_default_option`, `field_order`, `option_order`, `order_by`, `can_delete`) VALUES
	(1, 1, 0, 'textbox', 'Nome de exibição', 'A informação deste campo será visível a todos os usuários, então solicitamos que não utilize seu nome verdadeiro para sua segurança.', 1, 0, 0, 0, '', 0),
	(2, 1, 0, 'datebox', 'Data de nascimento', '', 1, 0, 1, 0, '', 1);

DELETE FROM `wp_bp_xprofile_groups`;
INSERT INTO `wp_bp_xprofile_groups` (`id`, `name`, `description`, `group_order`, `can_delete`) VALUES
	(1, 'Sobre', '', 0, 0);

DELETE FROM `wp_bp_xprofile_meta`;
INSERT INTO `wp_bp_xprofile_meta` (`id`, `object_id`, `object_type`, `meta_key`, `meta_value`) VALUES
	(1, 1, 'field', 'do_autolink', 'off'),
	(2, 2, 'field', 'default_visibility', 'adminsonly'),
	(3, 2, 'field', 'allow_custom_visibility', 'disabled'),
	(4, 2, 'field', 'do_autolink', 'off'),
	(5, 2, 'field', 'date_format', 'd/m/Y'),
	(6, 2, 'field', 'date_format_custom', ''),
	(7, 2, 'field', 'range_type', 'relative'),
	(8, 2, 'field', 'range_absolute_start', '1957'),
	(9, 2, 'field', 'range_absolute_end', '2027'),
	(10, 2, 'field', 'range_relative_start', '-100'),
	(11, 2, 'field', 'range_relative_end', '-1');

DELETE FROM `wp_posts` WHERE post_type = 'bp-email' and post_name <> 'site-name-ative-sua-conta';
UPDATE `wp_posts` SET `post_content` = 'Olá,\r\n\r\nAcabamos de receber um solicitação de criação de conta para a página da {{{site.name}}}, com o seguinte nome de usuário: <strong>{{recipient.username}}</strong>.\r\n\r\nCaso você reconheça essa solicitação, complete o cadastro acessando o seguinte link para ativar a conta: <a href="{{{activate.url}}}">{{{activate.url}}}</a>\r\n\r\n<strong>Dúvidas? entre em contato:</strong>\r\n? Telefones: +55 48 3721-7380 /+55 48 3721 4715\r\n? E-mail: computacaonaescola@incod.ufsc.br\r\n\r\nObrigado por se registrar,\r\nEquipe Computação na Escola.\r\n-----------------------------------------\r\n<span style="font-size: 10px;">Para saber mais sobre a iniciativa acesse: <a href="{{{site.url}}}">{{{site.name}}}</a></span>\r\n<span style="font-size: 10px;">Computação na Escola é uma iniciativa do INCoD - Instituto Nacional de Convergência Digital / INE – Departamento de Informática e Estatística / UFSC - Universidade Federal de Santa Catarina, em parceria com o IFSC - Instituto Federal de Santa Catarina.</span>',`post_title` = '[{{{site.name}}}] Ative sua conta', `post_excerpt` = 'Obrigado por se registrar!\r\n\r\nPara completar a ativação de sua conta, visite o seguinte link: {{{activate.url}}}' WHERE post_name = 'site-name-ative-sua-conta';

UPDATE `wp_options` SET `option_value` = 'a:0:{}' WHERE `option_name`='_bbp_private_forums';
UPDATE `wp_options` SET `option_value` = 'a:0:{}' WHERE`option_name` = '_bbp_hidden_forums';
UPDATE `wp_options` SET `option_value` = '250' WHERE`option_name` = '_bbp_db_version';
UPDATE `wp_options` SET `option_value`='a:0:{}' WHERE `option_name` = 'bp-deactivated-components';
UPDATE `wp_options` SET `option_value` = 'Sobre' WHERE `option_name`='bp-xprofile-base-group-name';
UPDATE `wp_options` SET `option_value`='Nome de exibição' WHERE `option_name`='bp-xprofile-fullname-field-name';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='hide-loggedout-adminbar';
UPDATE `wp_options` SET `option_value`='0' WHERE `option_name`='bp-disable-avatar-uploads';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='bp-disable-cover-image-uploads';
UPDATE `wp_options` SET `option_value`='0' WHERE `option_name`='bp-disable-group-avatar-uploads';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='bp-disable-group-cover-image-uploads';
UPDATE `wp_options` SET `option_value`='0' WHERE `option_name`='bp-disable-account-deletion';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='bp-disable-blogforum-comments';
UPDATE `wp_options` SET `option_value`='legacy' WHERE `option_name`='_bp_theme_package_id';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='bp_restrict_group_creation';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='_bp_enable_akismet';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='_bp_enable_heartbeat_refresh';
UPDATE `wp_options` SET `option_value`='' WHERE `option_name`='_bp_force_buddybar';
UPDATE `wp_options` SET `option_value`='' WHERE `option_name`='_bp_retain_bp_default';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='_bp_ignore_deprecated_code';
UPDATE `wp_options` SET `option_value`='' WHERE `option_name`='widget_bp_core_login_widget';
UPDATE `wp_options` SET `option_value`='' WHERE `option_name`='widget_bp_core_members_widget';
UPDATE `wp_options` SET `option_value`='' WHERE `option_name`='widget_bp_core_whos_online_widget';
UPDATE `wp_options` SET `option_value`='' WHERE `option_name`='widget_bp_core_recently_active_widget';
UPDATE `wp_options` SET `option_value`='' WHERE `option_name`='widget_bp_groups_widget';
UPDATE `wp_options` SET `option_value`='' WHERE `option_name`='widget_bp_messages_sitewide_notices_widget';
UPDATE `wp_options` SET `option_value`='a:4:{s:8:"xprofile";s:1:"1";s:7:"friends";s:1:"1";s:6:"groups";s:1:"1";s:7:"members";s:1:"1";}' WHERE `option_name`='bp-active-components';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='bp_disable_blogforum_comments';
UPDATE `wp_options` SET `option_value`='10' WHERE `option_name`='_bbp_edit_lock';
UPDATE `wp_options` SET `option_value`='10' WHERE `option_name`='_bbp_throttle_time';
UPDATE `wp_options` SET `option_value`='0' WHERE `option_name`='_bbp_allow_anonymous';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='_bbp_allow_global_access';
UPDATE `wp_options` SET `option_value`='bbp_participant' WHERE `option_name`='_bbp_default_role';
UPDATE `wp_options` SET `option_value`='0' WHERE `option_name`='_bbp_allow_revisions';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='_bbp_enable_favorites';
UPDATE `wp_options` SET `option_value`='0' WHERE `option_name`='_bbp_enable_subscriptions';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='_bbp_allow_topic_tags';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='_bbp_allow_search';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='_bbp_use_wp_editor';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='_bbp_use_autoembed';
UPDATE `wp_options` SET `option_value`='2' WHERE `option_name`='_bbp_thread_replies_depth';
UPDATE `wp_options` SET `option_value`='0' WHERE `option_name`='_bbp_allow_threaded_replies';
UPDATE `wp_options` SET `option_value`='6' WHERE `option_name`='_bbp_topics_per_page';
UPDATE `wp_options` SET `option_value`='10' WHERE `option_name`='_bbp_replies_per_page';
UPDATE `wp_options` SET `option_value`='6' WHERE `option_name`='_bbp_topics_per_rss_page';
UPDATE `wp_options` SET `option_value`='10' WHERE `option_name`='_bbp_replies_per_rss_page';
UPDATE `wp_options` SET `option_value`='areas' WHERE `option_name`='_bbp_root_slug';
UPDATE `wp_options` SET `option_value`='1' WHERE `option_name`='_bbp_include_root';
UPDATE `wp_options` SET `option_value`='forums' WHERE `option_name`='_bbp_show_on_root';
UPDATE `wp_options` SET `option_value`='area' WHERE `option_name`='_bbp_forum_slug';
UPDATE `wp_options` SET `option_value`='topico' WHERE `option_name`='_bbp_topic_slug';
UPDATE `wp_options` SET `option_value`='tag-topico' WHERE `option_name`='_bbp_topic_tag_slug';
UPDATE `wp_options` SET `option_value`='ver-topico' WHERE `option_name`='_bbp_view_slug';
UPDATE `wp_options` SET `option_value`='comentario' WHERE `option_name`='_bbp_reply_slug';
UPDATE `wp_options` SET `option_value`='ac-pesquisa' WHERE `option_name`='_bbp_search_slug';
UPDATE `wp_options` SET `option_value`='usuarios-bbpress' WHERE `option_name`='_bbp_user_slug';
UPDATE `wp_options` SET `option_value`='topicos' WHERE `option_name`='_bbp_topic_archive_slug';
UPDATE `wp_options` SET `option_value`='comentarios' WHERE `option_name`='_bbp_reply_archive_slug';
UPDATE `wp_options` SET `option_value`='avaliados' WHERE `option_name`='_bbp_user_favs_slug';
UPDATE `wp_options` SET `option_value`='assinados' WHERE `option_name`='_bbp_user_subs_slug';
UPDATE `wp_options` SET `option_value`='0' WHERE `option_name`='_bbp_enable_group_forums';
UPDATE `wp_options` SET `option_value`='0' WHERE `option_name`='_bbp_group_forums_root_id';