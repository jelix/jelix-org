INSERT INTO %%PREFIX%%jacl2_subject (id_aclsbj, label_key) VALUES
('hfnu.admin.ban', 'havefnubb~acl2.admin.ban'),
('hfnu.admin.category', 'havefnubb~acl2.admin.category'),
('hfnu.admin.category.create', 'havefnubb~acl2.admin.category.create'),
('hfnu.admin.category.delete', 'havefnubb~acl2.admin.category.delete'),
('hfnu.admin.category.edit', 'havefnubb~acl2.admin.category.edit'),
('hfnu.admin.config', 'havefnubb~acl2.admin.config'),
('hfnu.admin.config.edit', 'havefnubb~acl2.admin.config.edit'),
('hfnu.admin.forum', 'havefnubb~acl2.admin.forum'),
('hfnu.admin.forum.create', 'havefnubb~acl2.admin.forum.create'),
('hfnu.admin.forum.delete', 'havefnubb~acl2.admin.forum.delete'),
('hfnu.admin.forum.edit', 'havefnubb~acl2.admin.forum.edit'),
('hfnu.admin.index', 'havefnubb~acl2.admin.index'),
('hfnu.admin.member', 'havefnubb~acl2.admin.member'),
('hfnu.admin.notify.delete', 'havefnubb~acl2.admin.notify.delete'),
('hfnu.admin.notify.list', 'havefnubb~acl2.admin.notify.list'),
('hfnu.admin.rank.create', 'havefnubb~acl2.admin.rank.create'),
('hfnu.admin.rank.delete', 'havefnubb~acl2.admin.rank.delete'),
('hfnu.admin.rank.edit', 'havefnubb~acl2.admin.rank.edit'),
('hfnu.admin.themes', 'havefnubb~acl2.admin.themes');

INSERT INTO %%PREFIX%%jacl2_rights (id_aclsbj, id_aclgrp, id_aclres) VALUES
('hfnu.admin.ban', 1, ''),
('hfnu.admin.ban', 3, ''),
('hfnu.admin.category', 1, ''),
('hfnu.admin.category', 3, ''),
('hfnu.admin.category.create', 1, ''),
('hfnu.admin.category.delete', 1, ''),
('hfnu.admin.category.edit', 1, ''),
('hfnu.admin.config', 1, ''),
('hfnu.admin.config', 3, ''),
('hfnu.admin.config.edit', 1, ''),
('hfnu.admin.forum', 1, ''),
('hfnu.admin.forum.create', 1, ''),
('hfnu.admin.forum.delete', 1, ''),
('hfnu.admin.forum.edit', 1, ''),
('hfnu.admin.index', 1, ''),
('hfnu.admin.index', 3, ''),
('hfnu.admin.member', 1, ''),
('hfnu.admin.member', 3, ''),
('hfnu.admin.notify.delete', 1, ''),
('hfnu.admin.notify.delete', 3, ''),
('hfnu.admin.notify.list', 1, ''),
('hfnu.admin.notify.list', 3, ''),
('hfnu.admin.rank.create', 1, ''),
('hfnu.admin.rank.create', 3, ''),
('hfnu.admin.rank.delete', 1, ''),
('hfnu.admin.rank.delete', 3, ''),
('hfnu.admin.rank.edit', 1, ''),
('hfnu.admin.rank.edit', 3, ''),
('hfnu.admin.themes', 1, '');
