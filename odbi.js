const express = require('express');
const mysql = require('mysql');
const nodemailer = require('nodemailer');

const app = express();

// Configure MySQL connection
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'Sinke008',
  database: 'rezervacije',
});

// Configure nodemailer transporter
const transporter = nodemailer.createTransport({
  service: 'gmail',
  auth: {
    user: 'partymsrb@gmail.com',
    pass: 'zmlv whao qnoy uifr',
  },
});

// Monitor database for status change
const monitorDatabase = () => {
  // Query for approved reservations
  const approvedQuery = 'SELECT * FROM tocionicaodbijene WHERE reservationstatus = "approved" AND notification_sent = 0';
  connection.query(approvedQuery, (error, approvedResults) => {
    if (error) {
      console.error('Error monitoring database for approved reservations:', error);
      return;
    }

    approvedResults.forEach((row) => {
      sendNotification(row.email, row.id, row.mesto, row.vrstarez, row.vremedolaska, row.brojljudi, row.ime, row.sedenje, row.mestosedenja,  'approved');
      markNotificationSent(row.id);
    });
  });

  // Query for rejected reservations
  const rejectedQuery = 'SELECT * FROM tocionicaodbijene WHERE reservationstatus = "rejected" AND notification_sent = 0';
  connection.query(rejectedQuery, (error, rejectedResults) => {
    if (error) {
      console.error('Error monitoring database for rejected reservations:', error);
      return;
    }

    rejectedResults.forEach((row) => {
      sendNotification(row.email, row.id, row.mesto, row.vrstarez, row.vremedolaska, row.brojljudi, row.ime, row.sedenje, row.mestosedenja, 'rejected');
      markNotificationSent(row.id);
    });
  });
};

