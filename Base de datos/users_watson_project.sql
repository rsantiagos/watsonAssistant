create table users (
	id int auto_increment primary key,
    email varchar(120) not null,
    password varchar(32) not null,
    empleado_id int not null,
    foreign key (empleado_id) references cat_empleado(emp_id)
);


insert into 
cat_empleado(rol_id, fve_id, emp_nombre, emp_apellidoPaterno, emp_apellidoMaterno, emp_fechaNacimiento, emp_curp)
values(1, 1, 'Juan', 'Pérez', 'Pérez', '1990-01-01', 'PEPJ900101HOCSN06');

insert into
	users(email, password, empleado_id)
values
	('juan.perez@gmail.com', 'e154b165aa6fd89956022d39941114f4', 16);
    
    #password: juanito123