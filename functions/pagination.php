<?php

$sql = "SELECT * FROM posts;";
$result = mysqli_query($conn, $sql);
$total = mysqli_num_rows($result);
print_r($total);

$pages = ceil($total / $num_page);
echo "
    <div class='pagination'>
        <a href='home.php?page=1'>Fist Page</a>
    </div>
";

for($i = 1; $i <= $pages; $i++){
    echo "<a href='home.php?page=$i'>$i</a>";
}

echo "<a href='hom.php?page=$pages'>Last Page</a>";