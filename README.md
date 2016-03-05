#PROYECTO FINAL DE 2º DE DAW 2015/2016

#Objetivo del proyecto
> Con el presente proyecto se pretende mediante los conocimientos adquiridos llevar a cabo la construcción o creación desde cero de un servidor (el cuál tiene una mínima configuración) que contendrá los servicios necesarios así como las aplicaciones y tecnología necesaria para atender las peticiones de los usuarios.  

#Enunciado

> El proyecto consiste en desarrollar la intranet del centro. Constará de una página principal donde, en función del perfil del usuario, aparecerán enlaces a diversas operaciones que podrán realizar.  

> La intranet debe poder utilizarse desde PC, tablet o movil (dispondremos de tablets para poder comprobar su correcta visualización y funcionamiento).

> En principio los niveles que hay son: alumno, tutor, jefe de departamento y dirección. Tutores, jefes de departamento y dirección son también profesores.

> El acceso de los alumnos será mediante DNI y contraseña y el de los profesores mediante código y contraseña.

> La carga de alumnos se realizará importándolos desde Itaca. Los profesores deben darse de alta ellos mismos (algunos ya estarán de otros años).

##Módulos a desarrollar

> Los principales módulos que tendrá la intranet son:


> **Mantenimiento básico**  
+ Alumnos: DNI, NIA, Nombre, 1º Apellido, 2º Apellido, contraseña, e-mail, grupo,fecha nacimiento, foto. Cada alumno sólo puede modificar su contraseña, e-mail y foto (enlace para subirla controlando el tamaño o webcam para hacérsela). Dirección puede modificarlo todo. OJO: hay algunos alumnos con más de 1 registro porque están matriculados en más de 1 ciclo.
  
>+ Profesores: código (4 cifras que se genera automáticamente), codHorario (3 cifras,lo pone dirección), DNI, Nombre, 1º Apellido, 2º Apellido, contraseña, e-mail, e-mail alumnos, departamento, fecha baja, foto. Sólo pueden modificar su contraseña, email, e-mail alumnos (opcional, si no lo ponen será el mismo del otro) y foto (enlace para subirla controlando el tamaño o webcam para hacérsela). Dirección puede modificarlo todo. Además de esos datos básicos se guardarán otros datos (que sí puede modificar cada profesor: domicilio, domicilio durante el curso, teléfono, etc (los datos de alta del documento para Secretaría).

>+ Grupos: código (5 caracteres), nombre (família), turno, semipresencial (s/n), tutor (DNI del tutor), alumnos del grupo.

>+ Sustitutos: haremos la gestión de profesores sustitutos. Cuando llegue alguien a sustituir a otro además de añadirlo a la tabla de profes (si no estaba, o activarlo si estaba) quedará constancia de a quién sustituye y, si el sustituido era tutor, aparecerá como tutor el nuevo. Al irse el sustituto se revertirá el proceso.

>Informes a realizar:

>+ Ficha del profesor.
+ Solicitud de comisión de servicio del profesor.
+ Certificado de Riesgos Laborales del alumno (se deberán poder sacar los certificados por grupo o por alumno).  

>**Cursillos de Manipulador de Alimentos**  

>En tablas se guardará de cada uno: código (xxx/aaaa), FechaIni, FechaFin, Horas, Activo (si o no, sólo 1 estará activo y es al que se apuntan los usuarios), profesorado (texto), comentarios.

>Los usuarios se apuntan al curso activo. Al acabar el curso dirección marca a cada alumno si lo ha acabado o no (controlando la hoja de firmas del curso).

>Informes:

>+ Hoja de firmas: identificación del curso, fecha, nombre de cada alumno y espacio para firmar.
>+ Certificados: al acabar un curso se imprime un certificado para cada alumno que lo haya superado (se deberán poder sacar los certificados por grupo o por alumno).

>**Actividades extraescolares**

>En tablas se  guardará de cada una: código, nombre, descripción, objetivos, Fecha realización, HoraIni, HoraFin, Fecha alta, Coordinador (un profesor), Acompañantes (varios profesores), participantes (varios grupos), Comentarios.

>Sólo el coordinador o la dirección pueden modificar las actividades existentes. Se enviará un e-mail a todos los profes participantes y a la dirección informándoles de la actividad.

>Informes:
>+ Solicitud de actividad (para Secretaría).
>+ Hoja de autorización para los menores de edad.

##Enlaces de la página principal
> En la página principal, en función del perfil del usuario, aparecerán enlaces a diversas operaciones que podrán realizar. Los diferentes accesos que habrá son:

>**Para alumnos**
>+ Datos del usuario: DNI, NIA, Nombre, 1º Apellido, 2º Apellido, contraseña, e-mail,
grupo, fecha nac, foto. Sólo pueden modificar su contraseña, e-mail y foto (enlace para subirla controlando el tamaño o webcam para hacérsela).
>+ Alta del curso de manipulador de alimentos: formulario donde se apuntan al próximo curso de manipulador que se vaya a realizar.
>+ Enlaces: Itaca para ver sus notas, nuestro Moodle, el Moodle de Consellería si son alumnos de semipresencial.  
>    
>    
>  
>**Para profes**
>
>+ Datos del usuario: código (4 cifras que se genera automáticamente), codHorario (3
cifras, lo pone dirección), DNI, Nombre, 1º Apellido, 2º Apellido, contraseña, e-mail,
e-mail alumnos, departamento, fecha baja, foto. Sólo pueden modificar su contraseña, e-mail, e-mail alumnos (opcional, si no lo ponen será el mismo del otro) y foto (enlace para subirla controlando el tamaño o webcam para hacérsela).
>
>+ Otros datos: domicilio, domicilio durante el curso, teléfono, etc (los datos de alta de Secretaría). Los puede modificar todos.
> 
>+ Actividades extraescolres: consulta de las actividades dadas de altas o alta de nuevas actividades.
>
>+ Enlaces: Itaca, nuestro Moodle, el Moodle de Consellería si son profes de semipresencial.
>
>+ Solicitud comisión de servicios.
>
>**Para dirección**
>
>+ Modificación de alumnos (el mismo formulario pero con todos los campos editables).
>
>+ Modificación de profes (el mismo formulario pero con todos los campos editables).
>
>+ Mantenimiento de los grupos: posibilidad de dar de alta/baja alumnos de un grupo así como cambiar el tutor del grupo.  

##Ampliaciones  
>Algunas propuestas de ampliación de la intranet son:
>+ Módulo de control de asistencia de los profesores.
>
>+ Módulo de encuestas de Cocina para valorar los servicios (con tablets) y la comida para llevar (desde PC).
>
>+ Automatización de la carga de usuarios al principio de cada curso (los datos se reciben de Itaca en ficheros XML).

##Reparto del trabajo
