 <!-- ***** Header Aria Calling ***** -->
 <?php require 'include/header.php'; ?>
 <!-- ***** DB config Calling ***** -->
 <?php require 'config/config.php'; ?>

 <?php
    if(!isset($_SESSION['username'])){
      header("location:".APPURL."");
    }
    
    if (isset($_GET['id'])) {
      $id = $_GET['id'];

      $city = $conn->query("SELECT * FROM cities WHERE id='$id'");
      $city->execute();

      $getCity = $city->fetch(PDO::FETCH_OBJ);

      if (isset($_POST['submit'])) {
        if (empty($_POST['name'] or empty($_POST['phone_number'])) or empty($_POST['num_of_guest']) or empty($_POST['checkin_date']) or empty($_POST['destination'])) {
          echo "<script> alert('some inpute are empty'); </script> ";
        }
          else {

          $name = $_POST['name'];
          $phone_number = $_POST['phone_number'];
          $num_of_guest = $_POST['num_of_guest'];
          $checkin_date = $_POST['checkin_date'];
          $destination = $_POST['destination'];
          $status = "pending";
          $city_id = $id;
          $user_id = $_SESSION['user_id'];
          //payment perform query
          $payment = $num_of_guest * $getCity->price;
          $_SESSION['payment'] = $payment;

          if(date("Y-m-d") < $checkin_date) {

            $insert = $conn->prepare("INSERT INTO bookings (name, phone_number, num_of_guest, checkin_date, destination, status, city_id, user_id, payment) VALUES (:name, :phone_number, :num_of_guest, :checkin_date, :destination, :status, :city_id, :user_id, :payment)");
            $insert->execute([
              ":name" =>  $name,
              ":phone_number" => $phone_number,
              ":num_of_guest" => $num_of_guest,
              ":checkin_date" => $checkin_date,
              ":destination" => $destination,
              ":status" => $status,
              ":city_id" => $city_id,
              ":user_id" => $user_id,
              ":payment" => $payment,
            ]);
            header("location: pay.php");

          } else {
            echo "<script> alert('Invalide Date, pick starting from tomarrow..'); </script> ";
          }
        }
      }
    }
    else{
      header('location: 404.php');
    }
 



  ?>


 <div class="second-page-heading">
   <div class="container">
     <div class="row">
       <div class="col-lg-12">
         <h4>Book Prefered Deal Here</h4>
         <h2>Make Your Reservation <?php echo $getCity->name; ?></h2>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt uttersi labore et dolore magna aliqua is ipsum suspendisse ultrices gravida</p>
       </div>
     </div>
   </div>
 </div>

 <div class="more-info reservation-info">
   <div class="container">
     <div class="row">
       <div class="col-lg-4 col-sm-6">
         <div class="info-item">
           <i class="fa fa-phone"></i>
           <h4>Make a Phone Call</h4>
           <a href="#">+123 456 789 (0)</a>
         </div>
       </div>
       <div class="col-lg-4 col-sm-6">
         <div class="info-item">
           <i class="fa fa-envelope"></i>
           <h4>Contact Us via Email</h4>
           <a href="#">company@email.com</a>
         </div>
       </div>
       <div class="col-lg-4 col-sm-6">
         <div class="info-item">
           <i class="fa fa-map-marker"></i>
           <h4>Visit Our Offices</h4>
           <a href="#">24th Street North Avenue London, UK</a>
         </div>
       </div>
     </div>
   </div>
 </div>

 <div class="reservation-form">
   <div class="container">
     <div class="row">

       <div class="col-lg-12">
         <form id="reservation-form" method="POST" role="search" action="reservation.php?id=<?php echo $id; ?>">
           <div class="row">
             <div class="col-lg-12">
               <h4>Make Your <em>Reservation</em> Through This <em>Form</em></h4>
             </div>
             <div class="col-lg-6">
               <fieldset>
                 <label for="Name" class="form-label">Your Name</label>
                 <input type="text" name="name" class="Name" placeholder="Ex. John Smithee" autocomplete="on" required>
               </fieldset>
             </div>
             <div class="col-lg-6">
               <fieldset>
                 <label for="Number" class="form-label">Your Phone Number</label>
                 <input type="text" name="phone_number" class="Number" placeholder="Ex. +xxx xxx xxx" autocomplete="on" required>
               </fieldset>
             </div>
             <div class="col-lg-6">
               <fieldset>
                 <label for="chooseGuests" class="form-label">Number Of Guests</label>
                 <select name="num_of_guest" class="form-select" aria-label="Default select example" id="chooseGuests" onChange="this.form.click()">
                   <option type="checkbox" name="option1">1</option>
                   <option value="2">2</option>
                   <option value="3">3</option>
                   <option value="4">4</option>
                   <option value="5">5</option>
                 </select>
               </fieldset>
             </div>
             <div class="col-lg-6">
               <fieldset>
                 <label for="Number" class="form-label">Check In Date</label>
                 <input type="date" name="checkin_date" class="date" required>
               </fieldset>
             </div>
             <div class="col-lg-12">
               <fieldset>
                 <input type="hidden" value="<?php echo $getCity->name; ?>" name="destination" class="Number" placeholder="" autocomplete="on" required>
               </fieldset>
             </div>

             <div class="col-lg-12">
               <fieldset>
                 <button name="submit" type="submit" class="main-button">Make Your Reservation Pay Now</button>
               </fieldset>
             </div>
           </div>
         </form>
       </div>
     </div>
   </div>
 </div>

 <!-- ***** Footer Area Calling ***** -->
 <?php require 'include/footer.php'; ?>