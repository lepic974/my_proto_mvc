<?php
class SendMail
{
    /**
     * @param string email
     * @param string Contenue
     * @param string $titre email
     **/ 
    static function sendEmail(string $email, string $Content, string $titleMessage)
    {

        $header = "MIME-Version: 1.0\r\n";
        $header .= 'From:"DragonnserArt"<support@Dragonnser.com>' . "\n";
        $header .= 'Content-Type:text/html; charset="uft-8"' . "\n";
        $header .= 'Content-Transfer-Encoding: 8bit';

        $message = '
        <html>
            <body>
                <div align="center">
            
                    <br />
                    '.$Content.'
                    <br />
        
                </div>
            </body>
        </html>
        ';

        mail($email, $titleMessage, $message, $header);
    }
}
