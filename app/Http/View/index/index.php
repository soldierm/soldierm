<?php

var_dump($this);
?>

<html lang="zh">
<head>
    <title>主页</title>
</head>
<body>
<?php echo $this->render('layout/layout') ?>
<p><?php echo $version ?></p>
<p><?php echo $author ?></p>
<p><?php echo $datetime ?></p>
</body>
</html>
