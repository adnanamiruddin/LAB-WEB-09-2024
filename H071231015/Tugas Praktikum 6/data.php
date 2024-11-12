<?php


$users = [
    [
        'email' => 'admin@gmail.com',
        'username' => 'adminxxx',
        'name' => 'Admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
    ],
    [
        'email' => 'nanda@gmail.com',
        'username' => 'nanda_aja',
        'name' => 'Wd. Ananda Lesmono',
        'password' => password_hash('nanda123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'MIPA',
        'batch' => '2021',
    ],
    [
        'email' => 'arif@gmail.com',
        'username' => 'arif_nich',
        'name' => 'Muhammad Arief',
        'password' => password_hash('arief123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Hukum',
        'batch' => '2021',
    ],
    [
        'email' => 'eka@gmail.com',
        'username' => 'eka59',
        'name' => 'Eka Hanny',
        'password' => password_hash('eka123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'Keperawatan',
        'batch' => '2021',
    ],
    [
        'email' => 'adnan@gmail.com',
        'username' => 'adnan72',
        'name' => 'Adnan',
        'password' => password_hash('adnan123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Teknik',
        'batch' => '2020',
    ]
];



function checkLogin($emailOrUsername, $password) {
    $users = json_decode(file_get_contents('users.json'), true);
    foreach ($users as $user) {
        if (($user['email'] === $emailOrUsername || $user['username'] === $emailOrUsername)
            && password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;
}



function isLogin(){
    return isset($_SESSION['user']);
}


// function logout(){
//     session_destroy();
//     header('Location: login.php');
//     exit;
// }

function registerUser($name, $username, $email, $password, $gender, $faculty, $batch) {
    $users = json_decode(file_get_contents('users.json'), true);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $users[] = [
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'password' => $hashed_password,
        'gender' => $gender,
        'faculty' => $faculty,
        'batch' => $batch
    ];

    file_put_contents('users.json', json_encode($users));
}


function checkGoogleUser($email, $name) {
    $users = json_decode(file_get_contents('users.json'), true);
    
    $userFound = false;
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            $userFound = true;
            $_SESSION['user'] = $user;  
            break;
        }
    }

    if (!$userFound) {
        $_SESSION['new_user'] = [
            'email' => $email,
            'name' => $name
        ];
        header('Location: user_setup.php'); 
        exit;
    } else {
        header('Location: dashboard.php');
        exit;
    }
}

function updateUser($email, $username, $name, $password, $gender, $faculty, $batch) {
    $users = json_decode(file_get_contents('users.json'), true);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    foreach ($users as &$user) {
        if ($user['email'] === $email) {
            $user['username'] = $username;
            $user['name'] = $name;
            $user['password'] = $hashed_password; 
            $user['gender'] = $gender;
            $user['faculty'] = $faculty;
            $user['batch'] = $batch;
            break;
        }
    }

    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
}


function deleteUser($email) {
    $users = json_decode(file_get_contents('users.json'), true);

    foreach ($users as $index => $user) {
        if ($user['email'] === $email) {
            unset($users[$index]);
            break;
        }
    }

    file_put_contents('users.json', json_encode(array_values($users), JSON_PRETTY_PRINT));
}



