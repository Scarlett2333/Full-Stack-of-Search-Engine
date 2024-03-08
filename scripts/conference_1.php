<!DOCTYPE html> 
<html>
<head>
<title>Conference page example</title>
<style type="text/css">
	body {
		text-align: center;
	}
</style>
<style type="text/css">
a:link{color:black;}
a:visited{color:red;}
a:hover{color:pink;}
a:active{color:#ccc;}
    a{text-decoration: none;
    width:140px;
    height:40px;
    padding:1px;
    border: none;
    background:yellow;
        border-radius: 8px;}
    table {
        border-collapse: collapse;
    width: 1000px;
    height: 40px;
        font-size: 18px;
        text-align: center;
    margin: 10px auto;
    }
    
    table caption {
        font-size: 2rem;
        font-weight: bolder;
    color: #666;
        margin-bottom: 20px;
    }
    
    table, th, td {
    border: 1.3px solid #666;
        
    }
    
    table tr:first-child {
    color: white;
        background-color: black;
        
    }
    
    table tr:hover {
        background-color: #efefef;
    color: coral;
    }
    
    table tr td img {
    padding: 5px;
        border-radius: 10px;
    }
    
    table tr td a {
        text-decoration: none;
    width:140px;
    height:40px;
    padding:1px;
    border: none;
    background: none;
        border-radius: 8px;
    }
    
    table tr td a:hover {
    background: #CDDC39;
    color:white;
    }
    
    </style>
    <title>author page example</title>
    <style type="text/css">
    body {
        text-align: center;
    }
    </style>
    

<!-- new -->

</style>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 

<script type="text/javascript" src='echarts.min.js'></script>

<!-- new -->

</head>

<body>
	<h1>Conference Page</h1>


	<?php
		


		$conf_id = $_GET["conf_id"];
		$link = mysqli_connect("localhost:3306", 'root', 's7gubmna', 'Lab_1');


		$conf_info = mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceName from Conferences where ConferenceID='$conf_id'"));
		$conf_name = $conf_info['ConferenceName'];

		$result = mysqli_query($link, "SELECT PaperID,Title,PaperPublishYear from papers where ConferenceID='$conf_id' order by PaperPublishYear DESC");
		$total=mysqli_num_rows($result);
		echo "resultAmount:$total";
		?>

		<style>
				.dropbtn {
				    background-color: white;
				    color: #4CAF50;
				    padding: 6px;
				    font-size: 16px;
				    border: none;
				    cursor: pointer;
				}

				.dropdown {
				    position: relative;
				    display: inline-block;
				}

				.dropdown-content {
				    display: none;
				    position: absolute;
				    background-color: #f9f9f9;
				    min-width: 160px;
				    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
				}

				.dropdown-content a {
				    color: black;
				    padding: 12px 6px;
				    text-decoration: none;
				    display: block;
				}

				.dropdown-content a:hover {background-color: #f1f1f1}

				.dropdown:hover .dropdown-content {
				    display: block;
				}

				.dropdown:hover .dropbtn {
				    background-color: #3e8e41;
				}
				</style>
				</head>
				<body>
				<br>
				Ranking:
				<div class="dropdown">
				  <button class="dropbtn">Order by PaperPublishYear(DESC)</button>
				  <div class="dropdown-content">
				  	<a href="conference_0.php?conf_id=<?php echo $conf_id?>">Order by PaperPublishYear(ASC)</a>
				    <a href="conference_1.php?conf_id=<?php echo $conf_id?>">Order by PaperPublishYear(DESC)</a>
				    <a href="conference_2.php?conf_id=<?php echo $conf_id?>">Order by Title(ASC)</a>
				    <a href="conference_3.php?conf_id=<?php echo $conf_id?>">Order by Title(DESC)</a>
				  </div>
				</div>

		<?php
		//new
		$data_year = array();
		//new



		$times=1;
		$page=1;
		if ($result) {
		 	echo "<table width=\"100%\" border=\"1\"><tr><th>Title</th><th>Authors</th><th>PaperPublishYear</th><th>References</th></tr>";
		 	while ($row = mysqli_fetch_array($result)){
		 		
		 		$title = $row['Title'];
		 		$paper_id = $row['PaperID'];
		 		$year = $row['PaperPublishYear'];

		 		//new
				array_push($data_year, $year);				
				//new


		 		if ($times<=10){
                echo "<tr>";
                $times=$times+1;

		 		echo "<td><a href=\"paper.php?paper_id=$paper_id\">$title; </a></td>";

		 		
		 		echo "<td>";
	            $result2 = mysqli_query($link,"SELECT AuthorID from paper_author_affiliation WHERE PaperID = '$paper_id' ORDER BY AuthorSequence");
	            if($result2){
	            while ($row2 = mysqli_fetch_array($result2))
	            {
	                $author_id = $row2[0];
	                $author_info = mysqli_fetch_array(mysqli_query($link,"SELECT AuthorName FROM authors WHERE AuthorID = '$author_id'"));
	                echo "<a href=\"author.php?author_id=$author_id\">$author_info[0]; </a>";
	            }
	            echo "</td>";
				
	            echo "<td>";
				echo "$year";
				echo "</td>";

				$result3 = mysqli_query($link, "SELECT ReferenceID FROM paper_reference where PaperID = $paper_id");
				if ($result3){
					$refe_info = mysqli_fetch_array($result3);
					echo "<td>";
					$refe_num = mysqli_num_rows($result3);
					echo "$refe_num";
					echo "</td>";
				}else{
					echo "<td>0</td>";
				}

				

				echo "</tr>";
				}else{continue;}

				

				}
		 	}
		 	echo "</table><br><br>";


		 	//new
		 	$data_year2 = array_count_values($data_year);

		 	$y = array();
		 	$year_number = array();
		 	foreach ($data_year2 as $key => $value) {
		 		array_push($y, $key);
		 		array_push($year_number, $value);
		 	}
		 	//new


			
		 	if ($total<=10){
                $char="Back to Search";
                echo "<a href=\"/index.php?\">$char </a>";
                
                echo "<br \>";echo "Page1/1";}
            else {
                

                echo "<br \>";
                $char="Next Page";
                echo "<a href=\"/fanye_conf1.php?conf_id=$conf_id&total=$total&times=$times&page=$page\">$char </a>";
                $char="Back to Search";
                echo "<a href=\"/index.php?\">$char </a>";
                
                echo "<br \>";
                echo "<br \>";
                echo "<br \>";
                echo "Page1";
                if ($total%10==0) {$totalPage=$total/10;echo "/$totalPage";}
                else {$totalPage=(int)($total/10)+1;echo "/$totalPage";}
            }

		}

		?>




		
</body>

</html>
