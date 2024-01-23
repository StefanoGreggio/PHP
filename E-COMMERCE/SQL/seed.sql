insert into ecommerce.products(nome, prezzo, marca)
values ("microfono", 107.69, "HyperX"),
       ("personal computer", 489.00, "Asus"),
       ("Smartphone", 135.01, "Samsung");

insert into ecommerce.roles(nome, descrizione)
values ("shopper", "utente base"),
       ("admin", "utente privilegiato");

insert into ecommerce.users(email, password, role_id)
values ('alice@gmail.com', SHA2('password123', 256), 1),
       ('bob@gmail.com', SHA2('qwerty456', 256), 2),
       ('charlie@outlook.com', SHA2('letmein789', 256), 2),
       ('david@libero.it', SHA2('pass1234', 256), 1);

insert into ecommerce.carts(user_id)
values (1),
       (2),
       (3),
       (4);


