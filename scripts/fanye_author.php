<!DOCTYPE html>
<html>
<head>
<style type="text/css">
a:link{color:black;}
a:visited{color:red;}
a:hover{color:white;}
a:active{color:#ccc;}
    a{text-decoration: none;
    width:140px;
    height:40px;
    padding:1px;
    border: none;
    background:#ffcc80;
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
<title>search page example</title>
<style type="text/css">
body {
    text-align: center;
}
</style>
</head>

<body>
<h1>Search Page Result</h1>


<?php
    echo "fanye_author.php";
    //以下为5.25新增有关翻页代码
    $author_name = $_GET["author_name"];
    $rows=$_GET["rows"];
    $start=$_GET["start"];

    echo "$suthor_name";
    if ($author_name) {
        echo "Search for Author Name: ".$author_name;
        $ch = curl_init();
        $timeout = 5;
        $query = urlencode(str_replace(' ', '\ ', $author_name));
        
        //$url = "http://localhost:8983/solr/Lab_core_new/select?defType=edismax&mm=100%25&q=Title:".$query."&rows=$rows&start=$start&wt=json";
        //$url = "http://localhost:8983/solr/Lab_core_new/select?indent=on&q=Title:".$query."&rows=$rows&start=$start&wt=json";
        $url = "http://localhost:8983/solr/Lab_core_new/select?indent=on&q=AuthorsName:".$query."&rows=$rows&start=$start&wt=json";
        
        $start=$start+10;
        
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        echo "<table border=\"1\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
        
        //以下为5.25新增
        $resultAmount=$result['response']['numFound'];
        echo "<br />";
        echo "resultAmount:$resultAmount";
        
        foreach ($result['response']['docs'] as $paper) {
            echo "<tr>";
            echo "<td>";
            echo $paper['Title'];
            echo "</td>";
            
            echo "<td>";
            foreach ($paper['AuthorsName'] as $idx => $author) {
                $author_id = $paper['AuthorsID'][$idx];
                echo "<a href=\"/author.php?author_id=$author_id\">$author; </a>";
            }
            echo "</td>";
            
            # 请补充针对Conference Name的显示(已完成)
            echo "<td>";
            echo $paper['ConferenceName'];
            echo "</td>";
            echo "</tr>";
        }
        echo "</table><br><br>";
        
        if ($start+$rows<$resultAmount+10){//5.25非最后一页的页码输出
            
            $char="Last Page";
            $start=$start-20;
            //echo "<a href=\"/fanye.php\">$char </a>";
            echo "<a href=\"/fanye_author.php?author_name=$author_name&rows=$rows&start=$start\">$char </a>";
            
           $start=$start+20;
        $char="Next Page";
        echo "<a href=\"/fanye_author.php?author_name=$author_name&rows=$rows&start=$start\">$char </a>";
        $page=$start/10;
            $char="Back to Search";
            echo "<a href=\"/index.php?\">$char </a>";
            echo "<br \>";
            
        echo "<br />";
        echo "<br \>";
        echo "Page $page";
            if ($resultAmount%10==0) {$totalPage=$resultAmount/10;echo "/$totalPage";}
            else {$totalPage=(int)($resultAmount/10)+1;echo "/$totalPage";}
        }
        //以下为最后一页的页码输出
        else {
            $char="Last Page";
            $start=$start-20;
            //echo "<a href=\"/fanye.php\">$char </a>";
           echo "<a href=\"/fanye_author.php?author_name=$author_name&rows=$rows&start=$start\">$char </a>";
            $char="Back to Search";
            echo "<a href=\"/index.php?\">$char </a>";
            echo "<br \>";
            
            echo "<br />";
            if ($resultAmount%10==0) {$totalPage=$resultAmount/10;echo "Page$totalPage/$totalPage";}
            else {$totalPage=(int)($resultAmount/10)+1;echo "Page$totalPage/$totalPage";}
        }
        }
    else echo "no";
    ?>
</body>

</html>
