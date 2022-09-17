<?php

/**
 * autoload
 */
require __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use App\Repositories\UserRepository;
use Pa3datka\Env;

if (Env::env('DEBUG', false)) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}



try {
    $users = new UserRepository();
} catch (\Exception $e) {
    echo '<h1 style="color:red">' . $e->getMessage() . '</h1>';
    exit;
}

//UserRepository
/**
 * Get userList
 */
$userList = $users->where(['firstname' => 'Piter', ['sex' => 1], ['id', '<>', 5]])->get();
//$userList = $users->whereIn('id', [1, 2, 3, 4, 5, 6, 7])->get();
//$userList = $users->select(['id', 'firstname', 'sex'])->limit(5)->get();
//$userList = $users->select(['id', 'firstname', 'sex'])->where(['id', '<', 5])->limit(5)->get();
//
$html = '';
foreach ($userList as $user) {
    $html .= User::getHtml($user);
}

echo $html;

/**
 * Get User
 */
//$user = $users->where(['firstname' => 'Bob', ['sex' => 1], ['id', '<>', 5]])->first();
//$user = $users->select(['id', 'firstname', 'sex'])->first();
//$user = $users->select(['id', 'firstname', 'sex'])->where(['id', '<', 5])->first();
//if ($user) {
//    echo User::getHtml($user);
//}


//UserModel
/**
 * create user 1 option
 */
//$user = new User();
//$user->firstname = 'Aleksei';
//$user->lastname = 'Reut';
//$user->sex = 1;
//$user->motherland = 'Minsk';
//$user->date_birth = 624178492;
//$user->create();

/**
 * create user 2 option
 */
//$user = new User([
//    'firstname' => 'Ivan',
//    'lastname' => 'Ivanov',
//    'sex' => 1,
//    'motherland' => 'Kiev',
//    'date_birth' => 939711292
//]);
//$user->create();
/**
 * Delete user
 */
//$user->delete();

/**
 * Update user
 */
//$user->lastname = 'Bobik';
//$user->update();

/**
 * Show Age
 */
//$user->getAge();

/**
 * Show sex
 */
//$user->getSex();

