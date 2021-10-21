<?php 

    function warning($str){
        echo "<p class='msg warning'><i class='fa fa-exclamation-triangle'></i> $str</p>";
    }

    function error($str) {
        echo "<p class='msg danger'><i class='fa fa-exclamation-circle'></i> $str</p>";
    }

    function success($str) {
        echo "<p class='msg success'><i class='fa fa-check-circle'></i> $str</p>";
    }