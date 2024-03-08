<!DOCTYPE html>
<html>
<head>
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
    //以下为5.24新增有关翻页代码
    $paper_title = $_GET["paper_title"];
    $rows=$_GET["rows"];
    $start=$_GET["start"];
    //echo "Title:".$paper_title;

    //echo "rows:".$rows;
    //echo "start:".$start;
    //$author_name = $_GET["author_name"];
    //$conference_name =$_GET["conference_name"];

    
    if ($paper_title) {
        echo "Search for Title: ".$paper_title;
        $ch = curl_init();
        $timeout = 5;
        $query = urlencode(str_replace(' ', '+', $paper_title));
        
        $url = "http://localhost:8983/solr/Lab_core_new/select?defType=edismax&mm=100%25&q=Title:".$query."&rows=$rows&start=$start&wt=json";
        //$url = "http://localhost:8983/solr/Lab_core_new/select?indent=on&q=Title:".$query."&rows=$rows&start=$start&wt=json";

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
            $title_1 = $paper['Title'];
            
            echo "<a href=\"paper.php?paper_id=$paper_id\">$title_1; </a>";//创建Title超链接跳转到paper.php页面
            
            echo "</td>";
            
            echo "<td>";
            foreach ($paper['AuthorsName'] as $idx => $author) {
                $author_id = $paper['AuthorsID'][$idx];
                echo "<a href=\"/author.php?author_id=$author_id\">$author; </a>";
            }
            echo "</td>";
            
            # 请补充针对Conference Name的显示(已完成)
            echo "<td>";
            $conf_id = $paper['ConferenceID'];
            $conference_name = $paper['ConferenceName'];
            echo "<a href=\"conference.php?conf_id=$conf_id\">$conference_name; </a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table><br><br>";
        
        if ($start+$rows<$resultAmount+10){//5.25非最后一页的页码输出
            $char="Last Page";
            $start=$start-20;
            //echo "<a href=\"/fanye.php\">$char </a>";
            echo "<a href=\"/fanye_title.php?paper_title=$paper_title&rows=$rows&start=$start\">$char </a>";
            
            $start=$start+20;
        $char="Next Page";
        //echo "<a href=\"/fanye.php\">$char </a>";
        echo "<a href=\"/fanye_title.php?paper_title=$paper_title&rows=$rows&start=$start\">$char </a>";
        $page=$start/10;
            
            $char="Back to Search";
            echo "<a href=\"/index.php?\">$char </a>";
            echo "<br \>";
            
        echo "<br />";
        echo "Page $page";
            if ($resultAmount%10==0) {$totalPage=$resultAmount/10;echo "/$totalPage";}
            else {$totalPage=(int)($resultAmount/10)+1;echo "/$totalPage";}
        }
        //以下为最后一页的页码输出
        else {
            $char="Last Page";
            $start=$start-20;
            //echo "<a href=\"/fanye.php\">$char </a>";
            echo "<a href=\"/fanye_title.php?paper_title=$paper_title&rows=$rows&start=$start\">$char </a>";
            
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
