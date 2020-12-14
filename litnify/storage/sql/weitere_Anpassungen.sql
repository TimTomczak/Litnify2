INSERT INTO lit2_inventarliste_medium (medium_id, inventarliste_id)
SELECT medium_id,id as 'inventarliste_id' FROM lit2_inventarliste;

UPDATE `lit2_inventarliste` SET `ausleihbar` = `isb` WHERE `isb` = 1;
