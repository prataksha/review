<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <div class="header">
            <h1>Welcome! <?php echo $username . '</br>'; ?></h1> 
        </div> 
        <div id="uploader">
            <form action="/review/index.php/review/uploadIt" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <table>
                    <tr><td><?php
//echo form_open_multipart('/review/index.php/review/uploadIt');
echo form_upload('userfile');
?></td></tr>
                    <tr><td>Title:
                        <input type="text" name="title" value="" /></td>
                    </tr>
                    <tr><td>
                            <?php
                            echo form_submit('upload', 'Upload');
                            ?>
                        </td></tr></table>
                <?php echo form_close(); ?>
        </div> 
        <a href="sessioncreate/logout">Logout</a>

    </body>
</html>
