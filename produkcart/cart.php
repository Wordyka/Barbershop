<?php  
 //cart.php  
 session_start();  
 $connect = mysqli_connect("localhost", "root", "", "pkbarbershop");  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | Multi Tab Shopping Cart By Using PHP Ajax Jquery Bootstrap Mysql</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br />  
           <div class="container" style="width:800px;">  
                <?php  
                if(isset($_POST["place_order"]))  
                {  
                     $insert_order = "  
                     INSERT INTO tbl_order(customer_id, creation_date, order_status)  
                     VALUES('1', '".date('Y-m-d')."', 'pending')  
                     ";  
                     $order_id = "";  
                     if(mysqli_query($connect, $insert_order))  
                     {  
                          $order_id = mysqli_insert_id($connect);  
                     }  
                     $_SESSION["order_id"] = $order_id;  
                     $order_details = "";  
                     foreach($_SESSION["pkbarbershop"] as $keys => $values)  
                     {  
                          $order_details .= "  
                          INSERT INTO tbl_order_details(order_id, nama_produk, deskripsi_produk, harga_produk, product_quantity)  
                          VALUES('".$order_id."', '".$values["nama_produk"]."', '".$values["deskripsi_produk"]."', '".$values["harga_produk"]."', '".$values["product_quantity"]."');  
                          ";  
                     }  
                     if(mysqli_multi_query($connect, $order_details))  
                     {  
                          unset($_SESSION["pkbarbershop"]);  
                          echo '<script>alert("You have successfully place an order...Thank you")</script>';  
                          echo '<script>window.location.href="cart.php"</script>';  
                     }  
                }  
                if(isset($_SESSION["order_id"]))  
                {  
                     $customer_details = '';  
                     $order_details = '';  
                     $total = 0;  
                     $query = '  
                     SELECT * FROM tbl_order  
                     INNER JOIN tbl_order_details  
                     ON tbl_order_details.order_id = tbl_order.order_id  
                     INNER JOIN tbl_customer  
                     ON tbl_customer.CustomerID = tbl_order.customer_id  
                     WHERE tbl_order.order_id = "'.$_SESSION["order_id"].'"  
                     ';  
                     $result = mysqli_query($connect, $query);  
                     while($row = mysqli_fetch_array($result))  
                     {  
                          $customer_details = '  
                          <label>'.$row["CustomerName"].'</label>  
                          <p>'.$row["Address"].'</p>  
                          <p>'.$row["City"].', '.$row["PostalCode"].'</p>  
                          <p>'.$row["Country"].'</p>  
                          ';  
                          $order_details .= "  
                               <tr>  
                                    <td>".$row["nama_produk"]."</td> 
                                    <td>".$row["deskripsi_produk"]."</td> 
                                    <td>".$row["product_quantity"]."</td>  
                                    <td>".$row["harga_produk"]."</td>  
                                    <td>".number_format($row["product_quantity"] * $row["harga_produk"], 0,',','.')."</td>  
                               </tr>  
                          ";  
                          $total = $total + ($row["product_quantity"] * $row["harga_produk"]);  
                     }  
                     echo '  
                     <h3 align="center">Order Summary for Order No.'.$_SESSION["order_id"].'</h3>  
                     <div class="table-responsive">  
                          <table class="table">  
                               <tr>  
                                    <td><label>Customer Details</label></td>  
                               </tr>  
                               <tr>  
                                    <td>'.$customer_details.'</td>  
                               </tr>  
                               <tr>  
                                    <td><label>Order Details</label></td>  
                               </tr>  
                               <tr>  
                                    <td>  
                                         <table class="table table-bordered">  
                                              <tr>  
                                                   <th width="50%">Product Name</th> 
                                                   <th width="50%">Deskripsi</th> 
                                                   <th width="15%">Quantity</th>  
                                                   <th width="15%">Price</th>  
                                                   <th width="20%">Total</th>  
                                              </tr>  
                                              '.$order_details.'  
                                              <tr>  
                                                   <td colspan="3" align="right"><label>Total</label></td>  
                                                   <td>'.number_format($total, 0,',','.').'</td> 
                                              </tr>  
                                         </table>  
                                    </td>  
                               </tr>  
                          </table>  
                     </div>  
                     ';  
                }  
                ?>  
           </div>  
      </body>  
 </html> 