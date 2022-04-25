
//get all health category list
if(!function_exists('android_notification')){
    function android_notification($deviceId,$deviceType,$notification,$type){
        $CI = & get_instance();
        $CI->load->database();
        if($deviceType=='android'){
            if(isset($deviceId) && !empty($deviceId)){
                $url = 'https://fcm.googleapis.com/fcm/send';
                
                if($type=="doctor"){
                    $serverApiKey = "AAAAcY4pk3o:APA91bFcLVWtHYFNRANZdG_BTOBevF9UU_9NJ6j0DVtTY8kO3diCxcy5VQvmkG10q-X98WZD515XzHQe4ar9jwZL4FgSJXxjVU3dwvmWBIpi4Owg9Q0gFzN-IqcxCo6_AA3vLZB_3DUp";
                }else{
                    $serverApiKey = "AAAA5Uh4oZU:APA91bG6_e-ol696n5nNiChzlIS-bKS4d-dQxY5NMR6cwA4uykZ2QH9KzvghwpU4eSWhL7E-ODAVUBsICLH1Ax0RWNoNOoUXIz5qb8wMfna8VAqp0urGgpLRspBRNqHJ0vyZBgNi97gA";
                }
                $deviceToken =$deviceId;
                if(!empty($deviceToken)){
                    $headers = array(
                                    'Content-Type:application/json',
                                    'Authorization:key=' . $serverApiKey
                                );
                    $data = array(
                                'registration_ids' => array($deviceToken),
                                'data' =>$notification
                            );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    $result = curl_exec($ch);
                    curl_close($ch);
                    return $result;
                }
            }
        }
    }
}

   $DrName=$providerDetails->fName." ".$providerDetails->lName;
                    $PatientName=$userDetails->fName." ".$userDetails->lName;
                    $DateTime=date('Y-m-d', $appointmentData->appointmentFrom)." ".date('G:i', $appointmentData->appointmentFrom);
                    $message = str_replace("DateTime",$DateTime,str_replace("PatientName",$PatientName,str_replace("DrName",$DrName,$this->lang->line('notification_cance_msg'))));
                    $this->common_model->updateData('notifications', array('notification'=>'Cancel Appointment', 'creatorType'=>'provider', 'message'=>$message, 'status'=>0), array('notificationFor'=>$notificationFor, 'appointmentId'=>$this->post('appointmentId')));                  
                    if($providerDetails->notificationSend==0){
                        if($providerDetails->deviceType=='android'){
                            $notification=android_notification($userDetails->deviceId,$userDetails->deviceType,$message,$type='patient');
                        }
                    }
