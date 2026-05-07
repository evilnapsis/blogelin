/*
* BOOKSTYLE PRO - Professional Appointments and Sales System
* Author: @evilnapsis
*/

create database if not exists bookstyle;
use bookstyle; 

-- MODULO: SEGURIDAD Y ACCESO (Gestión de usuarios y permisos)

/* rol: Define los perfiles de acceso al sistema (Admin, Profesional, etc.) */
create table if not exists rol (
    id int not null auto_increment primary key,
    name varchar(50)
);

/* user: Almacena las credenciales y datos básicos de acceso para todo el personal y clientes */
create table if not exists user (
    id int not null auto_increment primary key,
    username varchar(50) unique,
    name varchar(50),
    lastname varchar(50),
    email varchar(255) unique,
    password varchar(60),
    is_active boolean not null default 1,
    is_verified boolean not null default 0,
    rol_id int not null,
    created_at datetime,
    foreign key (rol_id) references rol(id)
);

insert ignore into rol (id, name) values (1, "Admin"), (2, "Staff"), (3, "Professional"), (4, "Client");

/* permission: Matriz de acceso granular para cada vista y rol */
create table if not exists permission (
    id int not null auto_increment primary key,
    rol_id int not null,
    view_name varchar(100),
    can_view boolean default 1,
    can_add boolean default 0,
    can_edit boolean default 0,
    can_delete boolean default 0,
    foreign key (rol_id) references rol(id)
);

insert ignore into user (id, username, name, email, password, rol_id, created_at) values (1, "admin", "Administrator", "admin@bookstyle.pro", sha1(md5("admin")), 1, NOW());

-- MODULO: FINANZAS E INFRAESTRUCTURA (Configuración base)

/* payment_method: Catálogo dinámico de formas de pago (Efectivo, PayPal, etc.) */
create table if not exists payment_method (
    id int not null auto_increment primary key,
    name varchar(100),
    short varchar(50), -- Slug para pasarelas (paypal, stripe, clip)
    is_web boolean default 0, -- Disponible en reserva pública
    is_active boolean default 1,
    created_at datetime
);

insert ignore into payment_method (id, name, short, is_web, created_at) values 
(1, 'Efectivo', 'cash', 0, NOW()), 
(2, 'Tarjeta', 'card', 0, NOW()), 
(3, 'Transferencia', 'transfer', 0, NOW()), 
(4, 'PayPal', 'paypal', 1, NOW()), 
(5, 'Stripe', 'stripe', 1, NOW());

/* office: Representa las sucursales, salas o cabinas */
create table if not exists office (
    id int not null auto_increment primary key,
    name varchar(255),
    location varchar(255),
    created_at datetime
);

/* category: Catálogo de categorías para productos y servicios */
create table if not exists category (
    id int not null auto_increment primary key,
    name varchar(255),
	color varchar(255),
    created_at datetime
);

-- MODULO: RECURSOS HUMANOS (Personal)

/* staff: Registra al personal de apoyo (recepcionistas, asistentes, etc.) */
create table if not exists staff (
    id int not null auto_increment primary key,
    user_id int,
    position varchar(100),
    created_at datetime,
    foreign key (user_id) references user(id)
);

/* professional: Perfil detallado de los profesionales, vinculado a una categoría y cuenta de usuario */
create table if not exists professional (
    id int not null auto_increment primary key,
    user_id int,
    category_id int,
    license_number varchar(100),
    image varchar(255),
    appointment_duration int default 30, -- Duración en minutos de cada cita
    biography text,
    created_at datetime,
    foreign key (user_id) references user(id),
    foreign key (category_id) references category(id)
);

-- MODULO: PERSONAS (Clientes y Proveedores Unificados)

/* person: Datos generales de contacto para clientes y proveedores */
create table if not exists person (
    id int not null auto_increment primary key,
    name varchar(255),
    lastname varchar(255),
    company varchar(255),
    email varchar(255),
    phone varchar(255),
    address varchar(255),
    kind int, -- 1: Client, 2: Supplier
    user_id int, -- Link to user account for clients
    created_at datetime,
    foreign key (user_id) references user(id)
);

