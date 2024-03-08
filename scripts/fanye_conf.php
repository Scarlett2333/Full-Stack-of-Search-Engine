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
    height: 400px;
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
</head>

<body>
<h1>Conference Page</h1>


<?php
    
    
    
    $conf_id = $_GET["conf_id"];
    $total=$_GET["total"];
    $page=$_GET["page"];
    $link = mysqli_connect('127.0.0.1:3306','root','s7gubmna','Lab_1');
    
    
    $conf_info = mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceName from Conferences where ConferenceID='$conf_id'"));
    $conf_name = $conf_info['ConferenceName'];
    
    $result = mysqli_query($link, "SELECT PaperID,Title,PaperPublishYear from papers where ConferenceID='$conf_id' order by PaperPublishYear");
    $total=mysqli_num_rows($result);
    echo "resultAmount:$total";
    
    if ($result) {
        echo "<table width=\"100%\" border=\"1\"><tr><th>Title</th><th>Authors</th><th>PaperPublishYear</th><th>References</th></tr>";
        while ($row = mysqli_fetch_array($result)){
            
            $title = $row['Title'];
            $paper_id = $row['PaperID'];
            $year = $row['PaperPublishYear'];

            
            if ($times>10*$page&&$times<=10*$page+10){
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
            else {$times=$times+1;continue;}
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
        
        $page=$page+1;
        if ($total<=10*page){
            
            if($page==2){ echo "<br \>";
                $char="Last Page";
                $page=$page-2;
                echo "<a href=\"/conference.php?conf_id=$conf_id\">$char </a>";
            }
            else {
            
            
            echo "<br \>";
            $char="Last Page";
            $page=$page-2;
            echo "<a href=\"/fanye_conf.php?conf_id=$conf_id&total=$total&page=$page\">$char </a>";
            }
            
            $char="Back to Search";
            echo "<a href=\"/index.php?\">$char </a>";
            echo "<br \>";
            
                $page=$page+2;
            echo "Page $page";
            if ($total%10==0) {$totalPage=$total/10;echo "/$totalPage";}
            else {$totalPage=(int)($total/10)+1;echo "/$totalPage";}
        }
        else {
            if($page==2){ echo "<br \>";
                $char="Last Page";
                $page=$page-2;
                echo "<a href=\"/conference.php?conf_id=$conf_id\">$char </a>";
            }
            else {
                
                
                echo "<br \>";
                $char="Last Page";
                $page=$page-2;
                echo "<a href=\"/fanye_conf.php?conf_id=$conf_id&total=$total&page=$page\">$char </a>";
            }
            //echo "<br \>";
            $char="Next Page";
            $page=$page+2;
            echo "<a href=\"/fanye_conf.php?conf_id=$conf_id&total=$total&times=$times&page=$page\">$char </a>";
            
            $char="Back to Search";
            echo "<a href=\"/index.php?\">$char </a>";
            echo "<br \>";
            
            echo "<br \>";
            echo "<br \>";
            echo "Page $page";
            if ($total%10==0) {$totalPage=$total/10;echo "/$totalPage";}
            else {$totalPage=(int)($total/10)+1;echo "/$totalPage";}
        }
        
    }
    
    //翻页；图表
    ?>




</body>

</html>
