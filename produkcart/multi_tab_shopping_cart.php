<?php   
 session_start();  
 $connect = mysqli_connect("localhost", "root", "", "barbershop");  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | Multi Tab Shopping Cart By Using PHP Ajax Jquery Bootstrap Mysql</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <link rel="stylesheet" href="css/navbar.css"/>
           <script src="js/navbar.js"></script>
           <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" />
      </head> 
      <header>
    <nav>
        <div class="logo">
            <img src="images/pkb.jpeg" alt="image" height="80px" width="180px"/>
        </div>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Appointment</a></li>
            <li><a href="#">Informasi</a></li>
            <li><a href="#">Layanan</a></li>
            <li class="active"><a data-toggle="tab" href="#products">Produk</a></li>
            <li><a href="#">Notifikasi</a></li>
            <li><a data-toggle="tab" href="#cart">Cart <span class="badge"><?php if(isset($_SESSION["barbershop"])) { echo count($_SESSION["barbershop"]); } else { echo '0';}?></span></a></li>
        </ul>
        <div class="menu-toggle">
            <input type="checkbox"/>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
</header> 
      <body style="background-color: #15616D;">  
           <br />  
           <div class="container" style="width:800px;">  
                <h3 align="center"></h3><br />  
                 
                <div class="tab-content">  
                     <div id="products" class="tab-pane fade in active">  
                     <?php  
                     $query = "SELECT * FROM produk ORDER BY id_produk ASC";  
                     $result = mysqli_query($connect, $query);  
                     while($row = mysqli_fetch_array($result))  
                     {  
                     ?>  
                     <div class="col-md-4" style="margin-top:12px;">  
                          <div style="border:1px solid #333; background-color:#FF7D00; border-radius:5px; padding:16px; height:350px;" align="center">  
                              <input type="hidden" name="id_produk" id="id_produk" value="<?php echo $row["id_produk"]; ?>" /> 
                               <img src="images/<?php echo $row["gambar"]; ?>" class="img-responsive" /><br />  
                               <h4 class="text-dark"><?php echo $row["nama_produk"]; ?></h4>  
                               <h4 class="text-dark">Rp. <?php echo $row["harga_produk"]; ?></h4>  
                               <input type="number" name="quantity" id="quantity<?php echo $row["id_produk"]; ?>" class="form-control" value="1" />  
                               <input type="hidden" name="hidden_name" id="nama_produk<?php echo $row["id_produk"]; ?>" value="<?php echo $row["nama_produk"]; ?>" />  
                               <input type="hidden" name="hidden_desc" id="deskripsi_produk<?php echo $row["id_produk"]; ?>" value="<?php echo $row["deskripsi_produk"]; ?>" />
                               <input type="hidden" name="hidden_price" id="harga_produk<?php echo $row["id_produk"]; ?>" value="<?php echo $row["harga_produk"]; ?>" />  
                               <input type="button" name="add_to_cart" id="<?php echo $row["id_produk"]; ?>" style="margin-top:5px;" class="btn btn-primary form-control add_to_cart" value="Add to Cart" />  
                          </div>  
                     </div>  
                     <?php  
                     }  
                     ?>  
                     </div>  <div id="cart" class="tab-pane fade">  
                          <div class="table-responsive" id="order_table" style="background-color: #FFECD1">  
                               <table class="table table-bordered" >  
                                    <tr>  
                                         <th width="40%">Product Name</th>
                                         <th width="40%">Deskripsi</th>  
                                         <th width="10%">Quantity</th>  
                                         <th width="20%">Price</th>  
                                         <th width="15%">Total</th>  
                                         <th width="5%">Action</th>  
                                    </tr>  
                                    <?php  
                                    if(!empty($_SESSION["barbershop"]))  
                                    {  
                                         $total = 0;  
                                         foreach($_SESSION["barbershop"] as $keys => $values)  
                                         {                                               
                                    ?>  
                                    <tr>  
                                         <td><?php echo $values["nama_produk"]; ?></td>
                                         <td><?php echo $values ["deskripsi_produk"] ; ?></td>  
                                         <td><input type="text" name="quantity[]" id="quantity<?php echo $values["id_produk"]; ?>" value="<?php echo $values["product_quantity"]; ?>" data-id_produk="<?php echo $values["id_produk"]; ?>" class="form-control quantity" /></td>  
                                         <td align="right">Rp.  <?php echo $values["harga_produk"]; ?></td>  
                                         <td align="right">Rp.  <?php echo number_format($values["product_quantity"] * $values["harga_produk"], 0,',','.'); ?></td>  
                                         <td><button name="delete" class="btn btn-danger btn-xs delete" id="<?php echo $values["id_produk"]; ?>">Remove</button></td>  
                                    </tr>  
                                    <?php  
                                              $total = $total + ($values["product_quantity"] * $values["harga_produk"]);  
                                         }  
                                    ?>  
                                    <tr>  
                                         <td colspan="3" align="right">Total</td>  
                                         <td align="right">Rp. <?php echo number_format($total,0,',','.');?></td>  
                                         <td></td>  
                                    </tr>  
                                    <tr>  
                                         <td colspan="5" align="center">  
                                              <form method="post" action="cart.php">  
                                                   <input type="submit" name="place_order" class="btn btn-warning" value="Place Order" />  
                                              </form>  
                                         </td>  
                                    </tr>  
                                    <?php  
                                    }  
                                    ?>  
                               </table>  
                          </div>  
                     </div>  
                </div>  
           </div>  
      </body> 
      <footer class="footer">
        <div class="footer-left">
            <h3>Pak Kumis <br>Barbershop</h3>
        </div>
        <div class="footer-center">
			<p>
                <span style="font-size:18px"><b>Hubungi Kami</b></span>
            </p>
			<div>
                <img src="images/wa.png" class="fa fa-phone" height="30px" width="30px"></i>
                <p>+6285156968495</p>
            </div>
            <div>
                <img src="images/gmail.png" class="fa fa-envelope" height="40px" width="40px"></i>
                <p><a href="#">pakumis@gmail.com</a></p>
            </div>
            <div>
                <img src="images/map.png" class="fa fa-map-marker" height="80px" width="80px"></i>
                <p><span>Balige</span>Jl. Kartini Atas Balige, Kabupaten Toba, Sumatera Utara</p>
            </div>	
        </div>

        <div class="footer-right">
            <p class="footer-about">
                <span>Social Media</span>
            </p>
            <div class="footer-media">
				<a href="#"><img src="images/ig.png" class="fa fa-instagram" height="30px" width="30px"></i></a>
                <a href="#"><img src="images/fb.png" class="fa fa-facebook" height="30px" width="30px"></i></a>
            </div>
        </div>
		<center><p class="footer-copyright">Copyright Team 4 PSW II Institut Teknologi Del 2022</p></center>
    </footer>
   
 <script>  
 $(document).ready(function(data){  
      $('.add_to_cart').click(function(){  
           var id_produk = $('#id_produk').val();  
           var nama_produk = $('#nama_produk'+id_produk).val(); 
           var deskripsi_produk = $('#deskripsi_produk'+id_produk).val(); 
           var harga_produk = $('#harga_produk'+id_produk).val();  
           var product_quantity = $('#quantity'+id_produk).val();  
           var action = "add";  
           if(product_quantity > 0)  
           {  
                $.ajax({  
                     url:"action.php",  
                     method:"POST",  
                     dataType:"json",  
                     data:{  
                          id_produk:id_produk,
                          deskripsi_produk:deskripsi_produk,   
                          nama_produk:nama_produk,   
                          harga_produk:harga_produk,   
                          product_quantity:product_quantity,   
                          action:action  
                     },  
                     success:function(data)  
                     {  
                          $('#order_table').html(data.order_table);  
                          $('.badge').text(data.cart_item);  
                          alert("Product has been Added into Cart");  
                     }  
                });  
           }  
           else  
           {  
                alert("Please Enter Number of Quantity")  
           }  
      });  
      $(document).on('click', '.delete', function(){  
           var id_produk = $(this).attr("id_produk");  
           var action = "remove";  
           if(confirm("Are you sure you want to remove this product?"))  
           {  
                $.ajax({  
                     url:"action.php",  
                     method:"POST",  
                     dataType:"json",  
                     data:{id_produk:id_produk, action:action},  
                     success:function(data){  
                          $('#order_table').html(data.order_table);  
                          $('.badge').text(data.cart_item);  
                     }  
                });  
           }  
           else  
           {  
                return false;  
           }  
      });  
      $(document).on('keyup', '.quantity', function(){  
           var id_produk = $(this).data("id_produk");  
           var quantity = $(this).val();  
           var action = "quantity_change";  
           if(quantity != '')  
           {  
                $.ajax({  
                     url :"action.php",  
                     method:"POST",  
                     dataType:"json",  
                     data:{id_produk:id_produk, quantity:quantity, action:action},  
                     success:function(data){  
                          $('#order_table').html(data.order_table);  
                     }  
                });  
           }  
      });  
 });  
 </script>
</html>