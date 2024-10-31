<?php
session_start();
unset($_SESSION['success']);
echo json_encode(['status' => 'success']);
