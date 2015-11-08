# PHP Password manager

## IMPORTANT

This is just a technical test task.  
This project do **NOT** use any password encryption.  
Using it in production mode is **NOT RECOMMENDED**

## Description

This is a PHP based password manager system.  

It consists of two parts:

* A server-side PHP JSON REST API
* A client side HTML/JavaScript API client

# Usage 

## Software requirements

You must setup a PHP and MySQL first.  
PHP 5.5 recommended, minimum required 5.4.  

## Setup

Configure your MySQL details in the `app/config.json` file.

## Run

For testing you can use the PHP's built-in webserver.

To run: `php -S localhost:8000 -t web` then navigate to [http://localhost:8000](http://localhost:8000)


For production use Apache/NginX recommended.

# Password Manager

## The Brief

We would like you to create a small application for users to manage their passwords.

This application must be written using PHP and MySQL.

## Requirements

1. A user should be able to authenticate
  * Login
  * Logout
2. A logged in user should be able to
  * Create a new entry
  * See a list of all their individual entries
  * View and update their entry
  * Delete their individual entries

## Deliverables

Provide all files required by your application in order for it to work.  
Include a README file with setup and configuration instructions.

## Notes
Please don’t use any 3rd-party PHP libraries/frameworks.  
JavaScript libraries/frameworks like jQuery are fine.
