<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <header class="blog-header py-3">
            <div class="nav-scroller py-1 mb-2">
                <nav class="nav d-flex justify-content-between">
                    <?php if (isset($backPage) && $backPage !== 'index') { ?>
                        <a class="nav-link" href="index.php?controller=<?php echo $backPage; ?>&method=get&rssChannelId=<?php echo $_GET["rssChannelId"]; ?>">Back</a>
                    <?php } else { ?>
                        <a class="nav-link" href="index.php?rssChannelId=<?php echo $_GET["rssChannelId"]; ?>">Back</a>
                    <?php } ?>
                </nav>
            </div>
        </header>
        <?php if (!isset($backPage) || ($backPage === 'RSSItems' && isset($rssItemElementAndValues) && sizeof($rssItemElementAndValues) > 0)) { ?>
            <main role="main" class="container">
                <div class="row col-12">
                    <p><?php echo (isset($rssItemElementAndValues) ? 'Update' : 'Add'); ?> RSS Item</p>
                </div>
                <div class="row">
                    <form action="index.php?controller=RSSItem&method=post&rssChannelId=<?php echo $_GET["rssChannelId"]; ?>" method="post" class="needs-validation col-6" novalidate>
                        <fieldset>
                            <input type="text" name="id" class="d-none" value="<?php echo (isset($rssItemId) ? $rssItemId : 0); ?>">
                            <?php for ($i = 0; $i < count($rssItemElements); $i++) { ?>
                                <div class="form-group ">
                                    <label for="rssItemValue">
                                        <?php echo $rssItemElements[$i]['element']; ?>:
                                        <?php if ($rssItemElements[$i]['is_optional'] == 0) { ?>
                                            <spam class="text-danger">*</spam>
                                        <?php } ?>
                                    </label>
                                    <input
                                        type="rssItemValue"
                                        maxlength="256"
                                        name="<?php echo $rssItemElements[$i]['element']; ?>"
                                        class="form-control"
                                        id="rssItemValue<?php echo $rssItemElements[$i]['element']; ?>"
                                        value="<?php echo (isset($rssItemElementAndValues) && isset($rssItemElementAndValues[$rssItemElements[$i]['element']]) ? $rssItemElementAndValues[$rssItemElements[$i]['element']] : ""); ?>"
                                        <?php if ($rssItemElements[$i]['is_optional'] == 0) { ?>required<?php } ?>>
                                </div>
                            <?php } ?>
                            <?php if (isset($error) && $error) { ?>
                                <div class="bg-danger text-white">
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>
                            <?php if (isset($success) && $success) { ?>
                                <div class="bg-success text-white">
                                    <?php echo $success; ?>
                                </div>
                            <?php } ?>
                            <button type="submit" class="btn btn-primary"><?php echo (isset($rssItemElementAndValues) ? 'Update' : 'Submit'); ?></button>
                        </fieldset>
                    </form>
                </div>
            </main>
        <?php } else { ?>
            <?php if (isset($error) && $error) { ?>
                <div class="bg-danger text-white">
                    <?php echo $error; ?>
                </div>
            <?php } ?>
            <?php if (isset($success) && $success) { ?>
                <div class="bg-success text-white">
                    <?php echo $success; ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</body>
</html>

