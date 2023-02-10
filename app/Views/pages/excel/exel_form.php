<html>
    <head>
        <title>Excel Upload</title>
    </head>
    <body>
        <h3>Upload Excel File</h3>
        <?php if (session()->getFlashdata('error')) : ?>
            <p style="color: red;"><?= session()->getFlashdata('error'); ?></p>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <p style="color: green;"><?= session()->getFlashdata('success'); ?></p>
        <?php endif; ?>
        <form action="/excel/upload" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit">Upload</button>
        </form>
    </body>
</html>
