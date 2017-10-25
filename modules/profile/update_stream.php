<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the Affero General Public License version 3
    * as published by the Free Software Foundation.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU Affero General Public License for more details.
	*
    * You should have received a copy of the Affero General Public License
    * version 3 along with this program.  If not, see https://www.gnu.org/licenses/agpl-3.0.en.html.
    */

  //Required configuration files
  require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
  require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

  if(superadmin()){

    //Add the stream
    $streamid = $_POST["id"];
    $streamtitle = $_POST["title"];
    $rsslink = $_POST["link"];
    $streamgroup = $_POST["group"];
    $required = $_POST["required"];

    if($streamid == ""){
      $stmt = $db->stmt_init();
      //needed to backtick because SQL doesn't like when you use reserved words
      $sql = "INSERT INTO `streams` (`group`,`title`,`slug`,`type`,`url`,`required`) VALUES (?, ?, ?,'flipboard', ?, ?);";
      $stmt->prepare($sql);
      $stmt->bind_param("ssssi", $streamgroup, $streamtitle, $streamtitle, $rsslink, $required);
      $stmt->execute();
      $stmt->close();
    }else{
      //needed to backtick because SQL doesn't like when you use reserved words
      $stmt = $db->stmt_init();
      //needed to backtick because SQL doesn't like when you use reserved words
      $sql = "UPDATE `streams` SET `group` = ?, `title` = ?, `slug` = ?, `type` = 'flipboard', `url` = ?, `required` = ? WHERE `id` = ?";
      $stmt->prepare($sql);
      $stmt->bind_param("ssssii", $streamgroup, $streamtitle, $streamtitle, $rsslink, $required, $streamid);
      $stmt->execute();
      $stmt->close();
    }
    $db->close();
  }
?>