<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="ws_url" content="{{ env('WS_URL'); ?>">

    <title><?= lambda('title') ?></title>
    <link href="<?= lambda( 'favicon')?>" rel="icon"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700|Roboto:300,400,500,700,900&amp;subset=cyrillic-ext" rel="stylesheet">
    <link rel="stylesheet" href="<?= mix('/assets/lambda/css/vendor.css'); ?>">
    <link rel="stylesheet" href="<?= mix('/assets/lambda/css/paper.css'); ?>">
    <?= $this->renderSection('meta') ?>
    <?= $this->renderSection('styles') ?>

</head>
<body>
<noscript>To run this application, JavaScript is required to be enabled.</noscript>
<?= $this->renderSection('app') ?>
<script src="<?= mix('/assets/lambda/js/manifest.js'); ?>"></script>
<script src="<?= mix('/assets/lambda/js/vendor.js'); ?>"></script>
<script src="<?= mix('/assets/lambda/js/datagrid-vendor.js'); ?>"></script>
<script src="<?= mix('/assets/lambda/js/paper.js'); ?>"></script>
<script>
    window.app_logo = "<?= lambda( 'logo')?>";
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>