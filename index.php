<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PHP REST API</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <div class="jumbotron">
                <h2 class="text-center white-color">PHP REST API</h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <h2>GET - METHODS</h2>
                    <br>
                    <h3>User:</h3>
                    <div class="card">
                        <div class="card-body">
                            <h4>Read all products</h4>
                            <a href="http://portman.bplaced.net/product/read.php">http://portman.bplaced.net/product/read.php</a>  
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4>Read products by username </h4>
                            <a href="http://portman.bplaced.net/product/readByUser.php?user_id=1">http://portman.bplaced.net/product/readByUser.php?user_id=1 </a>  
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4>Read all users</h4>
                            <a href="http://portman.bplaced.net/user/read.php">http://portman.bplaced.net/user/read.php </a>  
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4>Read user by Id</h4>
                            <a href="http://portman.bplaced.net/user/readUserById.php?id=1">http://portman.bplaced.net/user/readUserById.php?id=1 </a>  
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4>Read all categories</h4>
                            <a href="http://portman.bplaced.net/category/readAll.php">http://portman.bplaced.net/category/readAll.php </a>  
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4>Read Default Categories</h4>
                            <a href="http://portman.bplaced.net/category/readDefaultCategories.php">http://portman.bplaced.net/category/readDefaultCategories.php </a>  
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4>Read Categories By User</h4>
                            <a href="http://portman.bplaced.net/category/readCategoriesByUser.php?user_id=2">http://portman.bplaced.net/category/readCategoriesByUser.php?user_id=2 </a>  
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4>Read All Categories By User</h4>
                            <a href="http://portman.bplaced.net/category/readAllCategoriesByUser.php?user_id=2">http://portman.bplaced.net/category/readAllCategoriesByUser.php?user_id=2 </a>  
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4>Read Budget By User</h4>
                            <a href="http://portman.bplaced.net/budget/readByUser.php?user_id=1">http://portman.bplaced.net/budget/readByUser.php?user_id=1</a>  
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4>Get Current Budget By User</h4>
                            <a href="http://portman.bplaced.net/budget/getCurrentBudgetByUser.php?user_id=1">http://portman.bplaced.net/budget/getCurrentBudgetByUser.php?user_id=1 </a>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
