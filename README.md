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

* Includes unit test `tests/BoardTest.php` generated with Guzzle and PHP Unit
```
PHPUnit 5.7.17 by Sebastian Bergmann and contributors.

EE.                                                                 3 / 3 (100%)

Time: 1.12 seconds, Memory: 5.00MB

There were 2 errors:

1) BoardTest::testGet_ValidInput_BoardObject
GuzzleHttp\Exception\ClientException: Client error: `GET http://tictactoe.com/board?id_board=1` resulted in a `404 Not Found` response:
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found (truncated...)
```