// Send email notification for both approved and rejected reservations
const sendNotification = (email, reservationId, mesto, vrstarez, vremedolaska, brojljudi, ime, sedenje, mestosedenja, status) => {
  let subject = '';
  if (status === 'approved') {
    subject = 'Potvrda rezervacije.';
  } else if (status === 'rejected') {
    subject = 'Obaveštenje o odbijenoj rezervaciji.';
  }

  const mailOptions = {
    from: 'Party M',
    to: email,
    subject: subject,
    html: `<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    
    <head>
    
      <!--[if gte mso 9]>
      <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
      <![endif]-->
    
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="x-apple-disable-message-reformatting">
      <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
    
        <!-- Your title goes here -->
        <title>Party M</title>
        <!-- End title -->
    
        <!-- Start stylesheet -->
        <style type="text/css">
          a,a[href],a:hover, a:link, a:visited {
            /* This is the link colour */
            text-decoration: none!important;
            color: #0000EE;
          }
          .link {
            text-decoration: underline!important;
          }
          p, p:visited {
            /* Fallback paragraph style */
            font-size:15px;
            line-height:24px;
            font-family:'Helvetica', Arial, sans-serif;
            font-weight:300;
            text-decoration:none;
            color: #000000;
          }
          h1 {
            /* Fallback heading style */
            font-size:22px;
            line-height:24px;
            font-family:'Helvetica', Arial, sans-serif;
            font-weight:normal;
            text-decoration:none;
            color: #000000;
          }
          .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td {line-height: 100%;}
          .ExternalClass {width: 100%;}
        </style>
        <!-- End stylesheet -->
    
    </head>
    
      <!-- You can change background colour here -->
      <body style="text-align: center; margin: 0; padding-top: 10px; padding-bottom: 10px; padding-left: 0; padding-right: 0; -webkit-text-size-adjust: 100%;background-color: #f2f4f6; color: #000000" align="center">
      
      <!-- Fallback force center content -->
      <div style="text-align: center;">
    
    
        
        
        <!-- Start container for logo -->
        <table align="center" style="text-align: center; vertical-align: top; width: 600px; max-width: 600px; background-color: #ffffff;" width="600">
          <tbody>
            <tr>
              <td style="width: 596px; vertical-align: top; padding-left: 0; padding-right: 0; padding-top: 15px; padding-bottom: 15px;" width="596">
    
                <!-- Your logo is here -->
                <img style="width: 170px; max-width: 170px; height: 166px; max-height: 166px; text-align: center; color: #ffffff;" alt="Logo" src="https://partym.rs/SOON!!!/slike/logo2.png" align="center" width="180" height="85">
    
              </td>
            </tr>
          </tbody>
        </table>
        <!-- End container for logo -->
    
    
        <!-- Start single column section -->
        <table align="center" style="text-align: center; vertical-align: top; width: 600px; max-width: 600px; background-color: #ffffff;" width="600">
            <tbody>
              <tr>
                <td style="width: 596px; vertical-align: top; padding-left: 30px; padding-right: 30px; padding-top: 30px; padding-bottom: 40px;" width="596">
    
                  <h1 style="font-size: 20px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 600; text-decoration: none; color: darkred;">Nažalost, Vaša rezervacija je odbijena</h1><br>
    
                  <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Mesto:</strong> ${mesto}</p>   
                  <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Šifra rezervacije:</strong> ${reservationId}</p>  
                  <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Ime rezervacije:</strong> ${ime}</p>             
                  <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Vreme dolaska:</strong> ${vremedolaska}</p>
                  <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Broj Ljudi:</strong> ${brojljudi}</p>
                  <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Vrsta rezervacije:</strong> ${vrstarez}</p>
                  <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Sedenje:</strong> ${sedenje}</p>
                  <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Mesto Sedenja:</strong> ${mestosedenja}</p>
    
    <br>
                  <!-- Start button (You can change the background colour by the hex code below) -->
                
                  <!-- End button here -->
    
                </td>
              </tr>
            </tbody>
          </table>
          <!-- End single column section -->
          
          <!-- Start image -->
    
          <!-- End image -->
    
          <!-- Start heading for double column section -->
          <table align="center" style="text-align: center; vertical-align: top; width: 600px; max-width: 600px; background-color: #ffffff;" width="600">
            <tbody>
              <tr>
                <td style="width: 596px; vertical-align: top; padding-left: 30px; padding-right: 30px; padding-top: 30px; padding-bottom: 0;" width="596">
    
    
                </td>
              </tr>
            </tbody>
          </table>
    
          <img style="width: 600px; max-width: 600px; height: 300px; max-height: 300px; text-align: center;" alt="Image" src="https://partym.rs/SOON!!!/slike/toc123.jpg" align="center" width="600" height="240"><br><br>
          <!-- End image -->
    
          <!-- Start footer -->
          <table align="center" style="text-align: center; vertical-align: top; width: 600px; max-width: 600px; background-color: #000000;" width="600">
            <tbody>
              <tr>
                <td style="width: 596px; vertical-align: top; padding-left: 30px; padding-right: 30px; padding-top: 30px; padding-bottom: 30px;" width="596">
    
                  <!-- Your inverted logo is here -->
                  <img style="width: 180px; max-width: 180px; height: 166px; max-height: 166px; text-align: center; color: #ffffff;" alt="Logo" src="https://partym.rs/SOON!!!/slike/logo1.png" align="center" width="180" height="85">
    
                  <p style="font-size: 13px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: #ffffff;">
                    Created by Zaun <br>
                    All rights reserved &copy;
                    
    
                  </p>
    
                  <p style="margin-bottom: 0; font-size: 13px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: #ffffff;">
                    <a target="_blank" style="text-decoration: underline; color: #ffffff;" href="https://partym.rs/SOON!!!">
                      www.partym.rs
                    </a>
                  </p>
    
                </td>
              </tr>
            </tbody>
          </table>
          <!-- End footer -->
    
      
      </div>
    
      </body>
    
    </html>`,
  };

  transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
      console.error('Error sending email:', error);
    } else {
      console.log('Email sent:', info.response);
    }
  });
};

// Mark notification as sent in the database
const markNotificationSent = (reservationId) => {
  const query = 'UPDATE tocionicaodbijene SET notification_sent = 1 WHERE id = ?';
  connection.query(query, [reservationId], (error) => {
    if (error) {
      console.error('Error marking notification as sent:', error);
    }
  });
};

// Schedule database monitoring
setInterval(monitorDatabase, 5000); // Check every 10 seconds

// Start the server
const PORT = process.env.PORT || 3001;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});