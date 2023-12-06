# Webdev-Project
This is my endassignment for my webdevelopment course using MVC design pattern I am currently working on creating a task manager like Trello.

This repository contains a docker configuration with:
* NGINX webserver
* PHP FastCGI Process Manager with PDO MySQL support
* MariaDB (GPL MySQL fork)
* PHPMyAdmin

## Installation
1. Install Docker Desktop on Windows or Mac, or Docker Engine on Linux.
2. Clone the project

## Usage
In a terminal, run:
```bash
docker-compose up
```

NGINX will now serve files in the app/public folder. Visit localhost in your browser to check.
PHPMyAdmin is accessible on localhost:8080

If you want to stop the containers, go to Docker Desktop and click the stop button. 
Or run:
```bash
docker-compose down
```