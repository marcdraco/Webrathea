<?php

interface sys_db_Connection {
	function request($s);
	function close();
	function escape($s);
	function lastInsertId();
}
