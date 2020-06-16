<?php 
        $soapUrl = "https://www.poems.co.id/primaservice/prima/prima.asmx"; // asmx URL of WSDL
       
        // xml post structure       						
		$xml_post_string = '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
							<soap:Header>
								<clsSoapHeader xmlns="http://www.phillip.co.id/">
								<UserID>PoemsUser</UserID>
								<SessionID>PoemsPwd</SessionID>
								</clsSoapHeader>
							</soap:Header>
							<soap:Body>
								<GetClientLoginDemo xmlns="http://www.phillip.co.id/">
								<_sAcctNo>DEMOPRI</_sAcctNo>
								<_sDevice>3</_sDevice>
								<_sImei>355757360211110</_sImei>
								<_sPin>311081</_sPin>
								<_sProduct>samsung;DeviceName=SM-G930L;SoftwareVersion=2.1.16;PlatformVersion=5.1.1;ConnectionUsed=WIFI</_sProduct>
								<_sPwd>134679</_sPwd>
								<_sServerID>18</_sServerID>
								<_sVer>2.1.16</_sVer>
								</GetClientLoginDemo>
							</soap:Body>
							</soap:Envelope>';				

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        //"Pragma: no-cache",
                        "SOAPAction: http://www.phillip.co.id/GetClientLoginDemo", 
                        "Content-length: ".strlen($xml_post_string),
                    ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch); 
			//$xml = simplexml_load_file($response);
			//print_r($xml);
            curl_close($ch);
            // converting
            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);
            // convertingc to XML
            $parser = simplexml_load_string($response2);	
			echo 'https://www.poems.co.id/chart/ChartHub.asp?acctno=DEMOPRI&SessionID='.$parser->GetClientLoginDemoResponse->GetClientLoginDemoResult->Session . "<br>";
            
			
    ?>