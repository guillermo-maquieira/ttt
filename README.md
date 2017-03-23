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
* Code can be improved by using `phpcbf` after `phpcs` execution

FILE: ...llermo/lampstack-5.6.29-1/apache2/htdocs/ttt/tests/BoardTest.php
----------------------------------------------------------------------
FOUND 18 ERRORS AFFECTING 15 LINES
----------------------------------------------------------------------
  2 | ERROR | [ ] Missing file doc comment
  3 | ERROR | [x] "require" is a statement not a function; no
    |       |     parentheses are required
  5 | ERROR | [ ] Missing class doc comment
  9 | ERROR | [ ] Missing function doc comment
 11 | ERROR | [x] Opening parenthesis of a multi-line function call
    |       |     must be the last content on the line
 13 | ERROR | [x] Closing parenthesis of a multi-line function call
    |       |     must be on a line by itself
 16 | ERROR | [ ] Missing function doc comment
 16 | ERROR | [ ] Public method name
    |       |     "BoardTest::testGet_ValidInput_BoardObject" is not
    |       |     in camel caps format
 18 | ERROR | [x] Opening parenthesis of a multi-line function call
    |       |     must be the last content on the line
 22 | ERROR | [x] Closing parenthesis of a multi-line function call
    |       |     must be on a line by itself
 31 | ERROR | [ ] Missing function doc comment
 31 | ERROR | [ ] Public method name
    |       |     "BoardTest::testPost_NewBoard_BoardObject" is not
    |       |     in camel caps format
 35 | ERROR | [x] Opening parenthesis of a multi-line function call
    |       |     must be the last content on the line
 39 | ERROR | [x] Closing parenthesis of a multi-line function call
    |       |     must be on a line by itself
 48 | ERROR | [ ] Missing function doc comment
 48 | ERROR | [ ] Public method name "BoardTest::testDelete_Error" is
    |       |     not in camel caps format
 50 | ERROR | [x] Opening parenthesis of a multi-line function call
    |       |     must be the last content on the line
 52 | ERROR | [x] Closing parenthesis of a multi-line function call
    |       |     must be on a line by itself
----------------------------------------------------------------------
PHPCBF CAN FIX THE 9 MARKED SNIFF VIOLATIONS AUTOMATICALLY
----------------------------------------------------------------------
