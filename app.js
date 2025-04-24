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
  const approvedQuery = 'SELECT * FROM tocionica WHERE reservationstatus = "approved" AND notification_sent = 0';
  connection.query(approvedQuery, (error, approvedResults) => {
    if (error) {
      console.error('Error monitoring database for approved reservations:', error);
      return;
    }

    approvedResults.forEach((row) => {
      sendNotification(row.email, row.zadatum, row.id, row.mesto, row.vrstarez, row.vremedolaska, row.brojljudi, row.ime, row.sedenje, row.mestosedenja,  'approved');
      markNotificationSent(row.id);
    });
  });
  };


// Send email notification for both approved and rejected reservations
const sendNotification = (email, zadatum, reservationId, mesto, vrstarez, vremedolaska, brojljudi, ime, sedenje, mestosedenja, status) => {
  let subject = '';
  if (status === 'approved') {
      subject = 'Potvrda rezervacije.';
  } else if (status === 'rejected') {
      subject = 'Obaveštenje o odbijenoj rezervaciji.';
  }

  const statusMessage = status === 'approved' ? 'odobrena' : 'odbijena';
  const statusColor = status === 'approved' ? '#32D57B' : '#F44336';

  const mailOptions = {
      from: 'Party M',
      to: email,
      subject: subject,
      html: `
      <!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

              <h1 style="font-size: 20px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 600; text-decoration: none; color: ${statusColor};">Vaša rezervacija je ${statusMessage}</h1>

              <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Mesto:</strong> ${mesto}</p>   
              <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Šifra rezervacije:</strong> ${reservationId}</p>  
              <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Ime rezervacije:</strong> ${ime}</p>             
              <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Datum:</strong> ${zadatum}</p> 
              <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Vreme dolaska:</strong> ${vremedolaska}</p>
              <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Broj Ljudi:</strong> ${brojljudi}</p>
              <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Vrsta rezervacije:</strong> ${vrstarez}</p>
              <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Sedenje:</strong> ${sedenje}</p>
              <p style="font-size: 15px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: rgb(207, 207, 207)93;"><strong>Mesto Sedenja:</strong> ${mestosedenja}</p>

<br>
              <!-- Start button (You can change the background colour by the hex code below) -->
              <a href="#" target="_blank" style="background-color: #000000; font-size: 15px; line-height: 22px; font-family: 'Helvetica', Arial, sans-serif; font-weight: normal; text-decoration: none; padding: 12px 15px; color: #ffffff; border-radius: 5px; display: inline-block; mso-padding-alt: 0;">


                  <span style="mso-text-raise: 15pt; color: #ffffff;">Karta Pića</span>


              </a>
              <a href="#" target="_blank" style="background-color: #000000; font-size: 15px; line-height: 22px; font-family: 'Helvetica', Arial, sans-serif; font-weight: normal; text-decoration: none; padding: 12px 15px; color: #ffffff; border-radius: 5px; display: inline-block; mso-padding-alt: 0;">


                <span style="mso-text-raise: 15pt; color: #ffffff;">Jelovnik</span>


            </a>
              <!-- End button here -->

            </td>
          </tr>
        </tbody>
      </table>
      <!-- End single column section -->
      
      <!-- Start image -->
      <a href="https://www.google.com/maps/place/%D0%A2%D0%BE%D1%87%D0%B8%D0%BE%D0%BD%D0%B8%D1%86%D0%B0+%D0%9B%D0%B8%D0%BC%D0%B0%D0%BD/@45.2425588,19.8443723,17z/data=!3m1!4b1!4m6!3m5!1s0x475b11566afa63c9:0x2febff958a5f3694!8m2!3d45.2425588!4d19.8469472!16s%2Fg%2F11jbbxdgdz?entry=ttu"><img src="https://partym.rs/SOON!!!/slike/tocmapa.jpg" style="width: 600px; max-width: 600px; height: 240px; max-height: 240px; text-align: center; border: 1px solid white;" align="center" width="600" height="240"></a>
      <!-- End image -->

      <!-- Start heading for double column section -->
      <table align="center" style="text-align: center; vertical-align: top; width: 600px; max-width: 600px; background-color: #ffffff;" width="600">
        <tbody>
          <tr>
            <td style="width: 596px; vertical-align: top; padding-left: 30px; padding-right: 30px; padding-top: 30px; padding-bottom: 0;" width="596">

              <h1 style="font-size: 20px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 600; text-decoration: none; color: #000000; margin-bottom: 0;">More Info:</h1>

            </td>
          </tr>
        </tbody>
      </table>
      <!-- End heading for double column section -->

      <!-- Start double column section -->
      <table align="center" style="text-align: center; vertical-align: top; width: 600px; max-width: 600px; background-color: #ffffff;" width="600">
        <tbody> 
            <tr>      
              <td style="width: 252px; vertical-align: top; padding-left: 30px; padding-right: 15px; padding-top: 0; padding-bottom: 30px; text-align: center;" width="252">

                <h3>Ocena:</h3>
                <p>4.5 / 5</p>
                <h3>Specijali:</h3>
                <p style="font-style: italic">"Točionica redovno osvežava jelovnik nedeljnim specijalitetima."</p>
                <h3>Prosečna cena za dvoje:</h3>
                <p>~2000 RSD.</p>
                <h3>Mogućnost plaćanja:</h3>
                <p>Gotovina/Kartica</p>
                <h3>Rad kuhinje:</h3>
                <p>Kuhinja se zatvara sat vremena pre zatvaranja lokala</p>
                <h3>Parking:</h3>
                <p>Besplatan parking u okolini lokala</p>
                <h3>Oficijalni vebsajt:</h3>
                <p><a href="https://tocionicapab.com/liman/" style="text-decoration:underline">Точионица Паб</a></p>
              
              </td>

              <td style="width: 252px; vertical-align: top; padding-left: 15px; padding-right: 30px; padding-top: 0; padding-bottom: 30px; text-align: center;" width="252">  
                <h4>Dodatno:</h4>            
                <p>Izvanredni kokteli </p>
                <p>Doručak do 13:00</p>
                <p>Pet friendly</p>
                <p>Dostava hrane</p>
                <a href="https://wolt.com/sr/srb/novi_sad/restaurant/toionica-ns" target="_blank" style="text-decoration: underline;"><p> Poruči preko Wolta</p></a>

            </td>
          </tr>
        </tbody>
      </table>
      <!-- End double column section -->

      <!-- Start image -->
      <img style="width: 600px; max-width: 600px; height: 260px; max-height: 260px; text-align: center;" alt="Image" src="https://partym.rs/SOON!!!/slike/toc123.jpg" align="center" width="600" height="240"><br><br>
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
  const query = 'UPDATE tocionica SET notification_sent = 1 WHERE id = ?';
  connection.query(query, [reservationId], (error) => {
    if (error) {
      console.error('Error marking notification as sent:', error);
    }
  });
};

// Schedule database monitoring
setInterval(monitorDatabase, 5000); // Check every 10 seconds

// Start the server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});