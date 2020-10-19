<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();

//관리자 인지 여부 체크 -> 접근 권한
if(!isset($_SESSION['admin']) || $_SESSION['admin'] < 1) {
    echo "<script>alert('접근 권한이 없습니다.')</script>";
}
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>A4B1 Admin Stage</title>
        <!--Jquery 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

        <!--alert & toastr 라이브러리 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

        <!--헤더 파일 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/static.css?ver=1">
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/admin.css?ver=1">
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/js/admin.js?ver=1"></script>

        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head>
    <body id="body">
        <script src="./chart/highcharts.js"></script>
        <script src="./chart/exporting.js"></script>
        <script src="./chart/export-data.js"></script>
        <script src="./chart/accessibility.js"></script>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/admin/admin_menu.php"?>
        <section>
            <?php

            $sql = "SELECT title,hit FROM game_review;";

            $result = mysqli_query($dbcon, $sql);
            $array = array();

            for ($i = 0; $row = mysqli_fetch_array($result); $i++) {
                for ($j = 0; $j < 2; $j++) {
                    if ($j == 0) {
                        $array[$i][$j] = $row['title'];
                    } else {
                        $array[$i][$j] = $row['hit'];
                    }

                }
            }
            ?>

            <?php
            $sql2 = "SELECT created_by,sum(hit) as hit FROM game_review GROUP BY created_by;";

            $result2 = mysqli_query($dbcon, $sql2);
            $array2 = array();

            for ($i = 0; $row2 = mysqli_fetch_array($result2); $i++) {
                for ($j = 0; $j < 2; $j++) {
                    if ($j == 0) {
                        $array2[$i][$j] = $row2['created_by'];
                    } else {
                        $array2[$i][$j] = $row2['hit'];
                    }

                }
            }
            ?>

            <script>
                var arr1 = <?php echo json_encode($array);?> ;
                console.log(arr1);
                var arr2 = <?php echo json_encode($array2);?> ;
                console.log(arr2);
            </script>
            <div id="admin_border">
                <div id="static_content">
                    <div id="static_title">
                        <h3>게시물별 조회수</h3>
                    </div>

                    <figure class="highcharts-figure">
                        <div id="container" style="height: 480px; max-width:750px; margin-left:20px;"></div>
                    </figure>

                    <script type="text/javascript">
                        Highcharts.chart('container', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '게시물별 리뷰 조회수'
                            },
                            xAxis: {
                                categories: [
                                    <?php
                                    for ($i = 0; $i < count($array); $i++) {
                                        if ($i < count($array) - 1) {
                                            echo "'" . $array[$i][0] . "',";
                                        } else {
                                            echo "'" . $array[$i][0] . "'";

                                        }
                                    }
                                    ?>
                                ],
                                crosshair: true
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: '조회수 (명)'
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.1f} 명</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.2,
                                    borderWidth: 0
                                }
                            },
                            series: [{
                                name: 'content',
                                data: [
                                    <?php
                                    for ($i = 0; $i < count($array); $i++) {
                                        if ($i < count($array) - 1) {
                                            echo $array[$i][1] . ",";
                                        } else {
                                            echo $array[$i][1];

                                        }
                                    }
                                    ?>
                                ]

                            }]
                        });
                    </script>

                    <div id="static_title">
                        <h3>계정별 조회수</h3>
                    </div>

                    <figure class="highcharts-figure">
                        <div id="container2" style="height: 480px; max-width:750px; margin-left:20px;"></div>
                    </figure>

                    <script type="text/javascript">
                        Highcharts.chart('container2', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '계정별 리뷰 조회수'
                            },
                            xAxis: {
                                categories: [
                                    <?php
                                    for ($i = 0; $i < count($array2); $i++) {
                                        if ($i < count($array2) - 1) {
                                            echo "'" . $array2[$i][0] . "',";
                                        } else {
                                            echo "'" . $array2[$i][0] . "'";

                                        }
                                    }
                                    ?>
                                ],
                                crosshair: true
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: '조회수 (명)'
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.1f} 명</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.2,
                                    borderWidth: 0
                                }
                            },
                            series: [{
                                name: 'Account',
                                data: [
                                    <?php
                                    for ($i = 0; $i < count($array2); $i++) {
                                        if ($i < count($array2) - 1) {
                                            echo $array2[$i][1] . ",";
                                        } else {
                                            echo $array2[$i][1];

                                        }
                                    }
                                    ?>
                                ]

                            }]
                        });
                    </script>
                </div><!-- //content -->
            </div>
        </section>
    </body>
</html>
