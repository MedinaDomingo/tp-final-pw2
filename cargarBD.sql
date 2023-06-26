INSERT INTO `pregunta` (`id_pregunta`, `descripción`, `id_categoria`, `id_estado`, `opcion_a`, `opcion_b`, `opcion_c`,
                        `opcion_d`, `opcion_correcta`, `dificultad`)
VALUES (2, '¿Cuál es el número atómico del oxígeno?', 10, 2, '6', '8', '10', '12', '8', '1'),
       (3, '¿Cuál es la fórmula química del agua?', 10, 2, 'H2O', 'CO2', 'NaCl', 'C6H12O6', 'H2O', '1'),
       (4, '¿Cuál es la ley de gravitación universal?', 10, 2, 'Ley de Ohm', 'Ley de Newton', 'Ley de Coulomb',
        'Ley de Boyle-Mariotte', 'Ley de Boyle-Mariotte', '3'),
       (5, '¿En qué deporte se utiliza la expresión \"strike\"?', 6, 2, 'Fútbol americano', 'Golf', 'Béisbol', 'Tenis',
        'Béisbol', '2'),
       (6, '¿Cuál es el deporte más popular a nivel mundial?', 6, 2, 'Fútbol', 'Baloncesto', 'Críquet', 'Tenis',
        'Fútbol', '1'),
       (7, '¿Cuál es el río más largo del mundo?', 4, 2, 'Amazonas', 'Nilo', 'Misisipi', 'Yangtsé', 'Nilo', '2'),
       (8, '¿Cuál es la capital de Australia?', 4, 2, 'Sídney', 'Melbourne', 'Brisbane', 'Canberra', 'Canberra', '3'),
       (9, '¿Cuál es el país más grande del mundo en términos ', 4, 2, 'Rusia', 'China', 'Estados Unidos', 'Canadá',
        'Rusia', '2'),
       (10, '¿Cuál es el deporte más popular en Estados Unidos?', 6, 2, 'Fútbol', 'Baloncesto', 'Béisbol', 'Hockey',
        'Béisbol', '1');

INSERT INTO `estado` (`id_estado`, `descripción`)
VALUES (1, 'en_revision'),
       (2, 'aprobada'),
       (3, 'pendiente_aprobacion');

INSERT INTO `rol` (`id_rol`, `descripción`)
VALUES (1, 'cliente'),
       (2, 'editor'),
       (3, 'admin');

INSERT INTO `usuario` (`id_usuario`, `nombre_u`, `cod_verif`, `email`, `nombre`, `sexo`, `puntaje`, `fecha_nac`,
                       `id_rol`, `id_resultado`, `id_partida`, `id_nivel`, `id_trampa`, `is_active`, `activation_hash`,
                       `apellido`, `foto_perfil`, `pais`, `provincia`, `password`, `qr`, `rol`)
VALUES (5, 'Alf', 0, 'alfe@gmail.com', 'Gordon', 'Masculino', 54, '2023-06-01', 1, NULL, NULL, 2, NULL, b'1', '09050',
        'Alf', '/public/profilePictures/693633d4e21e801929d731c1608fd5ef (1).png', 'Argentina', 'Buenos Aires',
        '$2y$10$7U8wP2kOhuOyR9oKr9XSJeWEXPbvPXQBFcDNcliBMjVw2WgKDjdB2', 'alf_qr.png', 1),
       (6, 'Genti', 0, 'alanaumente@gmail.com', 'Genti', 'Masculino', 33, '2023-06-07', 2, NULL, NULL, 1, NULL, b'1',
        '21667', 'Genti', '/public/profilePictures/693633d4e21e801929d731c1608fd5ef (1).png', 'Argentina',
        'Buenos Aires', '$2y$10$/2wJBZ62jYS5aIrumi9ll.tqC/A1pWYQ5OJStuYdwOgnPK.IlG/M6', 'Genti_qr.png', 1),
       (7, 'Charmander', 0, 'asd@asd.com', 'Charmander', 'Masculino', 102, '1997-11-13', 1, NULL, NULL, 1, NULL, b'1',
        '90751', 'Char Char', '/public/profilePictures/pokemon-6895600_1280.webp', 'Argentina', 'Buenos Aires',
        '$2y$10$O8Eps7sPuekP4Lt2ux5eZ.8yq/1tOvtY/c5AJxs7hiLlUCSbVedjm', 'Charmander_qr.png', 1),
       (8, 'Bulbasaur', 0, 'asd@asd.com', 'Bulbasaur', 'Masculino', 12, '1998-12-03', 1, NULL, NULL, 1, NULL, b'1',
        '07041', 'Bulbasaur', '/public/profilePictures/images.png', 'Argentina', 'Buenos Aires',
        '$2y$10$SKuvpQz0ni.4HvuXTE5AWuzQwB4Drez26yARgmfqyaYUc.RKF6CoK', 'Bulbasaur_qr.png', 1),
       (9, 'Squirtle', 0, 'asd@asd.com', 'Squirtle', 'Masculino', 36, '1999-11-11', 1, NULL, NULL, 1, NULL, b'1',
        '91680', 'Squirtle', '/public/profilePictures/afb9abe634d79fc11a43f909164006e8.jpg', 'Argentina',
        'Buenos Aires', '$2y$10$.YaNnE9E7B6m3RUZckg7vOVPoX0xvrgyBt63EsqCHqSkJMXAiBB2u', 'Squirtle_qr.png', 1),
       (10, 'D10s', 0, 'messi@d10s.com', 'Lionel', 'Masculino', 18122022, '1987-06-24', 1, NULL, NULL, 1, NULL, b'1',
        '64394', 'Messi', '/public/profilePictures/messi-1475611.jpg', 'Argentina', 'Santa Fe',
        '$2y$10$sDBRAV7n/5GULuGDjCj2OekJZ8Yf4ZcxL5T1I2XxlhGJiwaMyht.q', 'D10s_qr.png', 1),
