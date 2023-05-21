insert into historique( id_historique, avis_historique,favori_historique) VALUES('1','good','10');
insert into historique( id_historique, avis_historique,favori_historique) VALUES('2','bon','11');
insert into historique( id_historique, avis_historique,favori_historique) VALUES('4','bonn','15');

update `historique` set id_historique= '5', avis_historique='bien' where favori_historique = '10';

update `historique` set avis_historique= 'tres bon' where id_historique = '4';
