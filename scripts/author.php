.<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<title>ECharts</title>
<script src="echarts.min.js"></script>


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
    
    <script src="incubator-echarts-4.2.1/dist/echarts.js"></script>  <!--li sijia -->
    <script src="js/jquery-1.11.3.js"></script>  <!--li sijia-->
</head>

<body>
	<h1>Author Page Result</h1>
    
    
	<?php
    $arr_year=array();   //li sijia
    $arr_reference = array();  //li sijia
    $data_author=array();
    //echo "author.php";
    
		$author_id = $_GET["author_id"];
        echo "Author Id:".$author_id;
    echo "<br \>";
        $link = mysqli_connect('127.0.0.1:3306','root','s7gubmna','Lab_1');
        
		$result = mysqli_query($link,"SELECT AuthorName from authors where AuthorID='$author_id'");
		if ($result) {
			$author_name = mysqli_fetch_array($result)['AuthorName'];
			echo " Name: $author_name<br>";
		} else {echo "Name not found";}
		$result = mysqli_query($link, "SELECT affiliations.AffiliationID, affiliations.AffiliationName from (select AffiliationID, count(*) as cnt from paper_author_affiliation where AuthorID='$author_id' and AffiliationID is not null group by AffiliationID order by cnt desc) as tmp inner join affiliations on tmp.AffiliationID = affiliations.AffiliationID");
		# 请补充对主要机构名的显示(已完成)
        if ($result){
            $affiliation_name=mysqli_fetch_array($result)['AffiliationName'];
            //array_push($data_author_sub,$affiliation_name);
            echo "Affiliation Name: $affiliation_name<br>";
        } else{echo "Name not found";}
		$result = mysqli_query($link, "SELECT PaperID from paper_author_affiliation where AuthorID='$author_id'");
        $total=mysqli_num_rows($result);//5.25
        $times=1;//5.25
        $page=1;//5.25
		if ($result) {
			echo "<table border=\"1\"><tr><th>PaperID</th><th>Title</th><th>Authors</th><th>Conference</th></tr>";
			while ($row = mysqli_fetch_array($result)) {
                $data_author_sub=array();
				$paper_id = $row['PaperID'];
				# 请增加对mysqli_query查询结果是否为空的判断(已完成)
                if (!$row){echo "Paper not found";}
                else{
                    $paper_info = mysqli_fetch_array(mysqli_query($link, "SELECT Title, ConferenceID, PaperPublishYear from papers where PaperID='$paper_id'"));
				$paper_title = $paper_info['Title'];
                $year_num=$paper_info['PaperPublishYear'];
                array_push($data_author_sub,$year_num);
                array_push($data_author_sub,$paper_id);
				$conf_id = $paper_info['ConferenceID'];
                $paper_publish_year = $paper_info['PaperPublishYear'];   //li sijia
                $paper_info2 = mysqli_fetch_array(mysqli_query($link, "SELECT ReferenceID from paper_reference where PaperID='$paper_id'"));  // li sijia
                $reference_id = $paper_info2['ReferenceID'];   //li sijia
                $paper_info3 = mysqli_fetch_array(mysqli_query($link, "SELECT Title from papers where PaperID='$reference_id'"));   //得到了每一次检索之后reference的名字  li sijia
                $reference_name = $paper_info3['Title'];   //li sijia
                array_push($arr_year,$paper_publish_year);   //li sijia
                array_push($arr_reference,$reference_name); //li sijia
                    if ($times<=10){
                        echo "<tr>";
                        echo "<td>$paper_id</td>";
                        $times=$times+1;
				echo "<td>$paper_title</td>";
                        
                        
                        
                # 请增加根据paper id在PaperAuthorAffiliations与Authors两个表中进行联合查询，找到根据AuthorSequenceNumber排序的作者列表，并且显示出来的部分(已完成)
                echo "<td>";
                $result2 = mysqli_query($link, "SELECT AuthorID from paper_author_affiliation WHERE PaperID='$paper_id' ORDER BY AuthorSequence");
                while ($row2=mysqli_fetch_array($result2)){
                    $author_id_current=$row2[0];
                    $author_info=mysqli_fetch_array(mysqli_query($link, "SELECT AuthorName from authors where AuthorID='$author_id_current'"));
                    array_push($data_author_sub,$author_info[0]);
                        echo "<a href=\"/author.php?author_id=$author_id_current\">$author_info[0]; </a>";
                }
                echo "</td>";
                # 请补充根据$conf_id查询conference name并显示的部分(已完成)
                $result3=mysqli_query($link, "SELECT ConferenceName from Conferences where ConferenceID='$conf_id'");
                $conference_name=mysqli_fetch_array($result3)['ConferenceName'];
                        //array_push($data_author_sub,$conference_name);
                echo "<td>$conference_name</td>";
                        echo "</tr>";
                    }else {continue;}}
                array_push($data_author,$data_author_sub);
			}//while的内容
			echo "</table>";
            
            if ($total<=10){
                $char="Back to Search";
                echo "<a href=\"/index.php?\">$char </a>";
                echo "<br \>";
                echo "Page1/1";}
            else {
                echo "<br \>";
                $char="Next Page";
                echo "<a href=\"/fanye_mysql.php?author_id=$author_id&total=$total&times=$times&page=$page\">$char </a>";
                $char="Back to Search";
                echo "<a href=\"/index.php?\">$char </a>";
                echo "<br \>";
                echo "<br \>";
                echo "Page1";
                if ($total%10==0) {$totalPage=$total/10;echo "/$totalPage";}
                else {$totalPage=(int)($total/10)+1;echo "/$totalPage";}
            }
		}//if的内容
    
    
    
    //echo "<pre>";print_r($data_author);echo "<pre>";
    
    //li sijia
    $arr2_year=array_count_values($arr_year);  //统计之后返回的是一个新的数组
    ksort($arr2_year);  //排序之后改变的是原来的数组
    $year=array();
    $year_number=array();
    
    foreach($arr2_year as $x=>$x_value)
    {
        array_push($year, $x);
        array_push($year_number, $x_value);
    }
    
    
    $arr2_reference = array_count_values($arr_reference);
    arsort($arr2_reference);
    $reference = array();
    $reference_number = array();
    
    foreach($arr2_reference as $y=>$y_value)
    {
        array_push($reference, $y);
        array_push($reference_number, $y_value);
    }
    
    
    echo "<table border=\"1\"><tr ><th>Recommendation papers</th><th>Cited frequency times</th></tr>";
    if(count($reference) > 3)  {$min = 3;}
    else {$min = count($reference);}
    for ($x=0; $x<$min; $x++) {
    echo "<tr>";
        echo "<td height=20>";
        echo "$reference[$x]";
        echo"</td>";
        //echo "</tr>";
        echo "<td>$reference_number[$x]</td>";

        //echo "<td>$conference_name</td>";
        //echo "</tr>";
        
        
    echo"</tr>";
    }
    echo "</table>";
    
    echo "<br \>";
    echo "<br \>";
	?>
    
    
    <!--李斯佳 根据每一位作者在不同年份发表论文的数量-->
    <div id="main" style="float:left; width: 600px;height:400px;"></div>
    <script type="text/javascript">
    
    var data_year = <?php echo json_encode($year); ?>;
    var data_year_number = <?php echo json_encode($year_number); ?>;
    var myChart1 = echarts.init(document.getElementById('main'));
    
    var option1 = {
    title: {
    text: 'The Number of Author\' Papers in Different Years'
    },
    tooltip: {},
    legend: {
    data:['paper publish year']
    },
    xAxis: {
    data: data_year
    },
    yAxis: {},
    series: [{
    name: 'numbers of paper',
    type: 'bar',
    barWidth:20,
    barMaxWidth:30,
    barGap:20,
    data:data_year_number
    }]
    };
    
    <!-- 使用刚指定的配置项和数据显示图表。-->
    myChart1.setOption(option1);
    </script>
    
    
    <!--徐薇可视化-->
    <div id="container" style="float:right; width: 600px;height:400px;"></div>
    <!--<div id="container" style="height: 100%"></div>-->
    <script type="text/javascript">
    <!-- 基于准备好的dom，初始化echarts实例-->
    var data_author=<?php echo json_encode($data_author);?>;
    var dom = document.getElementById("container");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    
    
    
    
    var i=0;
    var j=0;
    
    var data = [
    {
    name: data_author[0][0],
    itemStyle: {
    color: '#da0d68'
    },
    children: [
        
    {
    name: data_author[0][1],
    itemStyle: {
    color: '#e0719c'
    },
    children: [{
    name: data_author[0][2],
    value: 5,
    itemStyle: {
    color: '#f99e1c'
    }
    }, {
    name: data_author[0][3],
    value: 4,
    itemStyle: {
    color: '#ef5a78'
    }
    }, {
    name: data_author[0][4],
    value: 3,
    itemStyle: {
    color: '#f7f1bd'
    }
    }, {
    name: data_author[0][5],
    value: 2,
    itemStyle: {
    color: '#3e0317'
    }
    },{
    name: data_author[0][6],
    value: 1,
    itemStyle: {
    color: '#3e0317'
    }
    }]
    }]
    },{
    name: data_author[1][0],
    itemStyle: {
    color: '#da1d23'
    },
    children: [
        {
        name: data_author[1][1],
        itemStyle: {
        color: '#dd4c51'
        },
        children: [{
        name: data_author[1][2],
        value: 5,
        itemStyle: {
        color: '#e62969'
        }
        }, {
        name: data_author[1][3],
        value: 4,
        itemStyle: {
        color: '#6569b0'
        }
        }, {
        name: data_author[1][4],
        value: 3,
        itemStyle: {
        color: '#ef2d36'
        }
        }, {
        name: data_author[1][5],
        value: 2,
        itemStyle: {
        color: '#b53b54'
        }
        },{
        name: data_author[1][6],
        value: 1,
        itemStyle: {
        color: '#a5446f'
        }
        }]
        }]
    },{
    name: data_author[2][0],
    itemStyle: {
    color: '#ebb40f'
    },
    children: [
        {
        name: data_author[2][1],
        itemStyle: {
        color: '#b09733'
        },
        children: [{
        name: data_author[2][2],
        value: 5,
        itemStyle: {
        color: '#9ea718'
        }
        }, {
        name: data_author[2][3],
        value: 4,
        itemStyle: {
        color: '#94a76f'
        }
        }, {
        name: data_author[2][4],
        value: 3,
        itemStyle: {
        color: '#d0b24f'
        }
        }, {
        name: data_author[2][5],
        value: 2,
        itemStyle: {
        color: '#8eb646'
        }
        },{
        name: data_author[2][6],
        value: 1,
        itemStyle: {
        color: '#faef07'
        }
        }]
        }]
    },{
    name: data_author[3][0],
    itemStyle: {
    color: '#187a2'
    },
    children: [
        {
        name: data_author[3][1],
        itemStyle: {
        color: '#c1ba07'
        },
        children: [{
        name: data_author[3][2],
        value: 5,
        itemStyle: {
        color: '#8f1c53'
        }
        }, {
        name: data_author[3][3],
        value: 4,
        itemStyle: {
        color: '#b34039'
        }
        }, {
        name: data_author[3][4],
        value: 3,
        itemStyle: {
        color: '#ba9232'
        }
        }, {
        name: data_author[3][5],
        value: 2,
        itemStyle: {
        color: '#8b6439'
        }
        },{
        name: data_author[3][6],
        value: 1,
        itemStyle: {
        color: '#718933'
        }
        }]
        }]
    },{
    name: data_author[4][0],
    itemStyle: {
    color: '#a2b029'
    },
    children: [
        {
        name: data_author[4][1],
        itemStyle: {
        color: '#718933'
        },
        children: [{
        name: data_author[4][2],
        value: 5,
        itemStyle: {
        color: '#62aa3c'
        }
        }, {
        name: data_author[4][3],
        value: 4,
        itemStyle: {
        color: '#03a653'
        }
        }, {
        name: data_author[4][4],
        value: 3,
        itemStyle: {
        color: '#038549'
        }
        }, {
        name: data_author[4][5],
        value: 2,
        itemStyle: {
        color: '#28b44b'
        }
        },{
        name: data_author[4][6],
        value: 1,
        itemStyle: {
        color: '#a3a830'
        }
        }]
        }]
    },{
    name: data_author[5][0],
    itemStyle: {
    color: '#5e9a80'
    },
    children: [
        {
        name: data_author[5][1],
        itemStyle: {
        color: '#9db2b7'
        },
        children: [{
        name: data_author[5][2],
        value: 5,
        itemStyle: {
        color: '#8b8c90'
        }
        }, {
        name: data_author[5][3],
        value: 4,
        itemStyle: {
        color: '#beb276'
        }
        }, {
        name: data_author[5][4],
        value: 3,
        itemStyle: {
        color: '#744e03'
        }
        }, {
        name: data_author[5][5],
        value: 2,
        itemStyle: {
        color: '#a3a36f'
        }
        },{
        name: data_author[5][6],
        value: 1,
        itemStyle: {
        color: '#c9b583'
        }
        }]
        }]
    },{
    name: data_author[6][0],
    itemStyle: {
    color: '#0aa3b5'
    },
    children: [
        {
        name: data_author[6][1],
        itemStyle: {
        color: '#76c0cb'
        },
        children: [{
        name: data_author[6][2],
        value: 5,
        itemStyle: {
        color: '#80a89d'
        }
        }, {
        name: data_author[6][3],
        value: 4,
        itemStyle: {
        color: '#7a9bae'
        }
        }, {
        name: data_author[6][4],
        value: 3,
        itemStyle: {
        color: '#039fb8'
        }
        }, {
        name: data_author[6][5],
        value: 2,
        itemStyle: {
        color: '#5e777b'
        }
        },{
        name: data_author[6][6],
        value: 1,
        itemStyle: {
        color: '#120c0c'
        }
        }]
        }]
    },{
    name: data_author[7][0],
    itemStyle: {
    color: '#947ff6'
    },
    children: [
        {
        name: data_author[7][1],
        itemStyle: {
        color: '#9eb0f8'
        },
        children: [{
        name: data_author[7][2],
        value: 5,
        itemStyle: {
        color: '#bc6cf5'
        }
        }, {
        name: data_author[7][3],
        value: 4,
        itemStyle: {
        color: '#89bdf7'
        }
        }, {
        name: data_author[7][4],
        value: 3,
        itemStyle: {
        color: '#d167f4'
        }
        }, {
        name: data_author[7][5],
        value: 2,
        itemStyle: {
        color: '#d5aef9'
        }
        },{
        name: data_author[7][6],
        value: 1,
        itemStyle: {
        color: '#b70ec5'
        }
        }]
        }]
    },{
    name: data_author[8][0],
    itemStyle: {
    color: '#f245a8'
    },
    children: [
        {
        name: data_author[8][1],
        itemStyle: {
        color: '#f791c3'
        },
        children: [{
        name: data_author[8][2],
        value: 5,
        itemStyle: {
        color: '#f89a1c'
        }
        }, {
        name: data_author[8][3],
        value: 4,
        itemStyle: {
        color: '#e65656'
        }
        }, {
        name: data_author[8][4],
        value: 3,
        itemStyle: {
        color: '#e73451'
        }
        }, {
        name: data_author[8][5],
        value: 2,
        itemStyle: {
        color: '#f68a5c'
        }
        },{
        name: data_author[8][6],
        value: 1,
        itemStyle: {
        color: '#baa635'
        }
        }]
        }]
    },{
    name: data_author[9][0],
    itemStyle: {
    color: '#e65832'
    },
    children: [
        {
        name: data_author[9][1],
        itemStyle: {
        color: '#e75b68'
        },
        children: [{
        name: data_author[9][2],
        value: 5,
        itemStyle: {
        color: '#d45a59'
        }
        }, {
        name: data_author[9][3],
        value: 4,
        itemStyle: {
        color: '#d0545f'
        }
        }, {
        name: data_author[9][4],
        value: 3,
        itemStyle: {
        color: '#ae341f'
        }
        }, {
        name: data_author[9][5],
        value: 2,
        itemStyle: {
        color: '#d78823'
        }
        },{
        name: data_author[9][6],
        value: 1,
        itemStyle: {
        color: '#da5c1f'
        }
        }]
        }]
    
    }];
    
    
    
    
    
    
    option = {
    series: {
    type: 'sunburst',
    highlightPolicy: 'ancestor',
    data: data,
    radius: [0, '95%'],
    sort: null,
    levels: [{}, {
    r0: '15%',
    r: '35%',
    itemStyle: {
    borderWidth: 2
    },
    label: {
    rotate: 'tangential'
    }
    }, {
    r0: '35%',
    r: '70%',
    label: {
    align: 'right'
    }
    }, {
    r0: '70%',
    r: '72%',
    label: {
    position: 'outside',
    padding: 3,
    silent: false
    },
    itemStyle: {
    borderWidth: 3
    }
    }]
    }
    };
    ;
    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }
    
    
    
    </script>
    
</body>

</html>
