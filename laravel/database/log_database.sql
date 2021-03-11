--  Se eliminan tablas de types ay subtypes 24-11-2016
drop table types;
drop table subtypes;

-- Se renombra tabla de documents a documents_movtos 24-11-2016
rename table documents to documents_movements;

--Agregar y quitar campos de tabla documents_movtos 24-11-2016
alter table documents_movements drop column document_bag_barcode;
alter table documents_movements drop column document_name;
alter table documents_movements drop column document_type;
alter table documents_movements drop column document_owner_id;
alter table documents_movements drop column document_location;
alter table documents_movements drop column document_arrival_date;
alter table documents_movements drop column document_departure_date;
alter table documents_movements add column document_id integer;
alter table documents_movements add column date timestamp;
alter table documents_movements add column new_location varchar(255);

-- Se renombra tabla de document a documents 24-11-2016
rename table document to documents;

--Agregar y quitar campos de tabla documents 24-11-2016
alter table documents change picture picture_path varchar(255);

alter table documents add column location varchar(255);
alter table documents add column type varchar(255);
alter table documents add column subtype varchar(255);
alter table documents add column folio integer;

alter table documents drop column number;
alter table documents drop column status;

--Modificaiones tabla users 24-11-2016
alter table users change id_profile id_role integer;
alter table users drop column status;
alter table users add column active_status tinyint(1) default 0;
alter table users add column pay_status tinyint(1) default 0;
alter table users add column profile_status tinyint(1) default 0;

--Agreger resigistros de prueba tabla documents y  documents_movements 25-11-2016
insert into documents (id_user, location, type, folio, expedition, expiration) values (2, 'Boveda', 'Pasaporte', 12345, now(), now());
insert into documents (id_user, location, type, folio, expedition, expiration) values (2, 'Cliente', 'IFE', 123456, now(), now());
insert into documents (id_user, location, type, folio, expedition, expiration) values (2, 'Boveda', 'CURP', 123457, now(), now());

INSERT INTO `documents_movements` VALUES (1,'2016-11-11 14:49:21','2016-11-11 14:49:21',NULL,'0000-00-00 00:00:00',NULL),(2,NULL,NULL,1,'2016-11-25 10:08:23','Cliente'),(3,NULL,NULL,1,'2016-11-25 10:08:23','Boveda'),(4,NULL,NULL,2,'2016-11-25 10:08:23','Cliente'),(5,NULL,NULL,3,'2016-11-25 10:08:23','Cliente'),(6,NULL,NULL,3,'2016-11-25 10:08:23','Boveda');

--Agregar campo de status para la tabla documents
alter table documents add column status tinyint(1) default 1 after updated_at;

--Modificaiones tabla documents 14-11-2016
alter table documents change alias alias varchar(255) null;

--Modificaiones tabla documents_movements - 14-12-2016
ALTER TABLE documents_movements MODIFY created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL;
ALTER TABLE documents_movements MODIFY updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL;

--Modificaiones tabla users_referreds 20-12-2016
alter table users_referreds change id_referred_user id_referred_user integer null;
alter table users_referreds add column email varchar(255) null default '' after id_referred_user;

--Crear tabla audits - 20-12-2016
create table `audits` (`id` int unsigned not null auto_increment primary key, `client_id` varchar(40) not null, `document_id` varchar(40) not null, `date` datetime not null,  `status` tinyint not null,  `notes` varchar(255) null,  `created_at` timestamp default 0 not null,  `updated_at` timestamp default 0 not null);

--Agregar campo paid a tabla audits - 21-12-2016
alter table audits add column paid tinyint(4) default 1 after notes;

-- Agregar campos de latitude y longitude a la tabla de services_orders - 21-12-2016
alter table services_orders add column longitude float null after urgent;
alter table services_orders add column latitude float null after urgent;

-- Agregar tabla de services2documents para crear la relación - 23-12-2016
create table `services2documents` (`id` int unsigned not null auto_increment primary key, `service_id` int not null, `document_id` int not null, `created_at` timestamp default 0 not null, `updated_at` timestamp default 0 not null);

--Remover campo de documents en services_orders - 23-12-2016
alter table `services_orders` drop documents;

-- Actualizar el tipo de datos de varchar a integer de los campos client_id y document_id de la tabla de audits - 23-12-2016
ALTER TABLE audits CHANGE client_id client_id INT NOT NULL, CHANGE document_id document_id INT NOT NULL;

-- Eliminar campo de id_document de auditorias
alter table audits drop column document_id;

-- Create tables type and subtype of the documents - 30-12-2016
create table `types` (`id` int unsigned not null auto_increment primary key, `name` varchar(255) not null, `created_at` timestamp default 0 not null, `updated_at` timestamp default 0 not null);
create table `subtypes` (`id` int unsigned not null auto_increment primary key, `name` varchar(255) not null, `type_id` int not null, `created_at` timestamp default 0 not null, `updated_at` timestamp default 0 not null);

-- Create table cards - 30-12-2016
create table `cards` (`id` int unsigned not null auto_increment primary key, `name` varchar(50) not null, `number` varchar(4) not null, `expiration_month` varchar(2) not null, `expiration_year` varchar(2) not null, `token` varchar(25) not null, `idApiCard` varchar(25) not null, `client_id` int not null, `created_at` timestamp default 0 not null, `updated_at` timestamp default 0 not null);

