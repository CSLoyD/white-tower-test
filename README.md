# 


#Table of Contents
1. [Features Overview](#Features)
2. [Instructions](#Instructions)

## Features
- Registration Page: Users can sign up by providing their first name, last name, email, and password. Email verification is required to proceed to the landing page.
- Login Page: Users can log in using their email or username and password.
- Password-Protected Landing Page: Access to the landing page is restricted to logged-in users only. Unauthenticated users are redirected to the login page with an alert message.
- Protected Character Listing Page: Displays a paginated list of characters from the SWAPI API, including ID, name, gender, and a view link.
- Protected View Character Page: Allows users to view detailed information about a selected character, with options to save or delete the character from their saved list.
- Save Character: Users can save characters to the application database for later use.
- Delete Character: Users can remove characters from their saved list, with confirmation messages displayed after saving or deleting.
- Saved Characters: Lists all characters saved by the user, including ID, name, gender, and a view link for detailed information.

## Instructions

### Requirements
    - PHP
    - MySQL
    - Composer

### Installation
    - Open terminal on this location
    - type command "composer install"
    - dump sql on your mysql server/phpmyadmin
    - look for .env.sample, rename it to .env and input db credentials and gmail credentials
    - open this on your browser

#### Note
- Make sure you a php and mysql running and put this to your docker or xampp folder
- for ASSETVERSION in .env you can change the version if the css is not updating
- If you don't want to use gmail as the SMTP or add the credentials it will still read and use the native php mail() function but you need to put this on a server for the email to work