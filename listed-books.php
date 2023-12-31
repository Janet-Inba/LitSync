<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 



    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
<link rel="icon" type="image/x-icon" href="https://assets.thestorygraph.com/assets/logo-no-text-dark-mode-c6312775a773a77605dd659850b4c0cd08db5c2044ef53a4f7b5186f8ca05f1f.png">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System |  Issued Books</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper" >
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">View Listed Books</h4>
    </div>
<!-- Tab links -->
<div style="position: relative; display: inline-flex">
<div class="tab" style="float: left; margin: 20px;">
  <button class="tablinks" onclick="openFilter(event, 'all')">All</button>
  <button class="tablinks" onclick="openFilter(event, 'available')">Available</button>
  <button class="tablinks" onclick="openFilter(event, 'search')"  id="defaultOpen">Search</button>
</div>
</div>
	


            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">Listed Books 
                        </div>
						
						
						
                         <div class="panel-body">
				
<div id="all" class="tabcontent">
<?php
$sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid,tblbooks.bookImage,tblbooks.isIssued from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<div class="col-md-4" style="float:left; height:300px;">   


                                   
                                        
<img src="admin/bookimg/<?php echo htmlentities($result->bookImage);?>" width="100">
                                                <br /><b><?php echo htmlentities($result->BookName);?></b><br />
                                                <?php echo htmlentities($result->CategoryName);?><br />
                                            <?php echo htmlentities($result->AuthorName);?><br />
                                            <?php echo htmlentities($result->ISBNNumber);?><br />
                                                <?php if($result->isIssued=='1'): ?>
<p style="color:red;">Book Already issued</p>
<?php endif;?>
                            </div>

                                <?php $cnt=$cnt+1;}} ?>  
                      
</div>
			
							
							
							
                     
<div id="available" class="tabcontent">
<?php $sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid,tblbooks.bookImage from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId WHERE tblbooks.isIssued <> 1";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<div class="col-md-4" style="float:left; height:300px;">   


                                   
                                        
<img src="admin/bookimg/<?php echo htmlentities($result->bookImage);?>" width="100">
                                                <br /><b><?php echo htmlentities($result->BookName);?></b><br />
                                                <?php echo htmlentities($result->CategoryName);?><br />
                                            <?php echo htmlentities($result->AuthorName);?><br />
                                            <?php echo htmlentities($result->ISBNNumber);?><br />
                                               
                            </div>

                                <?php $cnt=$cnt+1;}} ?>  
                      
							</div>
							
							 
<div id="search" class="tabcontent">
<div style="padding: 10px; margin: 5px;">
<form method="post" class="w3-container" id="form" role="form">
  <p style="margin: 50px; text-align: center;">
	  
  <input class="w3-input w3-animate-input" type="search" name="search" placeholder=" Search books... " style="width:50%; height: 35px; border-radius: .5rem;" value="<?php echo $_POST['search']?>">
	  
  <button class="w3-btn w3-blue" type="submit" value="Submit" style="margin-left: 5px " name="submit" >Search</button>

	  
	</p>
	  <div style="margin: auto; width: 70%; text-align: center; cursor: pointer; "><span style="text-decoration: underline; color: blue" onclick="advsearch()">Advanced search</span>
<div id="myDIV" style="margin-bottom: 30px; align-content: center;"> 
	<form action="" method="post">
		
    <div class = "searchfilter">
	<input id="title" type="radio" name="by"  value="title" />
	<label for="title">title</label>
	</div>
	
	<div class = "searchfilter" >
    <input id="category" type="radio" name="by" value="category" />
	<label for="category">category</label>
	</span>
		  
	<div class = "searchfilter">
	<input  id="author" type="radio" name="by" value="author" />
	<label for="author">author</label>
	</div>
		
	<div class = "searchfilter">
	<input id="isbn" type="radio" name="by" value="isbn" />
	<label for="isbn">isbn</label>
	</div>
							 
    </form>
</div>
	</div>
	
	
</form>	
</div>
							 
 <?php 
		

	if(isset($_POST['submit']))
    {
		$search = $_POST['search'];
        $by = $_POST['by'];

  
        if($by =="title") {
          $sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid,tblbooks.bookImage, tblbooks.isIssued from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId WHERE tblbooks.BookName LIKE '%$search%'";
        }
        else if($by == "category") {
          $sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid,tblbooks.bookImage, tblbooks.isIssued from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId WHERE tblcategory.CategoryName LIKE '%$search%'";
        }
        else if($by == "author") {
          $sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid,tblbooks.bookImage, tblbooks.isIssued from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId WHERE tblauthors.AuthorName LIKE '%$search%'";
        }
        else if($by == "isbn") {
          $sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid,tblbooks.bookImage, tblbooks.isIssued from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId WHERE tblbooks.ISBNNumber LIKE '%$search%'";
        }
		else
        $sql= "SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid,tblbooks.bookImage, tblbooks.isIssued from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId WHERE tblbooks.BookName LIKE '%$search%' OR tblcategory.CategoryName LIKE '%$search%' OR  tblauthors.AuthorName LIKE '%$search%' OR tblbooks.ISBNNumber LIKE '%$search%' " ;
	}
    
	
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<div class="col-md-4" style="float:left; height:300px; margin-top: 50px;">   


                                   
                                        
<img src="admin/bookimg/<?php echo htmlentities($result->bookImage);?>" width="100">
                                                <br /><b><?php echo htmlentities($result->BookName);?></b><br />
                                                <?php echo htmlentities($result->CategoryName);?><br />
                                            <?php echo htmlentities($result->AuthorName);?><br />
                                            <?php echo htmlentities($result->ISBNNumber);?><br />
	       <?php if($result->isIssued=='1'): ?>
<p style="color:red;">Book Already issued</p>
<?php endif;?>
                                               
                            </div>

                                <?php $cnt=$cnt+1;}}
	else {
	echo "No books found under ".$search. " ".$by;}  ?>  

                      


							
							
							
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>


            
    </div>
    </div>
    </div>

     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->			
<script>
		
function openFilter(evt, filter) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(filter).style.display = "block";
  evt.currentTarget.className += " active";

}

	
function advsearch() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
	
window.onload = advsearch();

/* to open all filter by default*/	
document.getElementById("defaultOpen").click();	
/*tab links end*/

</script>
		

    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>


</body>
</html>
<?php } ?>
