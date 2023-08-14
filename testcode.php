<?php

/**
* @Author: Dennis L.
* @Test: 1
* @TimeLimit: 5 minutes
* @Testng: Reflection
* @Task: Make $mySecret public using Reflection.
*/
/* Please write some code to output the secret. You cannot adjust the visibility of the
variable. */
final class ReflectionTest {
    private $mySecret = 'I have 99 problems. This isn\'t one of them.';
}

// Add your code here.
$class = new ReflectionClass("ReflectionTest");
$property = $class->getProperty("mySecret");
$property->setAccessible(true);

$obj = new ReflectionTest();
echo $property->getValue($obj);


echo '<br/><br/><br/>';
/**
* @Author: Dennis L.
* @Test: 2
* @TimeLimit: 10 minutes
* @Testng: Closures
*/
var_dump(changeDateFormat(array("2010/03/30", "15/12/2016", "11-15-2012","20130720")));

/**
* When this method runs, it should return valid dates in the following format:
DD/MM/YYYY.
*/

function changeDateFormat(array $dates): array
{
   
    $listOfDates = [];
    $closure = [];
    // Add code here

    foreach($dates as $k)
    {
        if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/",$k))
        {
            $listOfDates[] =  $k;
        }    
    }
    
    /* NOTE: array_map function should have callback function as 1st parameter, here array given */

    // Don't edit anything else!
    //array_map($closure, $dates);
    return $listOfDates;
}


/**
* @Author: Dennis L.
* @Test: 3
* @TimeLimit: 15 minutes
* @Testing: Recursion
*/
$count = 0;
function numberOfItems(array $arr, string $needle): int
{
// Write some code to tell me how many of my selected fruit is in these lovely nested arrays.
    
    foreach($arr as $k=>$v)
    {
        if($v == $needle)
        {
            global $count;
            $count++;
        }
        else
        {
            if(is_array($v))
            {   
                numberOfItems($v, $needle);               
            }
        }       
    }

    return $count;
    
}
$arr = ['apple', ['banana', 'strawberry', 'apple', ['banana', 'strawberry', 'apple']]];
echo numberOfItems($arr, 'apple') . PHP_EOL;



/**
* @Author: Dennis L.
* @Test: 4
* @TimeLimit: 30 minutes
* @Testng: Input Sanitation
*/
// Fix this so there are no SQL Injection asacks, no chance for a man-in-the-middle attack (e.g., use something to determine if the input was changed), and limit the chances of
// brute-forcing this credential system to gain entry. Feel free to change any part of this code.

if(!isset($_POST['username']) || !isset($_POST['password']){ 
    return $message = 'Username and Password both are required.';
}
else
{

    if(is_empty($_POST['username'])|| is_empty($_POST['password']))
    {
        return $message = 'Username and Password both are required.';
    }
    else
    { 
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }
}

$password = md5($password);

$pdo = new PDO('sqlite::memory:');
$pdo->setAsribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$pdo->exec("DROP TABLE IF EXISTS users");
$pdo->exec("CREATE TABLE users (username VARCHAR(255), password VARCHAR(255))");

$rootPassword = md5("secret");

$sql = "INSERT INTO users (username, password) VALUES (?,?)";
$stmt= $pdo->prepare($sql);
$stmt->execute(['root', $rootPassword]);

$statement = $pdo->query("SELECT * FROM users WHERE username = :username AND password = :password ");
$statement->exe( array(':username' => $username));
$statement->exe( array(':password' => $password));


if (count($statement->fetchAll())) {
echo "Access granted to $username!<br>\n";
} else {
echo "Access denied for $username!<br>\n";
}
