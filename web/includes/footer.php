<div id="footer">  <strong> Copyright  <?php echo date("Y"); ?>, Reporting </strong> </div>
</body>
</html>
<?php
if (isset($connection)) {
    mysqli_close($connection);
}

