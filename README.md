# Mysql
- Check employees.sql in database folder in backend folder.
- Open terminal on your macbook and type command: PATH=$PATH:/usr/local/mysql/bin and press "enter"
- Then type command: mysql -u root -p and press "enter"
- If it asked for your password for root, you should type your password and press "enter"
- Make sure that your password for username should be match from MYSQL server
- type command: source source /Users/github/Product-Azure-PDO/database/employees.sql and press "enter"
- type command: show databases; and press "enter"
- Make sure that database name called hfr should be existed in database system.
- leaving the mysql running......


# Frontend 
- Open another Visual Code studio (VS)
- Drag this project into htdoc in XAMPP
- Click "admin" on the running of the xampp


# Operational Model
-	Rules
-	There will have three roles (Admin, Manager and user) on Web Application
-	Provide Museai administrative with an account for admin, manager and user
-	Only the admin role should have the ability to view all the information, change information and upload/remove static information.
-	The manager should be able to view the information, edit and delete on own his/her page.
-	The user should be able to view and search the information.

# Security
-	Admin should be able to access all roles accounts for security reasons
-	Both manager and user should not be able to access admin accounts
-	We will maintain session security through the use of secure web tokens
-	The museai’s url should be blocked or forbid from accessing of the hacker


Login

![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/login.PNG)


Register

![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/register_data.PNG)


Admin Role
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/admin.PNG)


Manager Role
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/manager.PNG)


User (No role)
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/attendee.PNG)


Role
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/role.PNG)


Adding New Role
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/insert_user.PNG)


Editing Role
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/edit_user.PNG)


Displaying General
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/general.PNG)


Displaying List
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/list.PNG)


Adding New Product
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/insert_product.PNG)


Editing Product
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/edit_product.PNG)


Displaying Venue
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/venue.PNG)


Adding New Venue
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/insert_venue.PNG)


Editing Venue
![Screenshot](https://github.com/ijc3093/Product-Azure-PDO/blob/master/Documents/Screen/edit_venue.PNG)




