TTT
========

Tic Tac Toe as a Service for eDreams ODIGEO.

## Usage

* Use database schema as starting point
![](https://raw.github.com/guillermo-maquieira/ttt/master/er.png)

* Includes MySQL Workbench model
`[model.mwb]`

* Use [Mockaroo](https://www.mockaroo.com/) for realistic data generation
`dump.sql`

* [Propel](http://propelorm.org/) as ORM for reverse engineering
`vendor/bin/propel reverse "mysql:host=localhost;dbname=tic_tac_toe;user=your_user_here;password=your_password_here"`
`vendor/bin/propel model:build --config-dir="/tmp/runtime-conf.xml" --schema-dir="generated-reversed-database/"`

* [phUML](https://github.com/jakobwesthoff/phuml) for class diagrams generation
./phuml -r /home/guillermo/lampstack-5.6.29-1/apache2/htdocs/ttt/generated-classes/Base/ -graphviz -createAssociations false -neato output_image.png

* Includes unit tests generated with PHP Storm
`tests/BoardTest.php`
`tests/UsersTest.php`