--Insert tipos de documentos 3-enero-2017
insert into types (name, created_at, updated_at) values ('Factura', now(), now());
insert into types (name, created_at, updated_at) values ('Póliza', now(), now());
insert into types (name, created_at, updated_at) values ('Testamento', now(), now());
insert into types (name, created_at, updated_at) values ('Escritura', now(), now());
insert into types (name, created_at, updated_at) values ('Acta', now(), now());
insert into types (name, created_at, updated_at) values ('Impuestos', now(), now());
insert into types (name, created_at, updated_at) values ('Pagos', now(), now());
insert into types (name, created_at, updated_at) values ('Otro', now(), now());

--Insert sub-tipos de documentos 3-enero-2017
insert into subtypes (name, type_id, created_at, updated_at) values ('Automóvil', 1, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Elctrónicos', 1, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Servicios', 1, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Mobiliario', 1, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Otro', 1, now(), now());

insert into subtypes (name, type_id, created_at, updated_at) values ('Vida', 2, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Casa', 2, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Auto', 2, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Educación', 2, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Ahorro', 2, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Gastos médicos', 2, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Servicios funerarios', 2, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Otro', 2, now(), now());

insert into subtypes (name, type_id, created_at, updated_at) values ('Anterior', 3, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Vigente', 3, now(), now());

insert into subtypes (name, type_id, created_at, updated_at) values ('Terreno', 4, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Departamento', 4, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Casa', 4, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Oficinas', 4, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Edificio', 4, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Otro', 4, now(), now());

insert into subtypes (name, type_id, created_at, updated_at) values ('Nacimiento', 5, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Matrimonio', 5, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Defunción', 5, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Constitutiva', 5, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Asamblea', 5, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Otro', 5, now(), now());

insert into subtypes (name, type_id, created_at, updated_at) values ('Declaración', 6, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Tenencia', 6, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Predial', 6, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Otro', 6, now(), now());

insert into subtypes (name, type_id, created_at, updated_at) values ('Servicios', 7, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Proveedores', 7, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Otro', 7, now(), now());

insert into subtypes (name, type_id, created_at, updated_at) values ('Acciones', 8, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Cartilla', 8, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Contrato', 8, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Convenio', 8, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Llave de refacción', 8, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Manuales', 8, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Poderes', 8, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Títulos de crédito', 8, now(), now());
insert into subtypes (name, type_id, created_at, updated_at) values ('Otro', 8, now(), now());

--Add foreing key to subtypes 4-enero-2017
ALTER TABLE subtypes CHANGE type_id type_id INT UNSIGNED NOT NULL;
alter table `subtypes` add constraint subtypes_type_id_foreign foreign key (`type_id`) references `types` (`id`) on delete cascade on update cascade;

--Crear tabla para entradas y salidas de documentos 4-enero-2017
create table `documents_inout` (`id` int unsigned not null auto_increment primary key, `document_id` int not null, `folio` varchar(255) not null, `created_at` timestamp default '0000-00-00 00:00:00' not null, `updated_at` timestamp default '0000-00-00 00:00:00' not null);

-- Crear tabla de relacion auditorias-documentos 9-enero-2017
create table `audits_has_documents` (`id` int unsigned not null auto_increment primary key, `audit_id` int not null, `document_id` int not null, `created_at` timestamp default 0 not null, `updated_at` timestamp default 0 not null);

-- Crear tablas para pagos 10-enero-2017
create table `payments` (`id` int unsigned not null auto_increment primary key, `user_id` int not null, `date` datetime not null, `amount` double(8, 2) not null, `payment_method` tinyint not null, `transaction_id` varchar(40) not null, `description` varchar(255) not null, `source_id` varchar(40) not null, `order_id` varchar(40) not null, `created_at` timestamp default 0 not null, `updated_at` timestamp default 0 not null);
create table `users2openpay` (`id` int unsigned not null auto_increment primary key, `user_id` int not null, `customer_id` varchar(40) not null, `email` varchar(255) not null, `created_at` timestamp default 0 not null, `updated_at` timestamp default 0 not null);
rename table `cards` to `cards2openpay`;
alter table cards2openpay add column main tinyint(1) default 0;
alter table payments add column start_date timestamp not null;
alter table payments add column end_date timestamp not null;
alter table cards2openpay add column device_session_id varchar(255);
alter table cards2openpay CHANGE idApiCard id_api_card varchar(255);

-- Agregar type to table payments 11-enero-2017
alter table `payments` add `type` tinyint not null after `order_id`;
-- Agregar status to table payments 11-enero-2017
alter table `payments` add `status` tinyint not null after `order_id`	;
-- Agregar main_method_payment to users payments 11-enero-2017
alter table `users` add `main_method_payment` tinyint not null default '0';
--Insert costs services 11-enero-2017
INSERT INTO `service_cost` (`id`, `annual_cost`, `reception_cost`, `delivery_cost`, `mixed_cost`, `created_at`, `updated_at`) VALUES ('1', '1299', '50', '50', '50', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- Cambiar de nombre la columna address_description por alias tabla user_addresses 06-marzo-2017
alter table user_addresses change address_description alias varchar(255);

-- Agregar longitude y latitude a la tabla user_addresses 16-marzo-2017
ALTER TABLE user_addresses ADD COLUMN latitude double precision after address;
ALTER TABLE user_addresses ADD COLUMN longitude double precision after address;

-- Agregar eliminated a la tabla user_addresses (borrado logico) 17-marzo-2017
ALTER TABLE user_addresses ADD COLUMN eliminated tinyint(1) default 0 after latitude;

-- Agregar status a la tabla cards2openpay (borrado logico) 10-abril-2017
alter table cards2openpay add column status bool default true after main;
