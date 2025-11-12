 <?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
if (isset($_POST["send"])) {

  $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'neomoremongx@gmail.com';   //SMTP write your email
    $mail->Password   = 'pxcosqmpbjlodmyw';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom($_POST["email"], $_POST["name"]); // Sender Email and name
    $mail->addAddress('neomoremongx@gmail.com');     //Add a recipient email  
    $mail->addReplyTo($_POST["email"], $_POST["name"]); // reply to sender email

    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject = "Food Studio Inquiry: " . $_POST["subject"];   // email subject headings
  
  // Updated email template for Food Studio
  $formattedMessage = "
<html>
<head>
    <style>
        :root {
            --primary: #121212;
            --secondary: #f5f5f5;
            --accent: #e0e0e0;
            --dark: #1e1e1e;
            --light: #f5f5f5;
            --gray: #3a3a3a;
            --border: #2a2a2a;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: var(--light);
            background-color: var(--primary);
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: linear-gradient(135deg, var(--dark), var(--primary));
            color: var(--secondary);
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            border-bottom: 3px solid var(--secondary);
        }
        
        .content {
            background: var(--dark);
            padding: 30px;
            border: 1px solid var(--border);
            border-top: none;
        }
        
        .details {
            background: var(--primary);
            padding: 25px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
        }
        
        .detail-label {
            font-weight: bold;
            color: var(--accent);
            width: 120px;
            flex-shrink: 0;
        }
        
        .detail-value {
            color: var(--secondary);
        }
        
        .footer {
            background: linear-gradient(135deg, var(--dark), var(--primary));
            color: var(--secondary);
            padding: 25px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            margin-top: 20px;
            border-top: 3px solid var(--secondary);
        }
        
        .message-content {
            background: var(--primary);
            padding: 20px;
            border-radius: 6px;
            border-left: 4px solid var(--accent);
            color: var(--secondary);
        }
    </style>
</head>
<body>
    <div class=\"header\">
        <h1>Food Studio Contact Form</h1>
        <p>New Customer Inquiry</p>
    </div>
    
    <div class=\"content\">
        <div class=\"details\">
            <div class=\"detail-row\">
                <span class=\"detail-label\">From:</span>
                <span class=\"detail-value\">{$_POST["name"]}</span>
            </div>
            
            <div class=\"detail-row\">
                <span class=\"detail-label\">Email:</span>
                <span class=\"detail-value\">{$_POST["email"]}</span>
            </div>
            
            <div class=\"detail-row\">
                <span class=\"detail-label\">Subject:</span>
                <span class=\"detail-value\">{$_POST["subject"]}</span>
            </div>
        </div>
        
        <h3 style=\"color: var(--accent);\">Message:</h3>
        <div class=\"message-content\">
            <p style=\"margin: 0; white-space: pre-line;\">{$_POST["message"]}</p>
        </div>
    </div>
    
    <div class=\"footer\">
        <p style=\"margin: 0; font-size: 14px;\">
            <strong>Food Studio Potchefstroom</strong><br>
            6 Esselen str, Potchefstroom 2520<br>
            © " . date('Y') . " Food Studio. All rights reserved.
        </p>
    </div>
</body>
</html>
";

    $mail->Body = $formattedMessage; //email message
    
    // Success sent message alert
    $mail->send();
    
    // Auto-reply to customer
    $autoReplyMail = new PHPMailer(true);

    try {
        //Server settings - same as your main email
        $autoReplyMail->isSMTP();
        $autoReplyMail->Host       = 'smtp.gmail.com';
        $autoReplyMail->SMTPAuth   = true;
        $autoReplyMail->Username   = 'neomoremongx@gmail.com';
        $autoReplyMail->Password   = 'pxcosqmpbjlodmyw';
        $autoReplyMail->SMTPSecure = 'ssl';
        $autoReplyMail->Port       = 465;

        //Recipients
        $autoReplyMail->setFrom('neomoremongx@gmail.com', 'Food Studio Potchefstroom');
        $autoReplyMail->addAddress($_POST["email"], $_POST["name"]); // Send to the customer
        $autoReplyMail->addReplyTo('eliza.elsa@gmail.com', 'Food Studio'); // Reply to restaurant email

        //Content
        $autoReplyMail->isHTML(true);
        $autoReplyMail->Subject = "Thank You for Contacting Food Studio";
        
        $autoReplyMessage = "
        <html>
        <head>
            <style>
                :root {
                    --primary: #121212;
                    --secondary: #f5f5f5;
                    --accent: #e0e0e0;
                    --dark: #1e1e1e;
                    --light: #f5f5f5;
                    --gray: #3a3a3a;
                    --border: #2a2a2a;
                }
                
                body {
                    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
                    line-height: 1.6;
                    color: var(--light);
                    background-color: var(--primary);
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
                
                .header {
                    background: linear-gradient(135deg, var(--dark), var(--primary));
                    color: var(--secondary);
                    padding: 30px;
                    text-align: center;
                    border-radius: 8px 8px 0 0;
                    border-bottom: 3px solid var(--secondary);
                }
                
                .content {
                    background: var(--dark);
                    padding: 30px;
                    border: 1px solid var(--border);
                    border-top: none;
                }
                
                .footer {
                    background: linear-gradient(135deg, var(--dark), var(--primary));
                    color: var(--secondary);
                    padding: 25px;
                    text-align: center;
                    border-radius: 0 0 8px 8px;
                    margin-top: 20px;
                    border-top: 3px solid var(--secondary);
                }
                
                .thank-you {
                    font-size: 18px;
                    color: var(--accent);
                    margin-bottom: 20px;
                    font-weight: bold;
                }
                
                .contact-info {
                    background: var(--primary);
                    padding: 20px;
                    border-radius: 6px;
                    margin: 20px 0;
                }
            </style>
        </head>
        <body>
            <div class=\"header\">
                <h1>Thank You for Contacting Food Studio!</h1>
                <p>Culinary Excellence in Potchefstroom</p>
            </div>
            
            <div class=\"content\">
                <div class=\"thank-you\">Dear {$_POST["name"]},</div>
                
                <p>Thank you for reaching out to Food Studio. We have received your inquiry and will respond as soon as possible.</p>
                
                <p><strong>We typically respond within 24 hours during our business hours.</strong></p>
                
                <div class=\"contact-info\">
                    <p><strong>Our Contact Details:</strong></p>
                    <p>Phone: 082 695 6689</p>
                    <p>Email: eliza.elsa@gmail.com</p>
                    <p>Address: 6 Esselen str, Potchefstroom 2520</p>
                </div>
                
                <p><strong>Trading Hours:</strong><br>
                Monday - Friday: 08:00 - 17:30<br>
                Saturday: 08:00 - 14:00<br>
                Sunday: Closed</p>
                
                <p>We look forward to serving you!</p>
                
                <p>Best regards,<br>
                <strong>The Food Studio Team</strong></p>
            </div>
            
            <div class=\"footer\">
                <p style=\"margin: 0; font-size: 14px;\">
                    <strong>Food Studio Potchefstroom</strong><br>
                    © " . date('Y') . " Food Studio. All rights reserved.
                </p>
            </div>
        </body>
        </html>
        ";
        
        $autoReplyMail->Body = $autoReplyMessage;
        $autoReplyMail->send();
        
    } catch (Exception $e) {
        // Optional: Log error but don't show to user to avoid confusion
        error_log("Auto-reply failed: " . $autoReplyMail->ErrorInfo);
    }

    echo
    " 
    <script> 
     alert('Message was sent successfully!');
     document.location.href = 'index.html';
    </script>
    ";
}
?>