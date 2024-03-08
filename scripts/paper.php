<!DOCTYPE html> 
<html>
<head>
<title>paper page example</title>
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
    <title>search page example</title>
    <style type="text/css">
    body {
        text-align: center;
    }
    </style>
    
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <style type="text/css">
    body {
        text-align: center;
        font-size： 50px;
    }
    
    </style>
</head>

<body>
	<h1>Paper Page Example</h1>
	<?php
		$paper_id = $_GET["paper_id"];
        
		$link = mysqli_connect('127.0.0.1:3306','root','s7gubmna','Lab_1');
		
		$result = mysqli_query($link, "SELECT Title,PaperPublishYear,ConferenceID from papers where PaperID='$paper_id'");
		
		 if ($result) {
		 	echo "<table width=\"100%\" border=\"1\"><tr><th>Title</th><th>Authors</th><th>Conference</th><th>PaperPublishYear</th><th>Reference</th></tr>";
		 	while ($row = mysqli_fetch_array($result)){
		 		echo "<tr>";
		 		$title = $row['Title'];
		 		echo "<td>$title</td>";

		 		$author_info = mysqli_fetch_array(mysqli_query($link, "SELECT AuthorName from authors inner join paper_author_affiliation ON authors.AuthorID = paper_author_affiliation.AuthorID where PaperID ='$paper_id' order by AuthorSequence ASC"));
				$author_name = $author_info['AuthorName'];

				$new_author_info = mysqli_fetch_array(mysqli_query($link, "SELECT AuthorID from authors where AuthorName='$author_name'"));
				$new_author_id = $new_author_info['AuthorID'];

				echo "<td><a href=\"author.php?author_id=$new_author_id\">$author_name; </a></td>";#对查询到的AuthorName添加超链接

				echo "<td>";
				$conf_id = $row['ConferenceID'];
				$conf_info = mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceName from conferences where ConferenceID='$conf_id'"));
				$conf_name = $conf_info['ConferenceName'];
				echo "<a href=\"conference.php?conf_id=$conf_id\">$conf_name; </a>";
				echo "</td>";

				$paper_publish_year= $row['PaperPublishYear'];
				echo "<td>$paper_publish_year</td>";

				$result2 = mysqli_query($link, "SELECT ReferenceID FROM paper_reference where PaperID = $paper_id");
				if ($result2){
					$refe_info = mysqli_fetch_array($result2);
					echo "<td>";
					$refe_num = mysqli_num_rows($result2);
					echo "$refe_num";
					echo "</td>";
				}else{
					echo "<td>none</td>";
				}
				echo "</tr>";
		 	}
		 	echo "</table><br><br>";
		}
        
        
        if ($title) {
            echo "Search for Title: ".$title;
            $ch = curl_init();
            $timeout = 5;
            $query = urlencode(str_replace(' ', '+', $title));
            
            $url = "http://localhost:8983/solr/Lab_core_new/select?indent=on&q=Title:".$query."&wt=json";//solr的模糊搜索
            //以下为5.24新增有关精准搜索代码
            
            
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $result = json_decode(curl_exec($ch), true);
            curl_close($ch);
            echo "<table border=\"1\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
            
            //以下为5.25新增有关翻页的内容
            echo "<br />";
            $resultAmount=$result['response']['numFound'];
            echo "resultAmount:$resultAmount";
            //以上为5.25新增有关翻页的内容
            
            $ii=1;
            
            foreach ($result['response']['docs'] as $paper) {
                if ($ii==1) {$ii=$ii+1;continue;}
                else {
                
                
                echo "<tr>";
                echo "<td>";
                $paper_id = $paper['PaperID'];
                $k = explode(" ", $paper_title);//把用户输入的文本用空格分开，打散成数组
                $space_num = 0;
                $arrString = str_split($paper_title);
                foreach ($arrString as $key => $value) {
                    if($value == ' ')
                        $space_num += 1;
                }
                
                
                for($i=0;$i<$space_num+1;$i++){
                    $paper['Title'] = preg_replace("/($k[$i])/i", "<font color=#CD5555><b>\\1</b></font>", $paper['Title']);
                }
                //6.2new
                
                $title_1 = $paper['Title'];
                
                echo "<a href=\"paper.php?paper_id=$paper_id\">$title_1; </a>";//创建Title超链接跳转到paper.php页面
                
                // echo "<a href=\"/paper.php?paper_id=$paper_id\">$paper['Title']; </a>";
                //echo $paper['Title'];
                echo "</td>";
                
                echo "<td>";
                foreach ($paper['AuthorsName'] as $idx => $author) {
                    $author_id = $paper['AuthorsID'][$idx];
                    echo "<a href=\"/author.php?author_id=$author_id\">$author; </a>";
                }
                echo "</td>";
                
                # 请补充针对Conference Name的显示(已完成)
                echo "<td>";
                //echo $paper['ConferenceName'];
                $conf_id = $paper['ConferenceID'];
                $conference_name = $paper['ConferenceName'];
                echo "<a href=\"conference.php?conf_id=$conf_id\">$conference_name; </a>";
                echo "</tr>";
            }
            }
            echo "</table><br><br>";
            
            if ($resultAmount>10){//5.26
                //以下为5.24新增有关翻页代码
                $rows=10;
                $start=10;
                $char="Next Page";
                echo "<a href=\"/fanye_paper.php?paper_title=$title&paper_id=$paper_id&rows=$rows&start=$start\">$char </a>";
                
                $char="Back to Search";
                echo "<a href=\"/index.php?\">$char </a>";
                echo "<br \>";
                
                echo "<br />";
                echo "Page 1";
                if ($resultAmount%10==0) {$totalPage=$resultAmount/10;echo "/$totalPage";}
                else {$totalPage=(int)($resultAmount/10)+1;echo "/$totalPage";}
                echo "<br />";
                //以上为5.24新增有关翻页代码
            }
            else {
                
                
                $char="Back to Search";
                echo "<a href=\"/index.php?\">$char </a>";
                echo "<br \>";
                echo "Page1/1";
                echo "<br />";
            }
            
        }

		

		?>
</body>

</html>
