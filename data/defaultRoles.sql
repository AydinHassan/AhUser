INSERT INTO `role` (`id`, `parent_id`, `role_id`)
VALUES
    (1, NULL,   'guest'),
    (2, 1,      'user'),
    (3, 2,      'admin');
