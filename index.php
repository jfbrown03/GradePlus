<?php session_start(); ?>
<html>


<?php include("header.php"); ?>

<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>GradePlus - Home</title>
    <link rel="icon" href="img/logoGreen.png">
</head>

<body class="white-text">
    <img src="img/indexback.png" class="indexback">
    <div class="container">
        <div class="holder col s12">
            <h1 class="welcome">
                <span class="welcome">Welcome</span>
            </h1>
            <div class="flow-text subhead">
                View your grades and peer reviews at one glance!
            </div>
            <a href="login.php" class="waves-effect waves-light btn-large getstarted">
                <div class="icon-holder">Get Started <i class="material-icons getarrow">arrow_forward</i></div>
            </a>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
<script src="js/theme.js"></script>
<script>
    const lang = ["Welcome", "Bienvenido", "Bienvenue", "Willkommen", "स्वागत है", "ようこそ", "환영합니다", "خوش آمدید"];
    var index = 1;
    setInterval(() => {
        $("span.welcome").fadeOut(500, function() {
            $("span.welcome").text(lang[index]).fadeIn(500);
        });
        index++;
        if (index == lang.length) {
            index = 0;
        }
    }, 5000);
</script>

</html>