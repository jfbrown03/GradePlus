<?php
session_start();
$success = 0;
$error = 0;
if (isset($_SESSION['logtime']) && isset($_SESSION['username'])) {
    if ($_SESSION['logtime'] > time()) {
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $email = $_SESSION['email'];
            $_SESSION['logtime'] = time() + (60 * 6);
            try {
                $conn = mysqli_connect('localhost', 'gradeplusclient', 'gradeplussql', 'gradeplus');
                $loggedin = 1;
                $sqlUpdate = $conn->prepare("UPDATE login SET loggedin = ? WHERE username = ?");
                $sqlUpdate->bind_param("is", $loggedin, $username);
                $sqlUpdate->execute();
                $success = 1;
                $sqlUpdate->close();
                $conn->close();
            } catch (exception $e) {
                $error = 1;
            }
        }
    } else {
        header('Location: login.php');
        session_unset();
    }
} else {
    header('Location: login.php');
    session_unset();
}

//User Type
$usertype = $_SESSION['usertype'];

//Courses Data
$courses = [];
?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/styles-account.css">
    <link rel="stylesheet" type="text/css" href="css/account-settings.css">
    <title>GradePlus - Dashboard</title>
    <link rel="icon" href="img/logoGreen.png">
</head>

<body class="white-text">
    <?php include("loader.php"); ?>
    <div class="mainapp">
        <?php include("header.php"); ?>
        <img src="img/loginback.png" class="indexback">
        <img src="img/loginbackdark.png" class="indexback2">
        <!-- Side Nav -->
        <ul id="slide-out" class="side-nav bwcolor sidenav-fixed">
            <img class="side-nav-img" style="height: 10rem; object-fit: cover; filter: brightness(0.5);">
            <p class="side-nav-course-code">Loading</p>
            <p class="side-nav-course-invite">Loading</p>
            <li><a class="side-nav-item bwcolor assignments"><i class="material-icons">assignment</i>Assignments</a>
            </li>
            <li><a class="side-nav-item bwcolor grades"><i class="material-icons">bar_chart</i>Grades</a></li>
            <li><a class="side-nav-item bwcolor peer-reviews"><i class="material-icons">reviews</i>Peer Reviews</a></li>
            <li><a class="side-nav-item bwcolor discussions"><i class="material-icons">chat</i>Discussions</a></li>
            <li><a class="side-nav-item bwcolor classlist"><i class="material-icons">group</i>Classlist</a></li>
            <li><a class="side-nav-item bwcolor csettings"><i class="material-icons">settings</i>Course Settings</a>
            </li>
            <div style="flex-grow: 1;"></div>
            <li><a class="waves-effect green std-hover waves-light btn backuserdashboard"
                    style="position: relative; bottom: 4rem;"><i class="material-icons left">arrow_back</i>BACK TO
                    DASHBOARD</a></li>
        </ul>
        <!-- Course Dashboard -->
        <div class="coursedash">
            <div style="width: 20rem"></div>
            <div class="coursedash-holder bwcolortext">
                <h3 class="coursedash-header">
                    Assignments
                </h3>
                <div class="coursedash-content">
                    <p>Not Implemented Yet</p>
                </div>
            </div>
        </div>
        <div class="courseholder bwcolortext">
            <!-- Top Info -->
            <div class="top-icon-holder">
                <i class="material-symbols-outlined accounticon">account_circle</i>
                <div class="top-info-holder">
                    <h2 class="top-info-header">
                        Welcome
                        <span
                            class="display-name"><?php echo $_SESSION['dname'];?></span>!
                        <span class="user-name"
                            style="display: none;"><?php echo $_SESSION['username'];?></span>
                    </h2>
                    <p class="accountemail">
                        <?php echo $_SESSION['email']; ?>
                    </p>
                </div>
            </div>
            <!-- Account Settings -->
            <div class="account-settings">
                <div class="account-item">
                    <div class="account-item-text">
                        <h4>Account Settings</h4>
                        <p>Display Name:
                            <span
                                class="display-name"><?php echo $_SESSION['dname'];?></span>
                        </p>
                        <p>Profile Picture: </p>
                        <img src="img/Superman.png" alt="Profile Picture" class="profile-pic">
                        <p>Account Email:
                            <?php echo $_SESSION['email']; ?>
                        </p>
                        <p>Account Password:
                            <?php echo isset($_SESSION['password']) ? $_SESSION['password'] : 'Password Not Found'; ?>
                        </p>
                        <button class="waves-effect green std-hover waves-light btn edit-account-settings-btn">Edit
                            Account Settings</button>
                    </div>
                </div>
                <div class="update-form" id="account-settings" style="display: none;">
                    <p>New Display Name:</p>
                    <input type="text" id="new-display-name" placeholder="New Display Name"
                        value="<?php echo $_SESSION['dname']; ?>">
                    <p>New Profile Picture:</p>
                    <input type="file" id="new-profile-pic" accept="image/*">
                    <p>New Account Email:</p>
                    <input type="email" id="new-account-email" placeholder="New Email"
                        value="<?php echo $_SESSION['email']; ?>">
                    <p>New Account Password:</p>
                    <input type="password" id="new-account-password" placeholder="New Password"
                        value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>">
                    <div class="update-form-actions">
                        <a class="waves-effect green std-hover waves-light btn save-btn">Save</a>
                        <a class="waves-effect red std-hover waves-light btn return-btn">Return</a>
                    </div>
                </div>
                <div class="delete-account-item">
                    <button class="delete-account-btn waves-effect red std-hover waves-light btn delete-account-btn"><i
                            class="material-icons left">warning</i>Delete
                        Account</button>
                </div>
                <div class="delete-account-safety" id="account-settings" style="display: none;">
                    <p>Are you sure you want to delete your account?</p>
                    <div class="delete-account-form-actions">
                        <a class="waves-effect red std-hover waves-light btn delete-account-confirm-btn">Yes, delete my
                            account </a>
                        <a class="waves-effect green std-hover waves-light btn delete-account-cancel-btn">No</a>
                    </div>
                </div>
                <br>
                <a class="waves-effect green std-hover waves-light btn account-settings-back"><i
                        class="material-icons left">arrow_back</i>BACK TO DASHBOARD</a>
            </div>
            <!-- Add or Enrol Modals -->
            <div class="modal bwcolor">
                <div class="modal-content">
                    <h4 style="margin-bottom: 1.5rem;">Loading</h4>
                    <p class="status-text"></p>
                    <div class="modal-addenrol-holder">
                        <div class="input-field course-code">
                            <i class="material-icons prefix">key</i>
                            <input id="coursecode" name="coursecode" type="text">
                            <label for="coursecode">Course Code</label>
                        </div>
                        <!--Instructors Only -->
                        <div class="input-field course-name">
                            <i class="material-symbols-outlined prefix">import_contacts</i>
                            <input id="coursename" name="coursename" type="text">
                            <label for="coursename">Course Name</label>
                        </div>
                        <div class="input-field upload-banner">
                            <i class="material-symbols-outlined prefix">add_photo_alternate</i>
                            <a style="position: relative; left: 3rem; top: 0.3rem;" id="file-picker-btn"
                                class="waves-effect green white-text btn-flat">BANNER IMAGE</a>
                            <input type="file" name="coursebanner" id="coursebanner" accept="image/*" required
                                style="display: none;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bwcolor">
                    <a class="addenrol-modal-cancel waves-effect bwcolortext btn-flat">CANCEL</a>
                    <a class="addenrol-modal-add waves-effect white-text green btn-flat">ADD</a>
                    <a class="addenrol-modal-enrol waves-effect white-text green btn-flat">ENROLL</a>
                </div>
            </div>
            <!-- Course List -->
            <div class="course-list">
                <p class="course-list-head">
                    Your Courses
                </p>
                <div class="course-list-holder">
                </div>
                <a class="waves-effect green addenrolcourse std-hover waves-light btn add-enrol"
                    id=<?php echo $usertype == "Student" ? "enroltrue" : "enrolfalse"; ?>><i
                        class="material-symbols-outlined left">add_circle</i><?php echo $usertype == "Student" ? "Enroll in a Course" : "Add a Course"; ?></a>
            </div>
        </div>
        <?php include("footer.php"); ?>
</body>
<script src="js/account.js"></script>
<script src="js/theme.js"></script>