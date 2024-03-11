<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $UserName = $_POST['UserName'];
        $owneremail = $_POST['owneremail'];
        $ownerphone = $_POST['ownerphone'];
        $owneraddress = $_POST['owneraddress'];
        $ownerpassword = md5($_POST['ownerpassword']);
        
        // Validate and sanitize input as needed
        
        $ownerid = $_GET['id'];
        
        $sql = "UPDATE tblowner SET UserName = :UserName, email = :owneremail, phone = :ownerphone, address = :owneraddress, Password = :ownerpassword WHERE id = :ownerid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':UserName', $UserName, PDO::PARAM_STR);
        $query->bindParam(':owneremail', $owneremail, PDO::PARAM_STR);
        $query->bindParam(':ownerphone', $ownerphone, PDO::PARAM_STR);
        $query->bindParam(':owneraddress', $owneraddress, PDO::PARAM_STR);
        $query->bindParam(':ownerpassword', $ownerpassword, PDO::PARAM_STR);
        $query->bindParam(':ownerid', $ownerid, PDO::PARAM_INT);
        $query->execute();

        $msg = "Owner details updated successfully";
        header('location:manage-owner.php');
    }
    
    // Fetch owner details for editing
    $ownerid = $_GET['id'];
    $sql = "SELECT * FROM tblowner WHERE id = :ownerid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':ownerid', $ownerid, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
}

?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <!-- Font awesome -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- Sandstone Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap Datatables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<!-- Bootstrap social button library -->
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<!-- Bootstrap select -->
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<!-- Bootstrap file input -->
		<link rel="stylesheet" href="css/fileinput.min.css">
		<!-- Awesome Bootstrap checkbox -->
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
		<!-- Admin Stye -->
		<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Edit Owner</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Owner Details</div>
                                    <?php if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div><?php } ?>
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Owner Name<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="UserName" class="form-control" value="<?php echo htmlentities($result['UserName']); ?>" required>
                                                </div>
                                                <label class="col-sm-2 control-label" >Owner Email<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="email" name="owneremail" class="form-control" value="<?php echo htmlentities($result['email']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Owner Phone<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="ownerphone" class="form-control" value="<?php echo htmlentities($result['phone']); ?>" required>
                                                </div>
                                                <label class="col-sm-2 control-label">Owner Address<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="owneraddress" class="form-control" value="<?php echo htmlentities($result['address']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Password<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="password" name="ownerpassword" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <button class="btn btn-default" type="reset">Cancel</button>
                                                    <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Loading Scripts -->
    <!-- Loading Scripts -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-select.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>
		<script src="js/Chart.min.js"></script>
		<script src="js/fileinput.js"></script>
		<script src="js/chartData.js"></script>
		<script src="js/main.js"></script>
    <!-- Scripts -->
</body>
</html>
