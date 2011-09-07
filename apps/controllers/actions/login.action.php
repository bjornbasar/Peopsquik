<?php

printr($_POST);

extract($_POST, EXTR_REFS);

printr($this->authenticate($username, $password));