#PROYECTO FINAL DE 2º DE DAW 2015/2016
**Ponentes:**

+ Diseño: Daniel Ferrándiz López
+ Programación: Jose Vicente Martinez Mellado, Jose Luis Moltó Gimeno, Raúl Lara Rico, Carlos Huelmo Vaquero.
+ Sistemas: Carlos Huelmo Vaquero.  


**Tecnologías utilizadas:**  

* Configuración del servidor: Apache, MySQL, vsFTPD, OpenSSH, Webmin.
* Lenguajes: HTML5, Javascript, CSS 3, LESS, PHP.
* Librerías: jQuery, jQuery UI,FPDF, FPDI.  



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

>Cada grupo debe repartirse el trabajo como crea conveniente.  

>Si el grupo lo cree conveniente se le dará más nota al coordinador o a quien haga más trabajo. En ese caso serán los miembros del grupo quienes nos digan cómo repartir las
notas: podemos hacer que los 5 miembros tengan la nota obtenido por el grupo o bien
que algunos miembros tengan más y menos nota partiendo de la nota del grupo como
base, por ejemplo un alumno +0,5 puntos, otro -0,5 puntos, otro +1 punto y otro -1 punto (o de cualquier otra forma pero que siempre la media salga la nota del grupo). 
 
##Tiempo para realizar el proyecto  
>En cada módulo se dedicará un mínimo de 1 o 2 horas semanales para la realización del
proyecto. El número de horas dedicadas al proyecto podrá incrementarse más adelante según se vayan completando los contenidos del módulo.  

>En dichas horas el grupo hará el trabajo que desee, siempre relacionado con el proyecto. Se podrá consultar cualquier tipo de dudas al profesor que esté en clase en ese momento aunque no siempre será capaz de resolverlas si no es el encargado de la parte del proyecto a que corresponde la duda planteada.  

##Cosas a hacer en los diferentes módulos  

>Cada uno de nosotros corregiremos sólo la parte que nos toca aunque el proyecto sea
global. Las cosas a hacer son:  

>+ Despliegue: Instalación y configuración del servidor Apache. Securización del servidor. Instalación y configuración del servidor LDAP.  
+ DWServidor: creación de la BBDD y todo el backend.
+ DWCliente: creación del frontend.
+ Interfaces: estilos, accesibilidad, usabilidad, web responsive (tablets, ...).

>###Módulo de Desarrollo Web en entorno Cliente
>> Daremos funcionalidad a las diferentes páginas creadas siguiendo la guía de estilo definida. Entre estas funcionalidades se incluirá:
>+ Validación de cada formulario desde HTML5 y JavaScript.
+ Utilización de JavaScript para dar funcionalidad a las páginas.
+ Utilización de Ajax en aquellas páginas en que sea apropiado para reducir el tiempo de esperar respuesta del servidor.
+ Utilización de widgets e interacciones de jQuery UI donde sea apropiado (para organizar la información en páginas o formularios con muchos datos, para introducir fechas, ...).  

>***NOTA:*** lo que se pide que hagáis en JavaScript puede ser también hecho usando cualquier librería del lenguaje (como jQuery, PrototypeJS o cualquier otra).  

>>A la hora de calificar el proyecto se tendrá en cuenta:  

>>1.- La claridad e idioneidad del código usado.  

>>2.- Que el códgio esté comentado adecuadamente.

>>3.- Que no se sobrecarguen las páginas con código innecesario (por ejemplo, si una página no usa jQuery no se ha de cargar esa librería).

>>4.- Que los diferentes campos de los formularios se validan correctamente.

>>5.- Que se utiliza Ajax de manera adecuada en donde tiene sentido hacerlo.

>>6.- Que se utiliza jQuery UI donde mejora el aspecto i/o la funcionalidad de una página.
