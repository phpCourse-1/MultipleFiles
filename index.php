<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Image Upload</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="layout/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="layout/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="layout/dist/css/adminlte.min.css">
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="userImages[]" value="" multiple>
        <input type="submit" value="Upload" name="submit">
    </form>

    <?php
    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );

    function reArray($images)
    {
        $images_arr = array();
        $images_count = count($images['name']);
        $array_keys = array_keys($images);

        for ($i = 0; $i < $images_count; $i++) {
            foreach ($array_keys as $key) {
                $images_arr[$i][$key] = $images[$key][$i];
            }
        }

        return $images_arr;
    }

    function pre_r($array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }

    if (isset($_FILES['userImages'])) {
        $images_arr = reArray($_FILES['userImages']);
        for ($i = 0; $i < count($images_arr); $i++) {
            if ($images_arr[$i]['error']) {
    ?>
                <div class="alert alert-danger">
                    <?php echo $images_arr[$i]['name'] . ' ' . $phpFileUploadErrors[$images_arr[$i]['error']]; ?>
                </div>
                <?php
            } else {
                $extensions = array('jpg', 'png', 'gif', 'jpeg');
                $file_ext = explode('.', $images_arr[$i]['name']);
                $file_ext = end($file_ext);
                if (!in_array($file_ext, $extensions)) {
                ?>
                    <div class="alert alert-danger">
                        <?php echo $images_arr[$i]['name'] . ' - ' . 'Invalid File Extension!'; ?>
                    </div>
                <?php
                } else {
                    $image_tmp = $images_arr[$i]['tmp_name'];
                    $image_name = $images_arr[$i]['name'];
                    $image_size = $images_arr[$i]['size'];
                    $image_type = $images_arr[$i]['type'];

                    $file_extension = strtolower($file_ext);
                    $newImageName = rand(100000, 900000) . '.' . $file_extension;
                    $target = "userImages/" . $newFileName;
                    $upload = move_uploaded_file($image_tmp, $target);
                ?>
                    <div class="alert alert-success">
                        <?php echo $images_arr[$i]['name'] . ' - ' . $phpFileUploadErrors[$images_arr[$i]['error']] ?>
                    </div>
    <?php
                }
            }
        }
    }
    ?>

    <!-- jQuery -->
    <script src="layout/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="layout/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="layout/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="layout/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="layout/dist/js/demo.js"></script>
</body>

</html>