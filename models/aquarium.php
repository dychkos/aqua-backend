<?php

class Aquarium
{
    public static function getAuqariumList(): array
    {
        return (new DB())->getArrayFromQuery(
          'SELECT * from aquariums ORDER BY id'
        );
    }

    public static function editAquarium($aqua)
    {
        return (new DB())->runQuery('
            UPDATE aquariums SET type = '. $aqua['type'] .' ,
            capacity = ' . $aqua['capacity'] .
            'WHERE id = ' . $aqua['id']
        );
    }

    public static function addAquarium($aqua)
    {
        return (new DB())->runQuery('
            INSERT INTO aquariums (type, capacity) values ('
            . $aqua['type'] . ','
            . $aqua['capacity'] . ')'
        );
    }

    public static function removeAquarium($aqua)
    {
        return (new DB())->runQuery('
           DELETE FROM aquariums WHERE id = ' . $aqua['id']
        );
    }

    public static function getFish($aquaId)
    {
        return (new DB())->runQuery('
           SELECT * from fish WHERE aqua_id = ' . $aquaId
        );
    }
}