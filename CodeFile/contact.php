<?php
    include_once'./includes/header.php';
    require_once('./includes/PHPMailer/src/Exception.php');
    require_once('./includes/PHPMailer/src/PHPMailer.php');
    require_once('./includes/PHPMailer/src/SMTP.php');

    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception; 
    $error = '';

    $mail = new PHPMailer(true);

        if(isset($_POST['send'])){
            // getting post values
            $name = $_POST['name'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            try {
                $mail->isSMTP();                            
                $mail->Host = 'smtp.gmail.com';            
                $mail->SMTPAuth = true;                
                $mail->Username = 'minh.nb.2462@aptechlearning.edu.vn';         
                $mail->Password = 'vzcp iwib iryt qmza'; 
                $mail->SMTPSecure = 'tls';  
                // $email ->SMTPSecure = PHPMailer:: ENCRYPTION_STARTTLS;   // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587; // TCP port to connect to
                $mail->CharSet = 'UTF-8';
                $mail->setFrom('minh.nb.2462@aptechlearning.edu.vn', 'Hacker Lỏ');
                $mail->addReplyTo('minh.nb.2462@aptechlearning.edu.vn', 'Hacker Lỏ');
                $mail->addAddress($email, $name);  
                $mail->isHTML(true);  // Set email format to HTML
                // $bodyContent=$message;
                // $mail->Subject =$subject;
                // $bodyContent = 'Dear'.$name;
                // $bodyContent .='<p>'.$message.'</p>';
                // $mail->Body = $bodyContent;
                // $mail -> Subject = "Thank you for contacting"; 
                $mail->Subject = 'Thằng Chó này thích chết không? Bố bốc mày lên bàn thờ giờ';
                $mail -> Body = '
                    <h1>Dear ' .$name. '</h1>
                    <div>We thank you very much and will contact you again via this email in a few minutes</div>
                    <div>
                        <img src="" style="width:200px; height: auto">
                    </div>
                        
                ';
                $mail->AltBody = strip_tags($mail->Body);
                if (!$mail->Body && !$mail->AltBody) {
                    throw new Exception('Message body empty');
                }
                // $attachtmentPath = "";
                // $mail -> addAttachment($attachtmentPath);
        
                if(!$mail->send()) {
                    echo "<script>alert('Message could not be sent.');</script>";
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    echo "<script>alert('Sent email Successfully');;
                    document.location.href = 'contact.php';</script>";
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            $id = isset($_POST['id']) ? $_POST['id'] : 0;

            if($id > 0) {
                $sqlUpdateMail = "UPDATE Contact SET name = ?, address = ?, phone = ?, email = ? WHERE id = ?";
                $stmtUpdateMail = $conn->prepare($sqlUpdateMail);
                $stmtUpdateMail->bind_param("ssssi", $name, $address, $phone, $email, $id);
                if($stmtUpdateMail->execute()){
                    echo "<script>alert('Email is updated successfully');</script>";
                } else {
                    echo "Error: ". $sqlUpdateMail. "<br>". $conn->error;
                }
            } else {
                $sqlInsert = "INSERT INTO Contact (name, address, phone, email) values (?, ?, ?, ?)";
                $stmtInsert = $conn->prepare($sqlInsert);
                $stmtInsert->bind_param("ssss", $name, $address, $phone, $email);
                if($stmtInsert->execute()){
                    echo "<script>alert('Email is added successfully');</script>";
                } else {
                    echo "Error: ". $sqlInsert. "<br>". $conn->error;
                }
            }
            echo "<script>alert('Sent email Successfully');;
            document.location.href = 'contact.php';</script>";
        }
?>
    <div class="content">
        <div class="container">
            <div class="container_trai">
                <div class="contact-info">
                    <i class="fa-solid fa-mobile"></i><span>0985811834</span>
                    <i class="fa-solid fa-location-dot"></i><span>285 đội cấn, Phường Liễu Giai, Quận Ba Đình, Hà Nội</span>
                    <i class="fa-regular fa-envelope"></i><span>thanhthanh@gmail.com</span>
                </div>
                <div class="container_form">
                    <h2>Liên Hệ Chúng Tôi</h2>
                    <form active="contact.php" method="post" id="send">
                        <table>
                            <tr class="form-group">
                                <td><label for="name">Tên:</label></td>
                                <td><input name="name" type="text" id="name" placeholder="Nhập tên của bạn"></td>
                            </tr>
                            <tr class="form-group">
                                <td><label for="address">Địa chỉ:</label></td>
                                <td><input name="address" type="text" id="address" placeholder="Nhập địa chỉ của bạn"></td>
                            </tr>
                            <tr class="form-group">
                                <td><label for="email">Email:</label></td>
                                <td><input name="email" type="email" id="email" placeholder="Nhập email của bạn"></td>
                            </tr>
                            <tr class="form-group">
                                <td><label for="phone">Số điện thoại:</label></td>
                                <td><input name="phone" type="tel" id="phone" placeholder="Nhập số điện thoại của bạn"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="buttons">
                                    <button name="send" type="submit" class="btn-secondary">Save</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <div class="container_phai">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.92440393731!2d105.81645427508101!3d21.03571058061529!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab145bf89bd7%3A0xd94a869b494c04b6!2zMjg1IFAuIMSQ4buZaSBD4bqlbiwgTGnhu4V1IEdpYWksIEJhIMSQw6xuaCwgSMOgIE7hu5lpIDEwMDAwMCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1720431193874!5m2!1svi!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
<?php include'includes/footer.php' ?>
