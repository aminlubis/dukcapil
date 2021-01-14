<?php
/*
 * To change this template, choose Tools | templates
 * and open the template in the editor.
 */

final Class Api
{

    // ================================= DASHBOARD =================================== //
    public function getApiData($link)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $link);

        // Execute post
        $result = curl_exec($ch);
        //print_r($result);die;
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        print_r(curl_error($ch));
        die;
        // do anything you want with your response
        return json_decode($result);
    }

    function postData($link, $post_data = '')
    {

        $uri = $link;
        $c = curl_init();

        curl_setopt($c, CURLOPT_URL, $uri);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $post_data);

        $result = curl_exec($c);
        curl_close($c);
        return json_decode($result);

    }

    public function send_verification_code_by_sms($config)
    {

        $this->nexmo_send_sms($config);

    }

    public function nexmo_send_sms($data)
    {

        if ($data['phone'] != '') {
            $phone = (substr($data['phone'], 0, 1) == '0') ? "62" . substr($data['phone'], 1) . "" : "" . $data['phone'] . "";

            $url = 'https://rest.nexmo.com/sms/json?' . http_build_query(
                    [
                        'api_key' => '497fe30a',
                        'api_secret' => '6b596a4e3de436a9',
                        'to' => $phone,
                        'from' => $data['from'],
                        'text' => $data['message'],
                    ]
                );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            return json_decode($response);
        } else {
            return false;
        }


    }

    public function adsmedia_send_sms($data)
    {
        if ($data['phone'] != '') {
            # code...
            $phone = (substr($data['phone'], 0, 1) == '0') ? "62" . substr($data['phone'], 1) . "" : "" . $data['phone'] . "";
            ob_start();
            // setting 
            $apikey = '859561c3134d077a0451b06e3321ed41'; // api key
            $urlserver = 'http://45.32.118.255/sms/api_sms_otp_send_json.php'; // url server sms
            $callbackurl = ''; // url callback get status sms 
            $senderid = '0'; // Option senderid 0=Sms Long Number / 1=Sms Masking/Custome Senderid

            // create header json  
            $senddata = array(
                'apikey' => $apikey,
                'callbackurl' => $callbackurl,
                'senderid' => $senderid,
                'datapacket' => array()
            );

            // create detail data json 
            // data 1
            $number = $phone;
            $message = $data['message'];
            array_push($senddata['datapacket'], array(
                'number' => trim($number),
                'message' => $message
            ));
            // sending  
            $data = json_encode($senddata);
            $curlHandle = curl_init($urlserver);
            curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data))
            );
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
            curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);
            $respon = curl_exec($curlHandle);

            $curl_errno = curl_errno($curlHandle);
            $curl_error = curl_error($curlHandle);
            $http_code = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
            curl_close($curlHandle);
            if ($curl_errno > 0) {
                $senddatax = array(
                    'sending_respon' => array(
                        'globalstatus' => 90,
                        'globalstatustext' => $curl_errno . "|" . $http_code)
                );
                $respon = json_encode($senddatax);
            } else {
                if ($http_code <> "200") {
                    $senddatax = array(
                        'sending_respon' => array(
                            'globalstatus' => 90,
                            'globalstatustext' => $curl_errno . "|" . $http_code)
                    );
                    $respon = json_encode($senddatax);
                }
            }
            header('Content-Type: application/json');
            //echo $respon;
        } else {
            return false;
        }
    }

    public function adsmedia_send_sms_blast($data)
    {
        if ($data['data'] != '') {
            # code...
            //print_r($data['data']);die;
            $i = 0;
            $no = array();
            foreach ($data['data'] as $value) {
                # code...
                $str_notlp = trim((string)$value->no_hp);
                if ($str_notlp == "-" || $str_notlp == '') {
                    $val = $value->tlp_almt_ttp;
                } else {
                    $val = $value->no_hp;
                }
                $no[$i] = (substr($val, 0, 1) == '0') ? "62" . substr($val, 1) . "" : "" . $val . "";
                //$no[$i] = $val;
                $i++;
            }

            require_once('api_sms_class_reguler_json.php'); // class  
            ob_start();
            // setting 
            $apikey = '859561c3134d077a0451b06e3321ed41'; // api key
            $ipserver = 'http://45.32.118.255'; // url server sms
            $callbackurl = ''; // url callback get status sms 

            // create header json  
            $senddata = array(
                'apikey' => $apikey,
                'callbackurl' => $callbackurl,
                'datapacket' => array()
            );

            for ($i = 0; $i < count($data['data']); $i++) {
                # code...
                $number[$i] = $no[$i];
                //$number[$i]='6281223016413';
                $message[$i] = $data['message'];
                $sendingdatetime[$i] = "";
                array_push($senddata['datapacket'], array(
                    'number' => trim($number[$i]),
                    'message' => urlencode(stripslashes(utf8_encode($message[$i]))),
                    'sendingdatetime' => $sendingdatetime[$i]));
            }

            // class sms 
            $sms = new sms_class_reguler_json();
            $sms->setIp($ipserver);
            $sms->setData($senddata);
            $responjson = $sms->send();
            header('Content-Type: application/json');
            return $responjson;
        } else {
            return false;
        }
    }

    function base_api_ws()
    {

        return 'http://10.10.10.4:88/rssm/ws_rssm/';

    }

    public function getDataWs($params)
    {

        $url = $params['link'];

        $data = $params['data'];

        try {

            $field_string = http_build_query($data);

            $options = array(
                CURLOPT_RETURNTRANSFER => true,     // return web page
                CURLOPT_HEADER => false,    // don't return headers
                CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                CURLOPT_ENCODING => "",       // handle all encodings
                CURLOPT_AUTOREFERER => true,     // set referer on redirect
                CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects
                CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
            );

            $ch = curl_init($url);
            curl_setopt_array($ch, $options);

            if (!isset($params['method'])) {

                if (!empty($data)) :
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
                endif;

            } elseif ($params['method'] == 'PUT') {

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            } elseif ($params['method'] == 'DELETE') {

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

            }
            // execute!
            $response = curl_exec($ch);
            // close the connection, release resources used

            curl_close($ch);

            // do anything you want with your response
            return json_decode($response);

        } catch (Exception $e) {

            throw new Exception($e->getMessage(), 1);

        }


    }


}