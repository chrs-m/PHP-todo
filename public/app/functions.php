<?php

declare(strict_types=1);

// Redirect function
/**
 * @param string $path
 * @return never
 */
function redirect(string $path)
{
    header("Location: ${path}");

    exit;
}


// Checks if user is logged in
/** @return bool  */
function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

if (isLoggedIn()) {
    $user = $_SESSION['user'];
}
