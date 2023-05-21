insert into user(id_compte, nom_compte,prenom_compte, pseudo_compte, mail_compte, date_compte,tel_compte, password_compte) VALUES('2','ding','lea','souhila','sachour@et.intechinfo.fr','2023-05-16','06.34.56.32','password');
insert into user(id_compte, nom_compte,prenom_compte, pseudo_compte, mail_compte, date_compte,tel_compte, password_compte) VALUES('3', 'celive','souhila','lea','pedra@et.intechinfo.fr','2023-05-17','06.65.87.09' ,'mot');
insert into user(id_compte, nom_compte,prenom_compte, pseudo_compte, mail_compte, date_compte,tel_compte, password_compte) VALUES('1','souhila','ding','celive','ding@et.intechinfo.fr','2023-05-18','06.35.12.95','motpass');
update `user` set nom_compte = 'yyy' where id_compte = '1';
update `user` set date_compte = '2023-05-12' where prenom_compte = 'lea'; update `user` set password_compte = 'motdepasse' where id_compte = '3';
