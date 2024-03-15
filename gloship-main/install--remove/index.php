<?php
error_reporting(0);

function Extension_Enabled($extname)
{
    if (!extension_loaded($extname)) {
        $return = false;
    } else {
        $return = true;
    }
    return $return;
}
// Extensions Required
$required_extensions = [
    'PDO', 'pdo_mysql', 'BCMath', 'Ctype', 'Fileinfo', 'JSON', 'Mbstring', 'OpenSSL', 'Tokenizer', 'XML', 'cURL',  'GD'
];

function table_rows($name, $details, $status)
{
    if ($status == '1') {
        $pr = '<span class="text-success p-2"><i class="fas fa-check-circle text-success"></i></span>';
    } else {
        $pr = '<span class="text-danger p-2"><i class="fas fa-times-circle text-danger"></i></span>';
    }
    echo "<tr><td>$name</td><td class='p-1'>$details</td><td>$pr</td></tr>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecourier Installer</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/install.css">
    <link rel="shortcut icon" href="assets/favicon.png"
        type="image/x-icon">
</head>

<body>

    <div class="container-section">

        <div class="card">
            <div class="form">
                <div class="left-side">
                    <div class="left-heading">
                        <h3>Ecourier Installer</h3>
                    </div>
                    <div class="steps-content">
                        <h3>Step <span class="step-number">1</span></h3>
                        <p class="step-number-content active">Checking your server information.</p>
                    </div>
                    <ul class="progress-bar-section">
                        <li class="active">Server Requirements</li>
                        <li>File System</li>
                        <li>Database Details</li>
                        <li>System Options</li>
                        <li>Admin Credentials</li>
                        <li>Installation</li>
                        <li>Complete</li>
                    </ul>
                </div>

                <div class="right-side">
                    <div class="text-center p-2 no-desktop">
                        <img src="assets/logo.png" alt="Ecourier" class="img-fluid" style="max-height: 120px;">
                        <h3 class="card-titl"> Welcome to Ecourier Installer</h3>
                        <hr>
                    </div>
                    <div class="main active" id="step1">
                        <small><i class="fa fa-question-circle"></i></small>
                        <div class="text">
                            <h2>Server Requirements</h2>
                            <p>Checking your server configurations.</p>
                        </div>
                        <table>
                            <?php
                            $errors = 0;
                            $php_version = version_compare(PHP_VERSION, '8.1', '>=');
                            if ($php_version == true) {
                                $errors = $errors + 0;
                                table_rows("PHP", "Required PHP version 8.1 or higher", 1);
                            } else {
                                $errors = $errors + 1;
                                $disable = 'disabled';
                                table_rows("PHP", "Required PHP version 8.1 or higher", 0);
                            }
                            foreach ($required_extensions as $key) {
                                $extension = Extension_Enabled($key);
                                if ($extension == true) {
                                    table_rows($key, "Required " . strtoupper($key) . " PHP Extension", 1);
                                } else {
                                    $errors += 1;
                                    $disable = 'disabled';
                                    table_rows($key, "Required " . strtoupper($key) . " PHP Extension", 0);
                                }
                            }

                            ?>
                        </table>

                        <div class="buttons mt-5">
                            <button class="next_button step1" data-current="1" <?= $disable ?>>Next Step <span class="fa fa-chevron-circle-right"></span></button>
                        </div>
                    </div>

                    <div class="main" id="step2">
                        <small><i class="fa fa-folder"></i></small>
                        <div class="text">
                            <h2>File System</h2>
                            <p>Checking your server File System.</p>
                        </div>
                        <table>
                            <?php
                            $errors = 0;
                            if (file_exists('../app')) {
                                $errors = $errors + 0;
                                table_rows('App', ' Required "app" found', 1);
                            } else {
                                $errors = $errors + 1;
                                $disable = 'disabled';
                                table_rows('App', ' Required "app" not found', 0);
                            }
                            if (file_exists('../config')) {
                                $errors = $errors + 0;
                                table_rows('Config', ' Required "config" found', 1);
                            } else {
                                $errors = $errors + 1;
                                $disable = 'disabled';
                                table_rows('Config', ' Required "config" not found', 0);
                            }
                            if (file_exists('../storage')) {
                                $errors = $errors + 0;
                                table_rows('Storage', ' Required "storage" found', 1);
                            } else {
                                $errors = $errors + 1;
                                $disable = 'disabled';
                                table_rows('Storage', ' Required "storage" not found', 0);
                            }
                            
                            if (file_exists('../.htaccess')) {
                                $errors = $errors + 0;
                                table_rows('.htaccess', '  Required ".htaccess" found', 1);
                            } else {
                                $errors = $errors + 1;
                                $disable = 'disabled';
                                table_rows('.htaccess', ' Required ".htaccess" not found', 0);
                            }

                            if (file_exists('database/database.sql')) {
                                $errors = $errors + 0;
                                table_rows('Database', ' Required "database.sql" found', 1);
                            } else {
                                $errors = $errors + 1;
                                $disable = 'disabled';
                                table_rows('Database', ' Required "database.sql" not found', 0);
                            }
                           
                            ?>
                        </table>

                        <div class="buttons button_space mt-4">
                            <button class="back_button"><span class="fa fa-chevron-circle-left"></span> Back</button>
                            <button class="next_button" data-current="2" <?= $disable ?>>Next Step <span class="fa fa-chevron-circle-right"></span> </button>
                        </div>
                    </div>

                    <div class="main" id="step3">
                        <small><i class="fa fa-database"></i></small>
                        <div class="text">
                            <h2>Database Details</h2>
                            <p>Please enter your database details below.</p>
                        </div>
                        <div class="input-text">
                            <div class="input-div">
                                <input type="text" name="db_host" value="localhost" require>
                                <span>Database Host</span>
                            </div>
                        </div>
                        <div class="input-text">
                            <div class="input-div">
                                <input type="text" name="db_name" require>
                                <span>Database Name</span>
                            </div>
                        </div>
                        <div class="input-text">
                            <div class="input-div">
                                <input type="text" name="db_user" require>
                                <span>Database User</span>
                            </div>
                        </div>
                        <div class="input-text">
                            <div class="input-div">
                                <input type="text" name="db_pass" require>
                                <span>Database Password</span>
                            </div>
                        </div>

                        <div id="database_error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="buttons button_space">
                            <button class="back_button"><span class="fa fa-chevron-circle-left"></span> Back</button>
                            <button class="next_button" data-current="3">Next Step <span class="fa fa-chevron-circle-right"></span></button>
                        </div>
                    </div>

                    <div class="main" id="step4">
                        <small><i class="fa fa-language"></i></small>
                        <div class="text">
                            <h2>System Options</h2>
                            <p>Set default system options</p>
                        </div>

                        <div class="input-text">
                            <div class="input-div">
                                <select name="locale">
                                    <option value="en">English</option>
                                    <option value="fr">French</option>
                                    <option value="es">Spanish</option>
                                </select>

                            </div>
                        </div>
                        <div class="input-text">
                            <div class="input-div">
                                <input type="checkbox" name="states" checked>
                                <label>Import Locations(States) - Recommended</label>
                            </div>
                        </div>
                        <div class="input-text">
                            <div class="input-div">
                                <input type="checkbox" name="cities" checked>
                                <label>Import Locations(Cities) - Recommended</label>
                            </div>
                        </div>
                        <div class="buttons button_space">
                            <button class="back_button"><span class="fa fa-chevron-circle-"></span> Back</button>
                            <button class="next_button" data-current="4">Next Step <span class="fa fa-chevron-circle-right"></span></button>
                        </div>
                    </div>

                    <div class="main" id="step5">
                        <small><i class="fa fa-user"></i></small>
                        <div class="text">
                            <h2>Admin Credentials</h2>
                            <p>Please enter your administrative details below</p>
                        </div>
                        <div class="input-text">
                            <div class="input-div">
                                <input type="text" name="firstname" require>
                                <span>First Name</span>
                            </div>
                            <div class="input-div">
                                <input type="text" name="lastname" require>
                                <span>Last Name</span>
                            </div>
                        </div>
                        <div class="input-text">
                            <div class="input-div">
                                <input type="text" name="email" require>
                                <span>Email</span>
                            </div>
                        </div>

                        <div class="buttons button_space">
                            <button class="back_button"><span class="fa fa-chevron-circle-left"></span> Back</button>
                            <button class="next_button" data-current="5">Next Step <span class="fa fa-chevron-circle-right"></span></button>
                        </div>
                    </div>

                    <div class="main" id="step6">
                        <small><i class="fa fa-smile"></i></small>
                        <div class="text">
                            <h2>Installation</h2>
                            <p>You're good to go, Please "Install" to begin installation...</p>
                        </div>

                        <div class="text">
                            <p class="text-dark">Checking System Requirements... <span class="text-success p-2"><i class="fas fa-check-circle"></i></span></p>
                            <p class="text-dark">Checking File System... <span class="text-success p-2"><i class="fas fa-check-circle"></i></span></p>
                            <p class="text-dark">Checking Database Details... <span class="text-success p-2"><i class="fas fa-check-circle"></i></span></p>
                            <p class="text-dark">Checking Admin Credentials... <span class="text-success p-2"><i class="fas fa-check-circle"></i></span></p>
                        </div>
                        <div class="form-group mb-3">
                            <p class="text-primary" id="installing" style="display: none;">
                             <span>Installing...</span>
                               <span class="mt-2">Please wait...</span>
                            </p>
                            
                        </div>
                        <div id="install_error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                        </div>
                        <div class="buttons button_space">
                            <button class="back_button"><span class="fa fa-chevron-circle-left"></span> Back</button>
                            <button type="submit" class="submit_button" data-current="6">Install <span class="fa fa-check-circle"></span></button>
                        </div>
                    </div>
                    <div class="main" id="step7">
                        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                        </svg>

                        <div class="text congrats">
                            <h2>Congratulations!</h2>
                            <div id="install_success"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="assets/jquery-3.6.1.min.js"></script>
    <script src="assets/install.js"></script>
</body>

</html>