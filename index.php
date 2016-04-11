<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Csasbook - The Best Social Network</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/agency.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Csasbook</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Services Section -->
    <section id="recent-posts">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Recent Posts</h2>
                    <h3 class="section-subheading text-muted">See what our users talk about, and post something yourself</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <form method="post" id="commentForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" novalidate>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label" for="formGroupInputSmall">Your Message *</label>
                                    <textarea class="form-control" <?php if (isset($_GET['msg'])) { echo $_GET['msg'];} ?> name="message" required data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label" for="formGroupInputSmall">Share a Link</label>
                                    <input type="url" class="form-control" placeholder="" name="link">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label" for="formGroupInputSmall">Your Name</label>
                                    <input type="text" class="form-control" placeholder="<?php if (isset($_GET["name"])) { echo $_GET["name"];} ?>" name="commentName">
                                    <p class="help-block text-danger"></p>
                                </div>
                            <br /><p style="color: red;">* - Required Field</p><br />
                            </div>
                            <div class="col-lg-3"></div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <input type="submit" name="submit" value="Submit" class="btn btn-xl">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <br><br>

                    <?php

                        date_default_timezone_set('UTC');

                        $servername = "127.0.0.1";
                        $username = "root";
                        $password = "csas";
                        $database = "csas";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $database);

                        // Check connection
                        if ($conn->connect_error) {
                            echo $conn->connect_error;
                            die("Connection failed: " . $conn->connect_error);
                        }

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $text = $conn->real_escape_string($_POST["message"]);
                            $link = $conn->real_escape_string($_POST["link"]);
                            $date = date("M j");
                            $time = date("g:ia");

                            $sql = "INSERT INTO post (text, link) VALUES ('$text', '$link')";

                            if ($conn->query($sql) === FALSE) {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                        }

                        $sql = "SELECT text, link, date FROM post ORDER BY date DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {

                            while($row = $result->fetch_assoc()) {

                                $sqldate = $row["date"];
                                $timestamp = strtotime($sqldate);
                                $date = date("M j", $timestamp);
                                $time = date("g:ia", $timestamp);
                                $text = $row["text"];
                                $link = $row["link"];

                                if ($text) {
                                    echo "<h4 class=\"text-muted\">"; echo "$date at $time:"; echo "</h4>";
                                    echo "<p>"; echo "$text"; echo "</p>";
                                }
                                if ($link) {
                                    echo "<a href=\""; echo "$link"; echo "\">"; echo "$link"; echo "</a><br>";
                                }
                            }
                        }
                        else {
                            echo "No posts to display";
                        }

                        $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <span class="copyright">Copyright &copy; PHP CSAS <?php echo date("Y") ?></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>

</body>

</html>
