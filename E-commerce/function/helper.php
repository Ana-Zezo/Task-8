<?php
if (!function_exists("pageTitle")) {
    function pageTitle()
    {
        $scriptName = $_SERVER["SCRIPT_NAME"];
        $stringToArray = explode("/", $scriptName);
        $sortedPathFile = end($stringToArray);
        $sparated = explode(".", $sortedPathFile);
        $title = $sparated[0];
        $title = ucfirst($title);
        return $title;
    }
}
if (!function_exists("active")) {
    function active()
    {
        $scriptName = $_SERVER["SCRIPT_NAME"];
        $stringToArray = explode("/", $scriptName);
        $sortedPathFile = end($stringToArray);
        return $sortedPathFile;
    }
}
if (!function_exists('dd')) {
    function dd(...$x)
    {
        echo "<pre>";
        print_r($x);
        echo "</pre>";
    }
}

if (!function_exists("checkRequest")) {
    function checkRequest($method)
    {
        if ($_SERVER["REQUEST_METHOD"] == $method) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists("redirect")) {
    function redirect($path)
    {
        return header("location:$path");
    }
}

if (!function_exists("sanitize")) {
    function sanitize($input)
    {
        return trim(htmlspecialchars(htmlentities($input)));
    }
}

if (!function_exists("requiredVal")) {
    function requiredVal($input)
    {
        if (empty($input)) {
            return true;
        } else
            return false;
    }
}

if (!function_exists("minVal")) {
    function minVal($input, $len)
    {
        if (strlen($input) < $len) {
            return true;
        } else
            return false;
    }
}
if (!function_exists("maxVal")) {
    function maxVal($input, $len)
    {
        if (strlen($input) > $len) {
            return true;
        } else
            return false;
    }
}

if (!function_exists("emailVal")) {
    function emailVal($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;
        else
            return false;
    }
}

if (!function_exists("keySession")) {
    function keySession($key, $type = "danger")
    {
        if (isset($_SESSION[$key])) {
            echo "<div class=\"alert alert-$type text-dark d-flex justify-content-between\" role=\"alert\">";
            echo $_SESSION[$key];
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php
            echo "</div>";
            unset($_SESSION[$key]);
        }
    }
}

if (!function_exists("keyAndValueSession")) {
    function keyAndValueSession($key, $value, $type = "danger")
    {
        if (isset($_SESSION[$key][$value])) {
            echo "<div class=\"alert alert-$type text-dark d-flex justify-content-between \" role=\"alert\">";
            echo $_SESSION[$key][$value];
            ?>
            <button type="button" class="btn-close " data-bs-dismiss="alert" aria-label="Close"></button>
            <?php
            echo "</div>";
            unset($_SESSION[$key][$value]);
        }
    }
}


?>