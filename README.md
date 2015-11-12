# bitbucket-slack-integration
This repo includes all stuff to integrate BitBucket into Slack. Including webhooks and more.


# Instructions

## New Issue Webhook

1. Move the file to the server
3. Move BitBucket logo to the server
2. Go to BitBucket repository settings and create a new webhook
3. Choose from a full list of triggers
4. Deselect “Push” / Select “Created”
5. Enter webhook URL
6. Create Slack incomming webhook integration and paste the URL in the file located on your server `$url = 'SLACK WEBHOOK URL';`
7. Paste URL to BitBucket logo into the file `"icon_url": "URL TO BITBUCKET ICON"`

## New Changes/Comments Webhook

1. Move the file to the server
3. Move BitBucket logo to the server
2. Go to BitBucket repository settings and create a new webhook
3. Choose from a full list of triggers
4. Deselect “Push” / Select “Comment created” & “Updates”
5. Enter webhook URL
6. Create Slack incomming webhook integration and paste the URL in the file located on your server `$url = 'SLACK WEBHOOK URL';`
7. Paste URL to BitBucket logo into the file `"icon_url": "URL TO BITBUCKET ICON"`