/* Roles del Sistema:
   1: Administrador
   2: Staff / Profesional
   3: Cliente Registrado
*/


/* schedule: Definición de los horarios de disponibilidad de cada profesional */
create table if not exists schedule (
    id int not null auto_increment primary key,
    professional_id int,
    day_of_week int,
    start_time time,
    end_time time,
    created_at datetime,
    foreign key (professional_id) references professional(id)
);

-- MODULO: CATALOGO UNIFICADO (Productos y Servicios)

/* product: Listado unificado de productos (stockables) y servicios (no stockables) */
create table if not exists product (
    id int not null auto_increment primary key,
    name varchar(255),
    description text,
    price_in decimal(10,2), -- Costo 
    price_out decimal(10,2), -- Precio de venta
    duration int default 0, -- Duración en minutos (solo para servicios)
    stock int default 0, -- Solo para kind=1
    image varchar(255),
    category_id int,
    kind int default 1, -- 1: Producto, 2: Servicio
    is_active boolean default 1,
    is_web boolean default 0,
    created_at datetime,
    foreign key (category_id) references category(id)
);

-- MODULO: OPERACIONES (Citas e Ingresos)

/* appointment: Registro central de citas */
create table if not exists appointment (
    id int not null auto_increment primary key,
    person_id int, 
    professional_id int, 
    office_id int, 
    product_id int, 
    date date,
    time time,
    reason text,
    status varchar(50) default 'pending',
    payment_method_id int, 
    kind int default 1, 
    created_at datetime,
    foreign key (person_id) references person(id),
    foreign key (professional_id) references professional(id),
    foreign key (office_id) references office(id),
    foreign key (product_id) references product(id),
    foreign key (payment_method_id) references payment_method(id)
);

/* 3. Agregar la columna faltante a la tabla de citas */
ALTER TABLE appointment ADD COLUMN IF NOT EXISTS payment_method_id INT;
ALTER TABLE appointment ADD CONSTRAINT fk_appointment_payment_method FOREIGN KEY (payment_method_id) REFERENCES payment_method(id);

-- MODULO: OPERACIONES (Citas e Ingresos)

/* payment: Registro de abonos o pagos parciales */
create table if not exists payment (
    id int not null auto_increment primary key,
    appointment_id int,
    amount decimal(10,2) not null,
    payment_method_id int,
    created_at datetime,
    foreign key (appointment_id) references appointment(id),
    foreign key (payment_method_id) references payment_method(id)
);

-- MODULO: ANALÍTICA Y CONFIGURACIÓN

/* income/expense: Control de caja diaria directo */
create table if not exists income (
    id int not null auto_increment primary key, amount decimal(10,2), source varchar(100), date date, created_at datetime
);
create table if not exists expense (
    id int not null auto_increment primary key, amount decimal(10,2), category varchar(100), description text, date date, created_at datetime
);

/* setting: Configuración global */
create table if not exists setting (
    id int not null auto_increment primary key, setting_key varchar(100) unique, setting_value longtext, created_at datetime
);

-- SEED DATA FINAL

insert ignore into category (id, name, color, created_at) values 
(1, "Barbería Clásica", "#6366f1", NOW()),
(2, "Estilismo", "#ec4899", NOW()),
(3, "Tratamientos Faciales", "#10b981", NOW());

insert ignore into product (id, name, description, price_out, duration, kind, category_id, is_active, is_web, created_at) values
(1, "Corte de Cabello", "Corte tradicional", 15.00, 30, 2, 1, 1, 1, NOW()),
(2, "Perfilado de Barba", "Afeitado premium", 10.00, 20, 2, 1, 1, 1, NOW());

insert ignore into product (id, name, description, price_in, price_out, stock, kind, category_id, is_active, is_web, created_at) values
(3, "Cera Mate 100ml", "Cera fijadora", 5.00, 12.00, 20, 1, 1, 1, 0, NOW());

insert ignore into office (id, name, location, created_at) values
(1, "Cabina Principal", "Nivel 1 - Local A", NOW());
