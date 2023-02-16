<?php
    session_start();
    if(isset($_SESSION["user_id"])) {
        $logged_in = true;
        $user_level = $_SESSION["user_level"];
    } else {
        header("Location: login.html");
        exit();
    }
    include_once("api/Database.php");

    $db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
    $connection = $db->get_connection();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/template.css">
        <link rel="stylesheet" href="css/admin-panel.css">
    </head>

    <body>
        <header>
            <h1 id="title-heading">
                <a href="/">School Citizen Assemblies</a>
            </h1>

            <nav id="menu">
                <svg id="close-nav" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" overflow="visible" stroke="#ddd" stroke-width="6" stroke-linecap="round">
                    <line x2="50" y2="50" />
                    <line x1="50" y2="50" />
                 </svg>

                <ul id="nav-list">
                    <li>
                        <button class="nav-button" id="about">About Us</button>
                    </li>

                    <li>
                        <button class="nav-button collapsable" id="teacher-resources">Teacher Resources</button>

                        <ul class="subnav" id="teacher-resources">
                            <li><a>Student Resources</a></li>
                            <li><a>Teacher Resources</a></li>
                            <li><a>SCA Toolkit</a></li>
                        </ul>
                    </li>

                    <li>
                        <button class="nav-button collapsable" id="mte">Meet The Experts</button>

                        <ul class="subnav" id="mte">
                            <li><a href="meet-the-experts.php">Meet The Experts</a></li>
                            <li><a href="expert-resources.php">Expert Resources</a></li>
                            <li><a href="directory.php">Directory</a></li>
                        </ul>
                    </li>

                    <?php

                    if($logged_in) {
                        echo('
                            <li>
                                <button class="nav-button collapsable" id="my-account">My Account</button>

                                <div class="subnav" id="my-account">
                        ');
                        if($user_level == "Admin") {
                            echo('<a>Admin Panel</a>');
                        } else if($user_level == "Expert") {
                            echo("<a href=\"expert-profile.php\">Profile</a>");
                        }
                        echo('
                                <a href="phpScripts/logout.php">Logout</a>
                            </div>
                        </li>
                        ');
                    } else {
                        echo('
                            <li>
                                <button class="nav-button" id="login">Login</button>
                            </li>
                        ');
                    }
                    ?>
                </ul>
            </nav>

            <svg id="burger" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
            </svg>
        </header>

        <main>
            <ul id="admin-tables">
                <li>
                    <table>
                        <tr>
                            <th class="table-heading" colspan="5">Verify Expert</th>
                        </tr>

<!--                        <tr id="0">
                            <td>name</td>
                            <td>about</td>
                            <td>job @ org</td>
                            <td>
                                <button class="table-button verify-expert">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.6907 4.8866C21.5876 3.54639 20.5567 2.41237 19.1134 2.30928C17.0515 2.10309 14.1649 2 12 2C9.83505 2 6.94845 2.10309 4.8866 2.30928C4.16495 2.30928 3.54639 2.61856 3.13402 3.13402C2.72165 3.64948 2.41237 4.16495 2.30928 4.8866C2.10309 6.94845 2 9.83505 2 12C2 14.1649 2.20619 17.0515 2.30928 19.1134C2.41237 20.4536 3.4433 21.5876 4.8866 21.6907C6.94845 21.8969 9.83505 22 12 22C14.1649 22 17.0515 21.7938 19.1134 21.6907C20.4536 21.5876 21.5876 20.5567 21.6907 19.1134C21.8969 17.0515 22 14.1649 22 12C22 9.83505 21.8969 6.94845 21.6907 4.8866ZM15.6082 10.4536L11.4845 14.5773C11.2783 14.6804 11.1753 14.7835 10.9691 14.7835C10.7629 14.7835 10.5567 14.6804 10.4536 14.5773L8.39175 12.5155C8.08247 12.2062 8.08247 11.6907 8.39175 11.3814C8.70103 11.0722 9.21649 11.0722 9.52577 11.3814L11.0722 12.9278L14.6804 9.31959C14.9897 9.01031 15.5052 9.01031 15.8144 9.31959C15.9175 9.73196 15.9175 10.1443 15.6082 10.4536Z" fill="#00aa00"/>
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button class="table-button decline-expert">
                                    <svg width="24px" height="24px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2.939 12.789L10 11.729l-3.061 3.06-1.729-1.728L8.271 10l-3.06-3.061L6.94 5.21 10 8.271l3.059-3.061 1.729 1.729L11.729 10l3.06 3.061-1.728 1.728z", fill="#ff0000"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
-->

                        <?php   
                            // user_id, name, about, job_title, organisation
                            $statement = $connection->prepare("SELECT user_id, name, job_title, organisation FROM Expert WHERE admin_verified=0");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                            while(count($result) > 0) {
                                $expert = array_pop($result);

                                $user_id = $expert["user_id"];
                                $name = $expert["name"];
                                $about = $expert["about"];
                                $role = $expert["job_title"] . " @ " . $expert["organisation"];

                                echo("
                                    <tr id=$user_id>
                                        <td>$name</td>
                                        <td>$about</td>
                                        <td>$role</td>
                                        <td>
                                            <button class=\"table-button verify-expert\">
                                                <svg width=\"24px\" height=\"24px\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                                                    <path d=\"M21.6907 4.8866C21.5876 3.54639 20.5567 2.41237 19.1134 2.30928C17.0515 2.10309 14.1649 2 12 2C9.83505 2 6.94845 2.10309 4.8866 2.30928C4.16495 2.30928 3.54639 2.61856 3.13402 3.13402C2.72165 3.64948 2.41237 4.16495 2.30928 4.8866C2.10309 6.94845 2 9.83505 2 12C2 14.1649 2.20619 17.0515 2.30928 19.1134C2.41237 20.4536 3.4433 21.5876 4.8866 21.6907C6.94845 21.8969 9.83505 22 12 22C14.1649 22 17.0515 21.7938 19.1134 21.6907C20.4536 21.5876 21.5876 20.5567 21.6907 19.1134C21.8969 17.0515 22 14.1649 22 12C22 9.83505 21.8969 6.94845 21.6907 4.8866ZM15.6082 10.4536L11.4845 14.5773C11.2783 14.6804 11.1753 14.7835 10.9691 14.7835C10.7629 14.7835 10.5567 14.6804 10.4536 14.5773L8.39175 12.5155C8.08247 12.2062 8.08247 11.6907 8.39175 11.3814C8.70103 11.0722 9.21649 11.0722 9.52577 11.3814L11.0722 12.9278L14.6804 9.31959C14.9897 9.01031 15.5052 9.01031 15.8144 9.31959C15.9175 9.73196 15.9175 10.1443 15.6082 10.4536Z\" fill=\"#00aa00\"/>
                                                </svg>
                                            </button>
                                        </td>
                                        <td>
                                            <button class=\"table-button decline-expert\">
                                                <svg width=\"24px\" height=\"24px\" viewBox=\"0 0 20 20\" xmlns=\"http://www.w3.org/2000/svg\">
                                                    <path d=\"M16 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2.939 12.789L10 11.729l-3.061 3.06-1.729-1.728L8.271 10l-3.06-3.061L6.94 5.21 10 8.271l3.059-3.061 1.729 1.729L11.729 10l3.06 3.061-1.728 1.728z\", fill=\"#ff0000\"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                ");
                            }
                        ?>
                    </table>
                </li>

                <li>
                    <table>
                        <tr>
                            <th class="table-heading" colspan="4">Current Experts</th>
                        </tr>

                        <tr id="0">
                            <td>name</td>
                            <td>about</td>
                            <td>job @ org</td>
                            <td>
                                <button class="table-button remove-expert">
                                    <svg width="24px" height="24px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2.939 12.789L10 11.729l-3.061 3.06-1.729-1.728L8.271 10l-3.06-3.061L6.94 5.21 10 8.271l3.059-3.061 1.729 1.729L11.729 10l3.06 3.061-1.728 1.728z", fill="#ff0000"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </table>
                </li>

                <li>
                    <table>
                        <tr>
                            <th class="table-heading" colspan="4">Current Admins</th>
                        </tr>

                        <tr id="0">
                            <td>email</td>
                            <td>
                                <button class="table-button remove-admin">
                                    <svg width="24px" height="24px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2.939 12.789L10 11.729l-3.061 3.06-1.729-1.728L8.271 10l-3.06-3.061L6.94 5.21 10 8.271l3.059-3.061 1.729 1.729L11.729 10l3.06 3.061-1.728 1.728z", fill="#ff0000"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </table>

                    <div id="new-admin">
                        <h2 id="new-admin">Add a new admin: </h2>
                        <input type="email" placeholder="New admin email" id="new-admin-entry">
                        <button id="new-admin-submit">Go</button>
                    </div>
                </li>
            </ul>
        </main>

        <footer>
            <h2>© School Citizen Assemblies</h2>

            <p>support@schoolcitizenassemblies.org</p>
        </footer>

        <script src="javascript/header.js"></script>
        <script src="javascript/admin-panel.js"></script>
    </body>
</html>