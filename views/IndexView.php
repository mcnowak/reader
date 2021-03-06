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
                <?php if (!isset($_GET["rssChannelId"])) { ?>
                    <nav class="nav d-flex justify-content-between">
                        <a class="nav-link" href="index.php?controller=RSSChannel">Add RSS Channel</a>
                        <a class="nav-link" href="index.php?controller=RSSChannels&method=get">RSS Channel Table</a>
                    </nav>
                <?php } else { ?>
                    <nav class="nav d-flex justify-content-between">
                        <a class="nav-link" href="index.php?controller=RSSChannels&method=get">Back</a>
                        <a class="nav-link" href="index.php?controller=RSSItem&rssChannelId=<?php echo $_GET["rssChannelId"]; ?>">Add RSS Item</a>
                        <a class="nav-link" href="index.php?controller=RSSItems&method=get&rssChannelId=<?php echo $_GET["rssChannelId"]; ?>">RSS Items Table</a>
                    </nav>
            <?php } ?>
            </div>
        </header>

        <footer">
            <div class="row">
                <p>Copyright by: Maciej Nowakowski</p>
            </div>
        </footer>
    </div>
</body>
</html>

