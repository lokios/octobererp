+++++++++++++++Notification Module++++++++++++++++++++

Objective : 

1) Send notification on different channels like : device, sms, emails and iam
2) Send same notification to different set of users
3) Track notification delivery status
4) Track notification read status
5) Validate each notification with there channels and set of rules


Resure Objective :

1) Send notification with each activities to stake holders (one-to-one) like 
	- On policy status changes like suspended
	- On policy start date & policy end date
	- On policy approval
	- On policy cancel
	- On claim satellited
	- On claim amount transferred etc

2) Send notification to group of users (broadcast) like
	- Send notification to users where any new event registered in their region
	- Send notification to users on event start date who purchased policy 



Desgin :

Notification receiver address -

1) SMS & eMail : User Phone No. & Email will be sent in sms & email notification api. It will retrive form Backend user model.

2) Device : For Device notification needs to capture backend user device information. Table will have there fields : id, user_id, device_id, status, created_on, updated_on

3) IAM : Iam message will be sent on backend user_id


Device, SMS, eMail -

1) Circle : stores the members who will get the notifications. It will store users phone_no, email, device_id & user_id which required to send message. Based on message type circle memebers get notified

2) Graph : stores the message details like 
	- message type : send_email, send_sms, send_iam, send_device 
	- circle_id
	- notification details : subject, text, html, email_html, 
	- notification sender : user_id, 


IAM - 

1) IAM notification will be work on 
	- System generated notification
	- User to user notification

2) IAM notification is saved in 3 tables 
	- iam_notifications : id, type (message, alert), verb, context_id, context_type, data ({sub:'',html:''}), 
	- iam_actors : id, user_id, notification_id,
	- iam_targets : id, user_id, notification_id, status, 

- First notification will be saved in iam_notifications table with notification subject, message text, notification context id & type.
- Notification sender details will be saved in iam_actor. There will be belongs to relation with iam_notifications table
- Notification receiver details will be saved in iam_target. There will be on one to many relation with iam_notifications table
- Widget will be created to show latest notification on user dashboard. User can mark it read



