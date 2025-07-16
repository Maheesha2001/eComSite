<?php
    include('./include/connect.php');

    // getting products
        function getproducts() {
            global $conn; // Make sure your connection variable is $conn
            //isset conditions
            if(!isset($_GET['category'])){
                if(!isset($_GET['brand'])){
        
                    $select_query = "SELECT * FROM products ORDER BY rand() LIMIT 0,9";
                    $result_query = mysqli_query($conn, $select_query);

                    while($row = mysqli_fetch_assoc($result_query)) {
                        $product_id = $row['product_id'];
                        $product_title = $row['product_title'];
                        $product_description = $row['product_description'];
                        $product_image1 = $row['product_image1'];
                        $product_price = $row['product_price'];
                        $category_id = $row['category_id'];
                        $brand_id = $row['brand_id'];

                        echo "<div class='product-card'>
                                <img src='./admin_area/images/$product_image1' alt='$product_title'>
                                <h5>$product_title</h5>
                                <p>$product_description</p>
                                <p><strong>Price:</strong> $product_price</p>
                                <div>
                                    <a href='index.php?add-to-cart=$product_id' class='btn btn-primary btn-sm' style='color: #fff; text-decoration: none;'>Add to cart</a>
                                    <a href='product_details.php?product_id=$product_id' class='btn btn-secondary btn-sm' style='color: #fff; text-decoration: none;'>View more</a>
                                </div>
                            </div>";
                    }
                }
            }
        }

        //get all products
        function get_all_products(){
            global $conn; // Make sure your connection variable is $conn
            //isset conditions
            if(!isset($_GET['category'])){
                if(!isset($_GET['brand'])){
        
                    $select_query = "SELECT * FROM products ORDER BY rand()";
                    $result_query = mysqli_query($conn, $select_query);

                    while($row = mysqli_fetch_assoc($result_query)) {
                        $product_id = $row['product_id'];
                    $product_title = $row['product_title'];
                    $product_description = $row['product_description'];
                    $product_image1 = $row['product_image1'];
                    $product_price = $row['product_price'];
                    $category_id = $row['category_id'];
                    $brand_id = $row['brand_id'];

                    echo "<div class='product-card'>";
                    echo "  <img src='./admin_area/images/$product_image1' alt='$product_title'>";
                    echo "  <h5>$product_title</h5>";
                    echo "  <p>$product_description</p>";
                    echo "  <p><strong>Price:</strong> $product_price</p>";
                    echo "  <div>";
                    echo "    <a href='index.php?add-to-cart=$product_id' class='btn btn-primary btn-sm' style='color: #fff; text-decoration: none;'>Add to cart</a>";
                    echo "    <a href='product_details.php?product_id=$product_id' class='btn btn-secondary btn-sm' style='color: #fff; text-decoration: none;'>View more</a>";
                    echo "  </div>";
                    echo "</div>";
                }
            }
            }
    }

    //get unique  categories
    function get_unique_gategory() {
        global $conn; // Make sure your connection variable is $conn
        //isset conditions
        if(isset($_GET['category'])){
            $category_id=$_GET['category'];
            
            $select_query = "SELECT * FROM products WHERE category_id=$category_id";
            $result_query = mysqli_query($conn, $select_query);
            
            if(mysqli_num_rows($result_query) == 0){
                echo "
                    <div class='no-products-message'>
                        <div class='no-products-card'>
                            <div class='no-products-icon'>⚠️</div>
                            <h2>No products found for this category</h2>
                            <p>Try browsing other categories or <a href='index.php' class='btn btn-outline-success btn-sm'>View All Products</a></p>
                        </div>
                    </div>
                    ";
            } else {
                while($row = mysqli_fetch_assoc($result_query)) {
                    $product_id = $row['product_id'];
                    $product_title = $row['product_title'];
                    $product_description = $row['product_description'];
                    $product_image1 = $row['product_image1'];
                    $product_price = $row['product_price'];
                    $category_id = $row['category_id'];
                    $brand_id = $row['brand_id'];

                    echo "<div class='product-card'>";
                    echo "  <img src='./admin_area/images/$product_image1' alt='$product_title'>";
                    echo "  <h5>$product_title</h5>";
                    echo "  <p>$product_description</p>";
                    echo "  <p><strong>Price:</strong> $product_price</p>";
                    echo "  <div>";
                    echo "    <a href='index.php?add-to-cart=$product_id' class='btn btn-primary btn-sm' style='color: #fff; text-decoration: none;'>Add to cart</a>";
                    echo "    <a href='product_details.php?product_id=$product_id' class='btn btn-secondary btn-sm' style='color: #fff; text-decoration: none;'>View more</a>";
                    echo "  </div>";
                    echo "</div>";
                }
            }
        }
    }

      //get unique  categories
      function get_unique_brand() {
        global $conn; // Make sure your connection variable is $conn
        //isset conditions
        if(isset($_GET['brand'])){
            $brand_id=$_GET['brand'];
            
            $select_query = "SELECT * FROM products WHERE brand_id=$brand_id";
            $result_query = mysqli_query($conn, $select_query);
            
            if(mysqli_num_rows($result_query) == 0){
               echo "<div class='no-products-message'>
                        <div class='no-products-card'>
                            <div class='no-products-icon'>⚠️</div>
                            <h2>No products found for this category</h2>
                        </div>
                    </div>
            ";
            } else {
                while($row = mysqli_fetch_assoc($result_query)) {
                    $product_id = $row['product_id'];
                    $product_title = $row['product_title'];
                    $product_description = $row['product_description'];
                    $product_image1 = $row['product_image1'];
                    $product_price = $row['product_price'];
                    $category_id = $row['category_id'];
                    $brand_id = $row['brand_id'];

                    echo "<div class='product-card'>";
                    echo "  <img src='./admin_area/images/$product_image1' alt='$product_title'>";
                    echo "  <h5>$product_title</h5>";
                    echo "  <p>$product_description</p>";
                    echo "  <p><strong>Price:</strong> $product_price</p>";
                    echo "  <div>";
                    echo "    <a href='index.php?add-to-cart=$product_id' class='btn btn-primary btn-sm' style='color: #fff; text-decoration: none;'>Add to cart</a>";
                    echo "    <a href='product_details.php?product_id=$product_id' class='btn btn-secondary btn-sm' style='color: #fff; text-decoration: none;'>View more</a>";
                    echo "  </div>";
                    echo "</div>";
                }
            }
        }
    }

    //getting categories
    function getcategories(){
        global $conn;
        $category_query = "SELECT * FROM categories ORDER BY category_title ASC";
        $category_result = mysqli_query($conn, $category_query);
            while($row = mysqli_fetch_assoc($category_result)) {
                $category_title = $row['category_title'];
                $category_id = $row['category_id'];            
            echo "<li class='nav-item'>
            <a href='index.php?category=$category_id' class='nav-link text light'>$category_title</a></li>";
            
        }
    }   

    //getting brands
    function getbrands(){
        global $conn;
        $brand_query = "SELECT * FROM brands ORDER BY brand_title ASC";
        $brand_result = mysqli_query($conn, $brand_query);
        while($row = mysqli_fetch_assoc($brand_result)) {
            $brand_title = $row['brand_title'];
            $brand_id = $row['brand_id'];
            echo "<li class='nav-item'>
            <a href='index.php?brand=$brand_id' class='nav-link text light'>$brand_title</a></li>";
        }
    } 

    // searching data
    function search_product(){
        global $conn;
        if(isset($_GET['search-data-product'])){

            $search_data_value = $_GET['search-data'];
            $select_query = "SELECT * FROM products WHERE product_keywords LIKE '%$search_data_value%'";
            $result_query = mysqli_query($conn, $select_query);
            if(mysqli_num_rows($result_query) == 0){
                echo "<div class='no-products-message'>
                         <div class='no-products-card'>
                             <div class='no-products-icon'>⚠️</div>
                             <h2>No products found for this key-word</h2>
                         </div>
                     </div>
             ";
            }
            while($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                $category_id = $row['category_id'];
                $brand_id = $row['brand_id'];

                echo "<div class='product-card'>";
                echo "  <img src='./admin_area/images/$product_image1' alt='$product_title'>";
                echo "  <h5>$product_title</h5>";
                echo "  <p>$product_description</p>";
                echo "  <p><strong>Price:</strong> $product_price</p>";
                echo "  <div>";
                echo "    <a href='index.php?add-to-cart=$product_id' class='btn btn-primary btn-sm' style='color: #fff; text-decoration: none;'>Add to cart</a>";
                echo "    <a href='product_details.php?product_id=$product_id' class='btn btn-secondary btn-sm' style='color: #fff; text-decoration: none;'>View more</a>";
                echo "  </div>";
                echo "</div>";
            }
        }
    } 

     // getting product details
     function get_product_details() {
        global $conn; // Make sure your connection variable is $conn
        //isset conditions
        if(isset($_GET['product_id'])){
        if(!isset($_GET['category'])){
            if(!isset($_GET['brand'])){
                $product_id=$_GET['product_id'];
                $select_query = "SELECT * FROM products WHERE product_id=$product_id";
                $result_query = mysqli_query($conn, $select_query);

                while($row = mysqli_fetch_assoc($result_query)) {
                    $product_id = $row['product_id'];
                    $product_title = $row['product_title'];
                    $product_description = $row['product_description'];
                    $product_image1 = $row['product_image1'];
                    $product_image2 = $row['product_image2'];
                    $product_image3 = $row['product_image3'];
                    $product_price = $row['product_price'];
                    $category_id = $row['category_id'];
                    $brand_id = $row['brand_id'];

                    echo "<div class='product-card'>
                            <img src='./admin_area/images/$product_image1' alt='$product_title'>
                            <h5>$product_title</h5>
                            <p>$product_description</p>
                            <p><strong>Price:</strong> $product_price</p>
                            <div>
                            <a href='index.php?add-to-cart=$product_id' class='btn btn-primary btn-sm' style='color: #fff; text-decoration: none;'>Add to cart</a>
                        <a href='index.php' class='btn btn-secondary btn-sm' style='color: #fff; text-decoration: none;'>Back  Home</a>
                          </div>
                        </div>
                       
                        <div class='related-products-section'>
                            <h4 class='related-products-title'>Related products</h4>
                            <div class='related-images-plain'>
                                <img src='./admin_area/images/$product_image2' alt='$product_title'>
                                <img src='./admin_area/images/$product_image3' alt='$product_title'>
                            </div>
                        </div>";
                }
            }   
        }
    }
    }
        
    // get ip address function
    function visitorIP() {  
        //Check if visitor is from shared network 
          if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                    $vIP = $_SERVER['HTTP_CLIENT_IP'];  
            }  
        //Check if visitor is using a proxy 
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){  
                    $vIP = $_SERVER['HTTP_X_FORWARDED_FOR'];  
          }  
        //check for the remote address of visitor.  
        else{  
                  $vIP = $_SERVER['REMOTE_ADDR'];  
          }  
          return $vIP;  
        }  

    // cart function
    function cart() {
        global $conn;
        if (isset($_GET['add-to-cart'])) {
            $get_ip_add = visitorIP(); // Use your IP function
            $get_product_id = $_GET['add-to-cart'];

            // Check if product is already in cart for this IP
            $select_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_add' AND product_id=$get_product_id";
            $result_query = mysqli_query($conn, $select_query);
            $num_of_rows = mysqli_num_rows($result_query);

            if ($num_of_rows > 0) {
                echo "<script>alert('This item is already present inside cart');</script>";
                echo "<script>window.open('index.php','_self');</script>";
            } else {
                $insert_query = "INSERT INTO cart_details (product_id, ip_address, quantity) VALUES ($get_product_id, '$get_ip_add', 0)";
                $result = mysqli_query($conn, $insert_query);
                echo "<script>alert('Item is added to cart');</script>";
                echo "<script>window.open('index.php','_self');</script>";
            }
        }
    }

    // function to get cart item numbers
    function cart_items(){
        global $conn;
        if (isset($_GET['add-to-cart'])) {
            $get_ip_add = visitorIP(); // Use your IP function
          

            // Check if product is already in cart for this IP
            $select_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_add'";
            $result_query = mysqli_query($conn, $select_query);
            $count_cart_items = mysqli_num_rows($result_query);

        }else {
            $get_ip_add = visitorIP(); // Use your IP function
          

            // Check if product is already in cart for this IP
            $select_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_add'";
            $result_query = mysqli_query($conn, $select_query);
            $count_cart_items = mysqli_num_rows($result_query);

        }
        echo $count_cart_items;
        
    }

    // total proce function
    function total_cart_price(){
        global $conn;
        $get_ip_add = visitorIP();
        $total_price = 0;
        $cart_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_add'";
        $result = mysqli_query($conn, $cart_query);
        while($row = mysqli_fetch_array($result)){
            $product_id = $row['product_id'];
            $select_products = "SELECT * FROM products WHERE product_id='$product_id'";
            $result_products = mysqli_query($conn, $select_products);
            while($row_product_price = mysqli_fetch_array($result_products)){
                $product_price = array($row_product_price['product_price']);
                $product_values = array_sum($product_price);
                $total_price += $product_values;
            }
        }
        echo $total_price;
    }
    
?>