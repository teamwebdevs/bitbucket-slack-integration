<?php


$json = file_get_contents('php://input');

$data = json_decode($json, true);


if(isset($data['changes'])) {

    $link = $data['issue']['links']['html']['href'];
    $update = '';

    foreach($data['changes'] as $key => $value) {
        
        if($key == 'assignee') {
            
            $update .= ucfirst($key) . ' changed to ' . $value['new']['display_name'] . '\n';

        } elseif($key == 'responsible') {
            
            $update .= ucfirst($key) . ' changed to ' . $value['new']['name'] . '\n';

        }else {

            $update .= ucfirst($key) . ' changed to ' . $value['new'] . '\n';

        }

    }
    
    $payload = '{
        "username": "'.$data['repository']['name'].' Issue",
        "icon_url": "URL TO BITBUCKET ICON",
        "attachments": [{
            "fallback": "New update for issue <'.$link.'|#' . $data['issue']['id'] .'> for the repo:  *' . $data['repository']['name'] .'*",
            "color": "warning",
            "pretext": "New issue for *'. $data['repository']['name'] .'*",
            "mrkdwn_in": ["text", "pretext"],
            "fields": [
                {
                    "title": "'. $data['issue']['title'].'",
                    "value": "New update for issue <'.$link.'|#' . $data['issue']['id'] .'>",
                    "short": "true"
                },
                {
                    "title": "updates",
                    "value": "'. $update.'",
                    "short": "true"
                }
            ]
        }]
    }';
    
} elseif(isset($data['comment'])) {

    $link = $data['issue']['links']['html']['href'];

    $payload = '{
        "username": "'.$data['repository']['name'].' Issue",
        "icon_url": "https://conceptbakery.de/__dev/bitbucketIcon.jpg",
        "attachments": [{
            "fallback": "New comment <'.$link.'|#' . $data['issue']['id'] .'> for the repo:  *' . $data['repository']['name'] .'*",
            "color": "warning",
            "pretext": "New issue for *'. $data['repository']['name'] .'*",
            "mrkdwn_in": ["text", "pretext"],
            "fields": [
                {
                    "title": "'. $data['issue']['title'].'",
                    "value": "New comment <'.$link.'|#' . $data['issue']['id'] .'>",
                    "short": "true"
                },
                {
                    "title": "priority",
                    "value": "'. $data['issue']['priority'].'",
                    "short": "true"
                }
            ]
        }]
    }';

}

//set POST variables
$url = 'SLACK WEBHOOK URL';
$fields = [
        'payload' => urlencode($payload)
        ];

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);