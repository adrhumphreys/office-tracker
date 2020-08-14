# Office tracker app
The simple idea behind this is you want to track who is working from home/in the office and when.

## Tasks:
- **Sync users** (`sync-users`): This will sync the users with Slack to find the correct Usernames to send messages to
- **Message users** ('message-users`): This will send the question asking the user where they are that day

You'll need to set them up as cron tasks, I recommend the sync users once a day as users can change their username easily enough.

For the messages, again once per day is probably the way to go 

## Implemented:
- Syncs users from API into the `user` table
    - **TODO:** This has been commented out in place of a hard coded array for the initial testing of deployment
- Send a message to all users in the `user` table
- Upon response
    - Send a message to the user to say thanks
    - If sick, send a message to `office-tracker` to inform others
    - **TODO:** Stich data exists but the call to send it is commented
- **TODO:**
    - Set up cron jobs
- Create an app in slack that has been added to the work space and set up with the correct o-auth scope
    - Scope is:
        - Read channel list
        - Send direct message
        - Send channel message
        - Read users
        - Read users emails
