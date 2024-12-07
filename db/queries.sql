SELECT * FROM tabla Where condition;

---------------------------------------------------------------------------
--obtener el album con sus canciones.
SELECT 
    a.titulo_album AS "Álbum",
    c.nombre_cancion AS "Canción"
FROM 
    albumes a
INNER JOIN 
    canciones c
ON 
    a.id_album = c.id_album
ORDER BY 
    a.titulo_album, c.nombre_cancion;
----------------------------------------------------------------------------
SELECT 
    a.titulo_album AS "Álbum",
    c.nombre_cancion AS "Canción"
FROM 
    albumes a
INNER JOIN 
    canciones c
ON 
    a.id_album = c.id_album
WHERE 
    a.id_album = :id_album
ORDER BY 
    c.nombre_cancion;


    SELECT 
    a.titulo_album AS "Álbum",
    ar.pseudonimo_artista AS "Artista",
    c.nombre_cancion AS "Canción"
FROM 
    albumes a
INNER JOIN 
    artistas ar ON a.id_artista = ar.id_artista
INNER JOIN 
    canciones c ON a.id_album = c.id_album
WHERE 
    a.id_album = 3
ORDER BY 
    c.nombre_cancion;

