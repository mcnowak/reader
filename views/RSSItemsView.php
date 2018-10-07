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
                    <a class="nav-link" href="index.php?rssChannelId=<?php echo $_GET["rssChannelId"]; ?>">Back</a>
                </nav>
            </div>
        </header>

        <main role="main" class="container">
            <div class="row col-12">
                <p class="text-justify">RSS Items Table</p>
            </div>
            <div class="row">
                <?php if (isset($rssItems) && sizeof($rssItems) > 0) { ?>
                    <table class="table">
                        <thead class="thead-light">
                            <tr class="d-flex">
                                <th class="col-1">Id</th>
                                <th class="col-3">Elements</th>
                                <th class="col-3">Created</th>
                                <th class="col-3">Modified</th>
                                <th class="col-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rssItems as $rssItem) { ?>
                                <tr class="d-flex">
                                    <td class="col-1"><?php echo $rssItem['id']; ?></td>
                                    <td class="col-3"><?php echo $rssItem['elementsString']; ?></td>
                                    <td class="col-3"><?php echo $rssItem['created']; ?></td>
                                    <td class="col-3"><?php echo $rssItem['modified']; ?></td>
                                    <td class="col-2">
                                        <form action="index.php?controller=RSSItem&method=get&rssChannelId=<?php echo $_GET["rssChannelId"]; ?>" method="post">
                                            <input type="text" name="id" class="d-none" value="<?php echo $rssItem['id']; ?>">
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </form>
                                        <form action="index.php?controller=RSSItem&method=delete&rssChannelId=<?php echo $_GET["rssChannelId"]; ?>" method="post">
                                            <input type="text" name="id" class="d-none" value="<?php echo $rssItem['id']; ?>">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="bg-danger text-white">
                        No RSS Items
                    </div>
                <?php } ?>
                <?php if (isset($error) && $error) { ?>
                    <div class="bg-danger text-white">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>

