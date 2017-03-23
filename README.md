TTT
========

Tic Tac Toe as a Service for eDreams ODIGEO.

## Usage

* Use database schema as starting point
![](https://raw.github.com/guillermo-maquieira/ttt/master/er.png)

* Includes MySQL Workbench model `model.mwb`

* Use [Mockaroo](https://www.mockaroo.com/) for `dump.sql` realistic data generation

* [Propel](http://propelorm.org/) as ORM for reverse engineering as (1) and (2)
```
(1) vendor/bin/propel reverse "mysql:host=localhost;dbname=tic_tac_toe;user=your_user_here;password=your_password_here"
```
```
(2) vendor/bin/propel model:build --config-dir="/tmp/runtime-conf.xml" --schema-dir="generated-reversed-database/"
```

* [phUML](https://github.com/jakobwesthoff/phuml) for class diagrams (base and map) generation
```
./phuml -r /home/guillermo/lampstack-5.6.29-1/apache2/htdocs/ttt/generated-classes/Base/ -graphviz -createAssociations false -neato output_image.png
```
![](https://raw.github.com/guillermo-maquieira/ttt/master/map.png)

* Includes integration (API) tests `tests/BoardTest.php`

* See `oop.php` for my (simple) class definition using `phpcs` and `phpcbf` for coding improvements
```
checkLine: Validates if a winner ('x'/'o') exists on a line (1 out of 3)
checkColumn: Validates if a winner ('x'/'o') exists on a column (1 out of 3)
checkDiagonal: Validates if a winner ('x'/'o') exists on a diagonal (1 out of 2)
setWinner: Defines if 'x' or 'o' wins a game
getWinner: Validates and prompts a game won message
```
