drop table if exists ag_ayuda_mensajes;
drop table if exists ag_ayuda_archivos;
drop table if exists ag_ayuda_asuntos;
create table if not exists ag_ayuda_asuntos
(
	id bigint not null primary key auto_increment,
    id_usuario bigint not null,
    asunto char(80) not null,
    status tinyint not null default 0,
    telefono varchar(45),
    eliminado boolean not null default 0,
    fecha_registrado timestamp default now(),
    fecha_actualizado timestamp default now() on update now(),
    fecha_eliminado timestamp,
    foreign key(id_usuario) references mdl_user(id)
);
drop view if exists view_asuntos; create view  view_asuntos as select id_usuario,asunto,status,telefono from ag_ayuda_asuntos where eliminado = 0;
create table if not exists ag_ayuda_archivos
(
	id bigint not null primary key auto_increment,
    id_asunto bigint not null,
    eliminado boolean not null default 0,
    fecha_registrado timestamp default now(),
    fecha_actualizado timestamp default now() on update now(),
    fecha_eliminado timestamp,
    foreign key(id_asunto) references ag_ayuda_asuntos(id)
);
drop view if exists view_archivos; create view view_archivos as select id,id_asunto from ag_ayuda_archivos where eliminado = 0;

create table if not exists ag_ayuda_mensajes
(
	id bigint not null primary key auto_increment,
    id_asunto bigint not null,
    id_usuario bigint not null,
    mensaje varchar(255),
    hora datetime not null default now(),
    eliminado boolean not null default 0,
    fecha_registrado timestamp default now(),
    fecha_actualizado timestamp default now() on update now(),
    fecha_eliminado timestamp,
    foreign key(id_asunto) references ag_ayuda_asuntos(id),
    foreign key(id_usuario)references mdl_user(id)
);
drop table if exists ag_ayuda_preguntasfrecuentes;
create table ag_ayuda_preguntasfrecuentes
(
	id tinyint not null primary key auto_increment,
    asunto char(80) not null,
    mensaje varchar(255) not null,
    jerarquia tinyint not null default 1,
    eliminado boolean not null default 0,
    fecha_registrado timestamp default now(),
    fecha_actualizado timestamp default now() on update now(),
    fecha_eliminado timestamp
);
drop view if exists view_preguntasfrecuentes; create view view_preguntasfrecuentes as select id,asunto,mensaje,jerarquia from ag_ayuda_preguntasfrecuentes where eliminado = 0;





drop view if exists view_mensajes; create view view_mensajes as select id_asunto,id_usuario,mensaje,hora from ag_ayuda_mensajes where eliminado = 0;
drop trigger if exists chkayuda_asuntos;
delimiter $
create trigger chkayuda_asuntos before update on ag_ayuda_asuntos
for each row
begin
	if new.eliminado = 1 then
		set new.fecha_eliminado = now();
    end if;
end $
drop trigger if exists chkayuda_mensajes;
delimiter $
create trigger chkayuda_mensajes before update on ag_ayuda_mensajes
for each row
begin
	if new.eliminado = 1 then
		set new.fecha_eliminado = now();
    end if;
end $
drop trigger if exists chkayuda_archivos;
delimiter $
create trigger chkayuda_archivos before update on ag_ayuda_archivos
for each row
begin
	if new.eliminado = 1 then
		set new.fecha_eliminado = now();
    end if;
end $
drop trigger chkayuda_preguntasfrecuentes;
delimiter $
create trigger chkayuda_preguntasfrecuentes before update on ag_ayuda_preguntasfrecuentes
for each row
begin
	if new.eliminado = 1 then
		set new.fecha_eliminado = now();
    end if;
end $

drop procedure if exists proc_guardar_asunto;
delimiter $
create procedure proc_guardar_asunto(in _usuario bigint,in _asunto char(80),in _mensaje varchar(255), in _telefono varchar(45))
begin
	declare _id_asunto bigint;
    start transaction;
	insert into ag_ayuda_asuntos(id_usuario,asunto,telefono)values(_usuario,_asunto,_telefono);
    set _id_asunto = last_insert_id();
    insert into ag_ayuda_mensajes(id_usuario,id_asunto,mensaje)values(_usuario,_id_asunto,_mensaje);
    commit;
    select _id_asunto as asunto, last_insert_id() as mensaje;
end $

drop procedure if exists proc_guardar_mensaje;
delimiter $
create procedure proc_guardar_mensaje(in _usuario bigint, in _id_asunto bigint, in _mensaje varchar(255))
begin
	insert into ag_ayuda_mensajes(id_usuario,id_asunto,mensaje)values(_usuario,_id_asunto,_mensaje);
end $
drop procedure if exists proc_guardar_archivo;
delimiter $
create procedure proc_guardar_archivo(in _id_asunto bigint)
begin
	insert into ag_ayuda_archivos(id_asunto)values(_id_asunto);
    select last_insert_id() as archivo;
end $

drop procedure if exists proc_guardar_preguntasfrecuentes;
delimiter $
create procedure proc_guardar_preguntasfrecuentes(in _asunto char(80),in _mensaje varchar(255), in _jerarquia tinyint)
begin
	insert into ag_ayuda_preguntasfrecuentes(asunto,mensaje,jerarquia)values(_asunto,_mensaje,_jerarquia);
    select last_insert_id() as id;
end $
drop procedure if exists proc_guardar_status;
delimiter $
create procedure proc_guardar_status(in _id_asunto bigint, in _status tinyint)
begin
	update ag_ayuda_asunto set status = _status  where id = _id_asunto;
end $
drop procedure if exists proc_eliminar_mensaje;
delimiter $
create procedure proc_eliminar_mensaje(in _id_mensaje bigint)
begin
	update ag_ayuda_mensajes set eliminado = 1 where id = _id_mensaje;
end $
drop procedure if exists proc_eliminar_asunto;
delimiter $
create procedure proc_eliminar_asunto(in _id_asunto bigint)
begin
	update ag_ayuda_asuntos set eliminado = 1 where id = _id_asunto;
end $
drop procedure if exists proc_eliminar_archivo;
delimiter $
create procedure proc_eliminar_archivo(in _id_archivo bigint)
begin
	update ag_ayuda_archivos set eliminado = 1 where id = _id_archivo;
end $
drop procedure if exists proc_eliminar_preguntasfrecuentes;
delimiter $
create procedure proc_eliminar_preguntasfrecuentes(in _id tinyint)
begin
	update ag_ayuda_preguntasfrecuentes set eliminado = 1 where id = _id;
end $